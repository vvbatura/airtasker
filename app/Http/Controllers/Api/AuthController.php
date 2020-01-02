<?php

namespace App\Http\Controllers\Api;

use App\Constants\SystemConstants;
use App\Constants\UserConstants;
use App\Http\Requests\Auth\CheckTokenEmail;
use App\Http\Requests\Auth\ForgotPasswordEmailRequest;
use App\Http\Requests\Auth\ForgotPasswordPhoneRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterFormRequest;
use App\Http\Requests\Auth\ResetPasswordFormRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Models\NotificationAction;
use App\Notifications\Auth\ForgotPasswordUser;
use App\Notifications\Auth\LoginUserSuccess;
use App\Notifications\Auth\LogoutUserSuccess;
use App\Notifications\Auth\ResetPasswordSuccess;
use App\Notifications\Auth\VerificationUser;
use App\Notifications\Auth\VerificationUserSuccess;
use App\Traits\NexmoTrait;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\User\UserResource;
use App\User;

class AuthController extends BaseController
{
    use NexmoTrait;

    public function __construct()
    {
        $this->middleware('auth:api')->only(['me', 'logout', 'refresh']);
    }

    public function TestSms ()
    {
        $message = $this->sendSMS('380983091243', 'Hello from my WEB.');
        //$message = $this->sendSMS('4917632281828', 'Hello from WEB.');

        dd($message);
    }

    public function register(RegisterFormRequest $request)
    {
        $data =$request->except(['location', 'locale']);
        $data['verify_token'] = User::makeHash();
        $locale = $request->get('locale', SystemConstants::LANGUAGE_EN);

        DB::beginTransaction();

        try {
            $user = User::create($data);
            $user->assignRole(UserConstants::ROLE_CLIENT);
            $user->_location()->create($request->get('location'));

            try {
                $user->notify((new VerificationUser($user, $user->getAttribute('verify_token')))->locale($locale));
            } catch (\Exception $e) {
                Log::error('Exception notify registered user: ', ['exception' => $e]);
            }

            DB::commit();
            return $this->sendResponse('Successfully registered.', new UserResource($user));

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Exception registered user: ', ['exception' => $e]);
            return $this->sendError('Cannot registered user.', [], 409);
        }
    }

    public function verify(VerifyRequest $request)
    {
        $token = $request->get('token');
        $locale = $request->get('locale', SystemConstants::LANGUAGE_EN);

        if (!$user = User::where('verify_token', $token)->first()) {
            return $this->sendError('Verify token is not valid.', [], 400);
        }

        DB::beginTransaction();

        try {
            $user->update([
                'verify_token' => null,
                'verified_at' => Carbon::now(),
            ]);
            $user->_profile()->create();
            $user->_actions()->attach(NotificationAction::get()->pluck('id')->toArray());

            try {
                $user->notify((new VerificationUserSuccess($user))->locale($locale));
            } catch (\Exception $e) {
                Log::error('Exception notify verified user: ', ['exception' => $e]);
            }

            DB::commit();
            return $this->sendResponse('Email was successful verified.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Exception verified user: ', ['exception' => $e]);
            return $this->sendError('Cannot verified user.', [], 409);
        }
    }

    protected function forgotPassword(FormRequest $request, $field)
    {
        $$field = $request->get($field);
        $locale = $request->get('locale', SystemConstants::LANGUAGE_EN);

        $resetTable = DB::table('password_resets');
        $resetToken = User::makeHash();

        try {
            if ($resetTable->where($field, $$field)->first()) {

                $resetTable->update(['token' => $resetToken, 'created_at' => Carbon::now()]);
            } else {
                $resetTable->insert([
                    $field => $$field,
                    'token' => $resetToken,
                    'created_at' => Carbon::now()
                ]);
            }

            $user = User::where($field, $$field)->first();

            try {
                $user->notify((new ForgotPasswordUser($user, $resetToken, $field))->locale($locale));
            } catch (\Exception $e) {
                Log::error('Exception notify forgot password user: ', ['exception' => $e]);
            }

            return $this->sendResponse('Link to reset password was send.');

        } catch (\Exception $e) {
            Log::error('Exception send link to reset password: ', ['exception' => $e]);
            return $this->sendError('Cannot send link to reset password.', [], 409);
        }
    }

    public function forgotPasswordEmail(ForgotPasswordEmailRequest $request)
    {

        return $this->forgotPassword($request, 'email');
    }

    public function forgotPasswordPhone(ForgotPasswordPhoneRequest $request)
    {

        return $this->forgotPassword($request, 'phone');
    }

    public function checkTokenEmail (CheckTokenEmail $request)
    {
        $token = $request->get('token');
        $resetTable = DB::table('password_resets');

        if (!$resetPassword = $resetTable->where('token', $token)->first()) {
            return $this->sendError('Reset token is not valid.', [], 400);
        }
        return $this->sendResponse('Reset token verified.');
    }

    public function resetPassword(ResetPasswordFormRequest $request)
    {
        $token = $request->get('token');
        $resetTable = DB::table('password_resets');
        $locale = $request->get('locale', SystemConstants::LANGUAGE_EN);

        if (!$resetPassword = $resetTable->where('token', $token)->first()) {
            return $this->sendError('Token is not valid.', [], 400);
        }
        try {
            $queryField = $resetPassword->email ? [ 'email' => $resetPassword->email ] : [ 'phone' => $resetPassword->phone ];
            $user = User::where($queryField)->first();
            app('auth.password.broker')->deleteToken($user);

            $user->password = $request->get('password');
            $user->save();

            try {
                $user->notify((new ResetPasswordSuccess($user))->locale($locale));
            } catch (\Exception $e) {
                Log::error('Exception notify changed password user: ', ['exception' => $e]);
            }

            return $this->sendResponse('Password successfully changed.');

        } catch (\Exception $e) {
            Log::error('Exception changed password user: ', ['exception' => $e]);
            return $this->sendError('Cannot changed password user.', [], 409);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->all(['email', 'password']);
        $locale = $request->get('locale', SystemConstants::LANGUAGE_EN);

        $user = $this->getUser($credentials);

        if (!$user) {
            return $this->sendError('Bad request.', [], 400);
        }
        if (!$user->isVerifiedAccount()){
            return $this->sendError('Email not verified.', [], 401);
        };
        if (!$user->isActiveAccount()){
            return $this->sendError('Account not active', [], 401);
        };

        if ($token = $this->guard()->attempt($credentials)) {
            try {
                $user->notify((new LoginUserSuccess($user))->locale($locale));
            } catch (\Exception $e) {
                Log::error('Exception notify login user: ', ['exception' => $e]);
            }

            return $this->sendResponse('Successfully logged in.', [], ['Authorization' => $token]);
        }

        return $this->sendError('Forbidden.', [], 403);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = $this->guard()->user();

        return $this->sendResponse('User data' , new UserResource($user));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(LogoutRequest $request)
    {
        $locale = $request->get('locale', SystemConstants::LANGUAGE_EN);
        $user = $this->guard()->user();
        try {
            $user->notify((new LogoutUserSuccess($user))->locale($locale));
        } catch (\Exception $e) {
            Log::error('Exception notify logged user: ', ['exception' => $e]);
        }

        $this->guard()->logout();

       return $this->sendResponse('Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->sendResponse('Successfully refreshed in.', [], ['Authorization' => $token]);
    }

    protected function getUser ($credentials)
    {

        $user = User::where("email", $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $user;
        }

        return null;
    }

}

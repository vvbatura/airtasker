<?php

namespace App\Http\Controllers\Api;

use App\ConfigProject\Constants;
use App\Http\Requests\Auth\CheckTokenEmail;
use App\Http\Requests\Auth\ForgotPasswordEmailRequest;
use App\Http\Requests\Auth\ForgotPasswordPhoneRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterFormRequest;
use App\Http\Requests\Auth\ResetPasswordFormRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Mail\Auth\ForgetPasswordUserMail;
use App\Mail\Auth\VerificationUserEmail;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\User\UserResource;
use App\User;

class AuthController extends BaseController
{
    protected $client;
    public function __construct()
    {
        $this->middleware('auth:api')->only(['me', 'logout', 'refresh']);

        $basic  = new \Nexmo\Client\Credentials\Basic(env('NEXMO_CLIENT_KEY'), env('NEXMO_CLIENT_SECRET'));
        $this->client = new \Nexmo\Client($basic);
    }

    protected function sendSMS ($number, $message)
    {
        $message = $this->client->message()->send([
            'to' => $number,
            'from' => 'AirTasker',
            'text' => $message
        ]);
    }

    public function TestSms ()
    {
        $message = $this->sendSMS('380983091243', 'Hello from WEB.');
        //$message = $this->sendSMS('4917632281828', 'Hello from WEB.');

        dd($message);
    }

    public function register(RegisterFormRequest $request)
    {
        $data =$request->except('location');
        $data['verify_token'] = User::makeHash();

        DB::beginTransaction();

        try {
            $user = User::create($data);
            $user->assignRole(Constants::ROLE_CLIENT);
            $user->_location()->create($request->only('location')['location']);

            Mail::to($user->email)->queue(new VerificationUserEmail($user, $user->getAttribute('verify_token')));

            /*try {
                $this->sendSMS($user->phone, $user->verify_token);
            } catch (\Exception $e) {
                Log::error('Exception send SMS: ', ['exception' => $e]);
            }*/

            DB::commit();
            return $this->sendResponse('Successfully register.', new UserResource($user));

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Exception create user: ', ['exception' => $e]);
            return $this->sendError('Cannot create user.', [], 409);
        }
    }

    public function verify(VerifyRequest $request)
    {
        $token = $request->get('token');
        if (!$user = User::where('verify_token', $token)->first()) {
            return $this->sendError('Verify token is not valid.', [], 400);
        }

        DB::beginTransaction();

        try {
            $user->update([
                'verify_token' => null,
                'verify_type' => $type,
                'verified_at' => Carbon::now()->timestamp,
            ]);
            $user->_profile()->create();

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

            if ($field == 'email') {
                Mail::to($$field)->queue(new ForgetPasswordUserMail($resetToken, $$field));

                return $this->sendResponse('Verified email was send.');
            } else {
                try {
                    $message = $this->sendSMS($$field, $resetToken);

                    return $this->sendResponse('Verified SMS was send.');

                } catch (\Exception $e) {
                    Log::error('Exception send SMS: ', ['exception' => $e]);
                }
            }

        } catch (\Exception $e) {
            Log::error('Exception send verified emails: ', ['exception' => $e]);
            return $this->sendError('Cannot send verified email.', [], 409);
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

    protected function resetPassword(ResetPasswordFormRequest $request)
    {
        $token = $request->get('token');
        $resetTable = DB::table('password_resets');

        if (!$resetPassword = $resetTable->where('token', $token)->first()) {
            return $this->sendError('Token is not valid.', [], 400);
        }
        try {
            $queryField = $resetPassword->email ? [ 'email' => $resetPassword->email ] : [ 'phone' => $resetPassword->phone ];
            $user = User::where($queryField)->first();
            app('auth.password.broker')->deleteToken($user);

            $user->password = $request->get('password');
            $user->save();

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
    public function logout()
    {
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

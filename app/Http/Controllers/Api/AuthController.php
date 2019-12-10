<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterFormRequest;
use App\Http\Requests\Auth\ResetPasswordFormRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Mail\Auth\ForgetPasswordUserMail;
use App\Mail\Auth\VerificationUserEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\User\UserResource;
use App\User;

class AuthController extends BaseController
{
    protected $client;
    public function __construct()
    {
        $this->middleware('auth:api')->only(['me', 'logout', 'refresh']);

        $basic  = new \Nexmo\Client\Credentials\Basic('f828df3c', 'z9OS0zX0hynIXeUr');
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
        $message = $this->sendSMS('380983091243', 'Hello from Nexmo.');

        dd($message);
    }

    public function register(RegisterFormRequest $request)
    {
        $data =$request->validated();
        $data['verify_token'] = User::makeHash();

        DB::beginTransaction();

        try {
            $user = User::create($data);

            Mail::to($user->email)->queue(new VerificationUserEmail($user, $user->getAttribute('verify_token')));

            $this->sendSMS($user->phone, $user->verify_token);

            DB::commit();
            return $this->sendResponse('Successfully register.', new UserResource($user));

        } catch (\Exception $e) {

            DB::rollback();
            return $this->sendError('Cannot create user.', [], 409);
        }
    }

    public function verify(VerifyRequest $request)
    {
        $token = $request->get('token');
        $type = $request->get('type');
        if (!$user = User::where('verify_token', $token)->first()) {
            return $this->sendError('Cannot find user by verify token.', [], 400);
        }

        DB::beginTransaction();

        try {
            $user->update([
                'verify_token' => null,
                'verify_type' => $type,
                'verified_at' => Carbon::now()->timestamp,
            ]);
            $user->assignRole(User::ROLE_CLIENT);
            $user->_profile()->create();

            DB::commit();
            return $this->sendResponse('Email was successful verified.');

        } catch (\Exception $e) {

            DB::rollback();
            return $this->sendError('Cannot verified user.', [], 409);
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $email = $request->get('email');
        $resetTable = DB::table('password_resets');
        $resetToken = User::makeHash();

        try {
            if ($resetTable->where('email', $email)->first()) {

                $resetTable->update(['token' => $resetToken, 'created_at' => Carbon::now()]);
            } else {
                $resetTable->insert([
                    'email' => $email,
                    'token' => $resetToken,
                    'created_at' => Carbon::now()
                ]);
            }

            Mail::to($email)->queue(new ForgetPasswordUserMail($resetToken, $email));

            return $this->sendResponse('Verified email was send.');

        } catch (\Exception $e) {

            return $this->sendError('Cannot send verified email.', [], 409);
        }
    }

    public function resetPassword(ResetPasswordFormRequest $request)
    {
        $email = $request->get('email');
        $token = $request->get('token');
        $resetTable = DB::table('password_resets');

        try {
            if ($resetTable->where([['email', $email], ['token', $token]])->first()) {
                $user = User::where('email', $email)->first();
                app('auth.password.broker')->deleteToken($user);

                $user->password = $request->get('password');
                $user->save();

                return $this->sendResponse('Password successfully changed.');

            } else {

                return $this->sendError('Not found email or token.');
            }
        } catch (\Exception $e) {

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

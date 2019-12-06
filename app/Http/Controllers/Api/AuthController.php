<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterFormRequest;
use App\Http\Requests\Auth\ResetPasswordFormRequest;
use App\Mail\Auth\ForgetPasswordUserMail;
use App\Mail\Auth\VerificationUserEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\User\UserResource;
use App\User;
use Illuminate\Support\Str;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['me', 'logout', 'refresh']);
    }

    public function register(RegisterFormRequest $request)
    {
        $user = User::create($request->all());
        $user->generateVerifyToken();
        $user->save();

        Mail::to($user->email)->queue(new VerificationUserEmail($user, $user->getAttribute('verify_token')));

        return $this->sendResponse('Successfully register', new UserResource($user));
    }

    public function verify($token)
    {
        if (!$user = User::where('verify_token', $token)->first()) {
            $this->sendError('Cannot find user by verify token', [], 401);
        }

        $user->setAttribute('verify_token', null);
        $user->setAttribute('email_verified_at', Carbon::now()->timestamp);
        $user->assignRole(User::ROLE_CLIENT);
        $user->save();

        $this->sendResponse('Email was successful verified');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $email = $request->get('email');
        $resetTable = DB::table('password_resets');
        $resetToken = Str::random(60);
        $hasToken = $resetTable->where('email', $email)->first();

        if ($hasToken) {
            $resetTable->update(['token' => $resetToken, 'created_at' => Carbon::now()]);
        } else {
            $resetTable->insert([
                'email' => $email,
                'token' => $resetToken,
                'created_at' => Carbon::now()
            ]);
        }

        Mail::to($email)->queue(new ForgetPasswordUserMail($resetToken, $email));

        return $this->sendResponse('Verified email was send');
    }

    public function resetPassword(ResetPasswordFormRequest $request)
    {
        $email = $request->get('email');
        $token = $request->get('token');
        $resetTable = DB::table('password_resets');

        if ($resetTable->where([['email', $email], ['token', $token]])->first()) {
            $user = User::where('email', $email)->first();
            app('auth.password.broker')->deleteToken($user);

            $user->password = $request->get('password');
            $user->save();

            return $this->sendResponse('Password successfully changed');
        }else{
            return $this->sendError('Not found email or token');
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
        if(!$user->hasVerifiedAccount()){
            return $this->sendError('Email not verified.', [], 401);
        };
        if(!$user->isActiveAccount()){
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

    private function getUser ($credentials)
    {

        $user = User::where("email", $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $user;
        }

        return null;
    }
}

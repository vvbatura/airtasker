<?php

namespace App\Http\Controllers\Api;

use App\Models\AuthProvider;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class AuthProviderController extends BaseController
{

    public function redirectToProvider ($provider)
    {

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {

        try {
            $socialUser = Socialite::driver($provider)->user();

        } catch (\Exception $e) {

            return redirect('/login');
        }

        $user = $this->findOrCreateUser($provider, $socialUser);
        $token = $this->guard()->fromUser($user);

        if ($token) {
            return view('auth.callback', [
                'token' => $token,
                'token_type' => 'bearer',
            ]);
        }

        return $this->sendError('Bad request.', [], 400);
    }

    protected function findOrCreateUser($provider, $socialUser)
    {
        $authProvider = AuthProvider::with('_user')
            ->where('provider', $provider)
            ->where('provider_user_id', $socialUser->getId())
            ->first();

        if ($authProvider) {

            return $authProvider->_user;
        }

        if ($user =User::where('email', $socialUser->getEmail())->first()) {

            return $user;
        }

        return $this->createUser($provider, $socialUser);
    }

    protected function createUser($provider, $socialUser)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'first_name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'verify_type' => User::VERIFY_SOCIAL,
                'verified_at' => Carbon::now()->timestamp,
            ]);

            $user->assignRole(User::ROLE_CLIENT);
            $user->_profile()->create();

            $user->_socials()->create([
                'provider' => $provider,
                'provider_user_id' => $socialUser->getId(),
                'access_token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken,
            ]);

            DB::commit();
            return $user;

        } catch (\Exception $e) {

            DB::rollback();
            return $this->sendError('Something went wrong.', [], 409);
        }

    }
}

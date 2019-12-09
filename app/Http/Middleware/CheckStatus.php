<?php

namespace App\Http\Middleware;

use App\Traits\JWTUserTrait;
use App\User;
use Closure;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class CheckStatus extends BaseMiddleware
{
    use JWTUserTrait;

    public function handle($request, Closure $next)
    {
        /** @var \App\User $user */
        $user = $this->getUser();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized.'
            ], 401);
        }

        if(!$user->hasVerifiedEmail()){
            return response()->json([
                'message' => 'Email not verified',
                'status' => 'error'
            ], 403);
        };

        if ($user->status !== User::STATUS_BLOCK ) {
            return $next($request);
        }else {
            return response()->json([
                'message' => 'Account banned',
                'status' => 'error'
            ], 418);
        }
    }
}

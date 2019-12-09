<?php

namespace App\Http\Middleware;

use App\Traits\JWTUserTrait;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTMiddleware extends BaseMiddleware {

    use JWTUserTrait;

    public function handle($request, \Closure $next) {

        $user = $this->getUser();

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized.'
            ], 401);
        }

        return $next($request);
    }



}

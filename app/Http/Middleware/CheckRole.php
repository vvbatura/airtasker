<?php

namespace App\Http\Middleware;

use App\Traits\JWTUserTrait;
use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class CheckRole extends BaseMiddleware
{
    use JWTUserTrait;

    public function handle($request, Closure $next, $role)
    {
        $user = $this->getUser();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized.'
            ], 401);
        }

        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        if (!$user->hasAnyRole($roles)) {
            throw UnauthorizedException::forRoles($roles);
        }

        return $next($request);
    }
}

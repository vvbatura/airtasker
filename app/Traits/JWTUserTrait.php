<?php

namespace App\Traits;

use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

trait JWTUserTrait
{
    public function getUser()
    {
        try {
            $user = $this->auth->parseToken()->authenticate();

            return $user;

        } catch (TokenExpiredException $t) {

            try {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Token expired.'
                ], 401);

            } catch (TokenBlacklistedException $e) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Token blacklisted'
                ], 401);

            } catch (Exception $e) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Something bad happened.'
                ], 409);
            }

        } catch (JWTException $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized.'
            ], 401);

        } catch (Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Something bad happened.'
            ], 409);

        }
    }

}

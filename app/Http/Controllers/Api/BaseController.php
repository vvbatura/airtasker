<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{

    const ERROR_STATUS = 'error';
    const SUCCESS_STATUS = 'success';

    /**
     * success response method.
     *
     * @param array $data
     * @param string $message
     * @param array $headers
     * @return JsonResponse
     */
    public function sendResponse(string $message, $data = [], array $headers = []): JsonResponse
    {
        $response = [
            'status' => self::SUCCESS_STATUS,
            'message' => $message,
        ];

        if(!empty($data)){
            $response['data'] = $data;
        }

        $response = response()->json($response, 200);

        $this->addHeaders($response, $headers);

        return $response;
    }

    /**
     * return error response.
     *
     * @param string $error
     * @param array $data
     * @param int $code
     * @param array $headers
     * @return JsonResponse
     */
    public function sendError(string $error, array $data = [], int $code = 404, array $headers = []): JsonResponse
    {
        $response = [
            'status' => self::ERROR_STATUS,
            'message' => $error,
        ];

        if(!empty($data)){
            $response['data'] = $data;
        }

        $response = response()->json($response, $code);

        $this->addHeaders($response, $headers);

        return $response;
    }

    /**
     * @param $response
     * @param array $headers
     * @param bool $replace
     */
    protected function addHeaders($response, array $headers, bool $replace = true): void
    {
        foreach ($headers as $key => $value) {
            /** @var \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory $response */
            $response->header($key, $value, $replace);
        }
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
}

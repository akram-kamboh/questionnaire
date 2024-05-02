<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * success response for AJAX requests
     * @param $message
     * @param array $data
     * @param null $responseCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($message, $data = [], $responseCode = Response::HTTP_OK)
    {
        return response()->json(['status' => true, 'message' => $message, 'result' => $data], $responseCode);
    }

    /**
     * error response for AJAX requests
     * @param $message
     * @param array $data
     * @param null $responseCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message = null, $data = [], $responseCode = Response::HTTP_BAD_REQUEST)
    {
        return response()->json(['status' => false, 'error' => $message, 'result' => $data], $responseCode);
    }
}

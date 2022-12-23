<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($code, $status, $message, $data, $token = '')
    {
        return response()->json([
            'code' => $code,
            'status' => $status,
            'data' => $data,
            'message' => $message,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], $code);
    }

    public function sendError($status, $message, $data, $token = '') {

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]

        ], $status);

    }
}

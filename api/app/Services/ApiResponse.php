<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public function success($data, int $code = 200): JsonResponse
    {
        $body = [
            'data' => $data,
            'success' => true,
            'status' => $code,
        ];

        return response()->json($body, $code);
    }

    public function failed($message, int $code = 500): JsonResponse
    {
        $body = [
            'success' => false,
            'message' => $message,
            'status' => $code,
        ];

        return response()->json($body, $code);
    }
}

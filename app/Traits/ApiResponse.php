<?php

namespace App\Traits;

trait ApiResponse
{
    
    protected function successResponse($data, string $message = '', int $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function notFoundResponse(string $message = 'Resource not found')
    {
        return $this->errorResponse($message, 404);
    }
    protected function Unauthorized(string $message = 'No autorizado')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 401);
    }
}
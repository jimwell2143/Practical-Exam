<?php

namespace App\Traits;

trait ApiResponse
{
    public function successResponse($message, $code)
    {
        return response()->json(['message' => $message], $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json($this->errorArray($message, $code), $code);
    }

    private function errorArray($message, $code)
    {
        return [
            'errors' => [
                'message' => $message,
                'code' => $code
            ]
        ];
    }
}

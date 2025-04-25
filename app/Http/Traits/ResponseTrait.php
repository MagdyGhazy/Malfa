<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    public function success($data = null, $code = 200, $message = 'Request was successful'): JsonResponse
    {
        return $this->generateResponse(true, $data, $code, $message);
    }


    public function error($data = null, $code = 400, $message = 'There was an error with your request', $errors = []): JsonResponse
    {
        return $this->generateResponse(false, $data, $code, $message, $errors);
    }


    private function generateResponse(bool $isSuccess, $data = null, int $code = 200, string $message = null, $errors = null): JsonResponse
    {
        return response()->json([
            'is_success' => $isSuccess,
            'message'    => $message,
            'data'       => $data,
            'errors'     => $errors
        ], $code);
    }
}


<?php

namespace App\Responses\V1;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse
{
    public static function success($message, $data = null, $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error($message, $errors = null, $code = 500): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }


    // Success
    public static function created($message = 'Resource was created successfully', $data = null): JsonResponse
    {
        return self::success($message, $data, 201);
    }

    //Errors

    public static function serverError($message = 'Something went wrong. Please try again.')
    {
        return self::error($message);
    }

    public static function validationError($message = 'Validation error', $errors = null): JsonResponse
    {
        return self::error($message, $errors, 422);
    }
}

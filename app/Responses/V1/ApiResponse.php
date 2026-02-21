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

    public static function ok($message = 'Ok', $data = null, $code = 200): JsonResponse
    {
        return self::success($message, $data, $code);
    }

    public static function created($message = 'Resource was created successfully', $data = null): JsonResponse
    {
        return self::success($message, $data, 201);
    }

    public static function noContent()
    {
        return self::success(
            message: '',
            code: 204,
        );
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

    public static function invalidCredentials($message = 'Invalid email address or password.')
    {
        return self::error(
            message: $message,
            code: 401,
        );
    }

    public static function unauthenticated(): JsonResponse
    {
        return self::error(
            message: 'Unauthenticated',
            code: 401,
        );
    }

    public static function notFound($message = 'Resource not found', $code = 404): JsonResponse
    {
        return self::error($message, $code, 404);
    }
}

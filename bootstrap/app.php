<?php

use App\Exceptions\InvalidCredentialsException;
use App\Responses\V1\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->name('api.v1.')
                ->group(base_path('routes/api_v1.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e) {
            $model = 'Resource';

            // Check if previous exception is instance of
            // ModelNotFoundException to return proper resource name
            $previous = $e->getPrevious();
            if ($previous instanceof ModelNotFoundException) {
                $model = class_basename($previous->getModel());
            }
            return ApiResponse::notfound("$model not found");
        });

        $exceptions->render(function (ValidationException $e): JsonResponse {
            return ApiResponse::validationError(errors: $e->errors());
        });

        $exceptions->render(function (QueryException $_) {
            return ApiResponse::serverError();
        });

        $exceptions->render(function (InvalidCredentialsException $_): JsonResponse {
            return ApiResponse::invalidCredentials();
        });

        $exceptions->render(function (AuthenticationException $_): JsonResponse {
            return ApiResponse::unauthenticated();
        });

        $exceptions->render(function (Throwable $e) {
            return ApiResponse::serverError();
        });
    })->create();

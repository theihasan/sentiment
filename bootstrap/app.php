<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        apiPrefix: 'api/v1',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        });

        $exceptions->renderable(function (ValidationException $e) {
           if (request()->wantsJson()) {
               return response()->json([
                   'message' => $e->getMessage(),
                   'errors' => $e->errors(),
               ], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
           }
        });

        $exceptions->renderable(function (QueryException $exception) {
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Database error',
                    'error' => $exception->getMessage(),
                ], $exception->getCode());
            }
        });

        $exceptions->renderable(function (MethodNotAllowedHttpException $exception) {
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Method not allowed',
                    'error' => $exception->getMessage(),
                ], $exception->getStatusCode());
            }
        });

        $exceptions->renderable(function (BadMethodCallException $exception) {
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Bad method call',
                    'error' => $exception->getMessage(),
                ], $exception->getCode());
            }
        });

    })->create();

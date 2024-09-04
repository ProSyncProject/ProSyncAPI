<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api/v1.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/status',
        apiPrefix: 'api/v1'
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            errorLogger($e, $request);
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Record not found.',
                    'data' => null
                ], 404);
            }
            abort(404);
        })->render(function (\Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException $e, Request $request) {
            errorLogger($e, $request);
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 401,
                    'message' => 'You are not authorized.',
                    'data' => null
                ], 401);
            }
            abort(401);
        })->render(function (AuthenticationException $e, Request $request) {
            errorLogger($e, $request);
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You are not authenticated.',
                    'data' => null
                ], 403);
            }
            abort(403);
        })->render(function (AccessDeniedHttpException $e, Request $request) {
            errorLogger($e, $request);
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You are not authorized.',
                    'data' => null
                ], 403);
            }
            abort(403);
        })->render(function (\Symfony\Component\HttpFoundation\Exception\BadRequestException $e, Request $request) {
            errorLogger($e, $request);
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Bad request.',
                    'data' => null
                ], 403);
            }
            abort(403);
        })->render(function (\Illuminate\Auth\Access\AuthorizationException $e, Request $request) {
            errorLogger($e, $request);
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 422,
                    'message' => 'You are not authorized.',
                    'data' => null
                ], 422);
            }
            abort(422);
        })->render(function (QueryException $e, Request $request) {
            errorLogger($e, $request);
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Internal server error.',
                    'data' => null
                ], 500);
            }
            abort(500);
        })->render(function (InvalidArgumentException $e, Request $request) {
            errorLogger($e, $request);
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Internal server error.',
                    'data' => null
                ], 500);
            }
            abort(500);
        })->render(function (Error $e, Request $request) {
            errorLogger($e, $request);
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Internal server error.',
                    'data' => null
                ], 500);
            }
            abort(500);
        });
    })->create();

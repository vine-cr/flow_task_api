<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Modelo não encontrado via route model binding
        $exceptions->render(function (ModelNotFoundException $e, $request) {
            return response()->json([
                'message' => 'Recurso não encontrado.',
                'status'  => Response::HTTP_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        });

        // Rota não encontrada
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'message' => $e->getMessage() ?: 'Rota não encontrada.',
                'status'  => Response::HTTP_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        });

        // Acesso negado
        $exceptions->render(function (AccessDeniedHttpException $e, $request) {
            return response()->json([
                'message' => $e->getMessage() ?: 'Acesso negado.',
                'status'  => Response::HTTP_FORBIDDEN,
            ], Response::HTTP_FORBIDDEN);
        });

        // Erros de validação — padrão do documento: message + errors
        $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'message' => 'Dados inválidos.',
                'errors'  => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });

    })->create();

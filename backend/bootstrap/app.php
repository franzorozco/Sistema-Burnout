<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',

        // Esta línea carga tus rutas de API (¡Importante!)
        api: __DIR__.'/../routes/api.php',

        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function(){
            Route::middleware('web', 'auth')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Configuración de CORS
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);

        $middleware->replace(
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Http\Middleware\HandleCors::class, [
                'paths' => ['api/*'],

                // --- ¡AQUÍ ESTÁ LA CORRECCIÓN! ---
                // Le decimos a Laravel que acepte peticiones de tu frontend en el puerto 3000
                'allowed_origins' => [
                    'http://localhost:3000',
                    'http://127.0.0.1:3000',
                ],

                'allowed_headers' => ['*'],
                'allowed_methods' => ['*'],
                'supports_credentials' => false,
            ]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

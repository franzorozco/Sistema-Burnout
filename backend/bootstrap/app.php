<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',

        // --- PASO 1: AÑADE ESTA LÍNEA PARA CARGAR TUS RUTAS API ---
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

        // --- PASO 2: AÑADE ESTE BLOQUE PARA CONFIGURAR CORS ---
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);

        // Reconfigura el middleware para permitir tu frontend
        $middleware->replace(
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Http\Middleware\HandleCors::class, [
                // Aplica a todas tus rutas que empiecen con 'api/'
                'paths' => ['api/*'],

                // La URL de tu frontend Vue
                'allowed_origins' => [
                    'http://localhost:5173', // <-- Cambia esto si tu puerto es otro
                    // 'http://tu-dominio-de-produccion.com' // Para el futuro
                ],

                'allowed_headers' => ['*'],
                'allowed_methods' => ['*'],
                'supports_credentials' => false,
            ]
        );
        // --- FIN DEL BLOQUE CORS ---

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

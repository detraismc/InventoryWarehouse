<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Configure and create the Laravel application
return Application::configure(basePath: dirname(__DIR__))

    // Register the application's routing files
    ->withRouting(
        web: __DIR__.'/../routes/web.php',       // Main web routes
        commands: __DIR__.'/../routes/console.php', // Artisan console commands
        health: '/up',                           // Health check endpoint
    )

    // Register middleware aliases
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class, // Alias 'role' for RoleMiddleware
        ]);
    })

    // Configure exception handling (currently empty, can be customized)
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    // Create and return the application instance
    ->create();

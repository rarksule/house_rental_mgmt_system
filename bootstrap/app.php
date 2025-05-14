<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Tenant;
use App\Http\Middleware\Owner;
use App\Http\Middleware\Common;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => Admin::class,
            'owner' => Owner::class,
            'tenant' => Tenant::class,
        ])->web([SetLocale::class]);
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

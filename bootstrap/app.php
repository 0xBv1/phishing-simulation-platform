<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Configure rate limiting
        $middleware->throttleApi();
        
        // Define custom rate limiters
        $middleware->throttleWithRedis('auth', function () {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by(request()->ip());
        });
        
        $middleware->throttleWithRedis('tracking', function () {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(60)->by(request()->ip());
        });
        
        $middleware->throttleWithRedis('campaign', function () {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(30)->by(request()->ip());
        });
        
        $middleware->throttleWithRedis('api', function () {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(100)->by(request()->user()?->id ?? request()->ip());
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

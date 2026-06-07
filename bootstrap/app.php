<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        // This replaces the old $except array in VerifyCsrfToken.php
        $middleware->validateCsrfTokens(except: [
            'logout',
            'realtor/listing/*'
        ]);

        // In web.php, we define ->middleware('auth'), and since middleware come before controller, it will find the middleware auth (from Authenticate.php inside vendor folder). Laravel will automatically find the route that is named 'login' if the user is not authenticated, it will redirect to route named  'login'
        // What if we do not set the route 'login'? So we need to define it at here (Laravel v12.x)
        // Option 1: If you want to use a direct URL path (based on the route)
        // $middleware->redirectGuestsTo('/sign-in');
        // Option 2: If you prefer using the named route (usually safer as if route change, the route name is still remain) (based on the route name)
        // $middleware->redirectGuestsTo(fn () => route('sign-in'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

<?php

use App\Facades\BaseData;
use App\Http\Middleware\AuthenticateAdmin;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\UserStatusMiddleware;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\RoleMiddleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            TrustProxies::class,
            HandleCors::class,
            ValidatePostSize::class,
            TrimStrings::class,
            ConvertEmptyStringsToNull::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
        ]);

        $middleware->group('web', [
            ValidateCsrfToken::class,
            SubstituteBindings::class,
            HandleInertiaRequests::class,
        ]);

        $middleware->group('api', [
            SubstituteBindings::class,
        ]);

        $middleware->alias([
            'auth.admin' => AuthenticateAdmin::class,
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontFlash([
            'current_password',
            'password',
            'password_confirmation',
        ]);

        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            return Inertia::render('ErrorPage', [
                'base' => BaseData::get(),
                'status' => $e->getStatusCode(),
                'message' => $e->getMessage(),
                'seo' => [
                    'title' => 'Страница не найдена - Click Haus',
                    'meta_description' => 'Страница не найдена. Вернитесь на главную страницу Click Haus.',
                    'og_title' => 'Страница не найдена - Click Haus',
                    'og_description' => 'Страница не найдена. Вернитесь на главную страницу Click Haus.',
                ]
            ])
                ->toResponse($request)
                ->setStatusCode($e->getStatusCode());
        });
    })->create();

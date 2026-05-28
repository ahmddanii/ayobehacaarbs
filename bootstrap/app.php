<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectUsersTo(fn () => route('admin.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (\Throwable $e) {
            error_log('ORIGINAL EXCEPTION ON VERCEL: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        });

        // Bypass Blade-based error rendering on Vercel to prevent secondary "view does not exist" errors
        $exceptions->render(function (\Throwable $e) {
            $html = "<h1>500 Internal Server Error (Application Exception)</h1>";
            $html .= "<p>An exception occurred during Laravel's request lifecycle on Vercel.</p>";
            $html .= "<pre style='background: #f4f4f4; padding: 15px; border: 1px solid #ccc; overflow: auto; font-family: monospace;'>";
            $html .= "<b>Exception Class:</b> " . get_class($e) . "\n";
            $html .= "<b>Message:</b> " . htmlspecialchars($e->getMessage()) . "\n\n";
            if ($e->getPrevious()) {
                $html .= "<b>Chained/Previous Exception:</b> " . get_class($e->getPrevious()) . ": " . htmlspecialchars($e->getPrevious()->getMessage()) . "\n\n";
            }
            $html .= "<b>Stack Trace:</b>\n" . htmlspecialchars($e->getTraceAsString());
            $html .= "</pre>";

            // Return a raw Symfony Response that doesn't depend on Laravel's container services
            return new \Symfony\Component\HttpFoundation\Response($html, 500, ['Content-Type' => 'text/html']);
        });
    })->create();

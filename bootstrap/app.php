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
            $exceptionClass = get_class($e);
            $exceptionMessage = htmlspecialchars($e->getMessage());
            $stackTrace = htmlspecialchars($e->getTraceAsString());

            $chainedInfo = '';
            if ($e->getPrevious()) {
                $prevClass = get_class($e->getPrevious());
                $prevMessage = htmlspecialchars($e->getPrevious()->getMessage());
                $prevTrace = htmlspecialchars($e->getPrevious()->getTraceAsString());
                $chainedInfo = "
                    <div class='exception-message' style='background: rgba(250, 179, 135, 0.08); border-left-color: #fab387; color: #fab387; margin-top: 16px;'>
                        <span style='font-size: 11px; text-transform: uppercase; font-weight: 800; display: block; margin-bottom: 4px; color: rgba(250, 179, 135, 0.8);'>Chained/Previous Exception ({$prevClass})</span>
                        {$prevMessage}
                    </div>
                    <div class='section-title' style='margin-top: 24px;'>⛓️ Chained Stack Trace</div>
                    <div class='trace-container' style='margin-bottom: 24px;'>
                        <div class='trace-header'>
                            <span>chained_trace.log</span>
                            <span style='color: #fab387;'>Previous Exception Trace</span>
                        </div>
                        <div class='trace-body'>{$prevTrace}</div>
                    </div>
                ";
            }

            $html = "
            <!DOCTYPE html>
            <html lang='id'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Sistem Mengalami Kendala | Ayo Behacaar</title>
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');
                    
                    * {
                        box-sizing: border-box;
                        margin: 0;
                        padding: 0;
                    }
                    
                    body {
                        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                        background: radial-gradient(circle at 50% 50%, #1a1926 0%, #111019 100%);
                        color: #cdd6f4;
                        min-height: 100vh;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        padding: 40px 24px;
                        overflow-x: hidden;
                    }

                    .container {
                        width: 100%;
                        max-width: 900px;
                        background: rgba(30, 30, 46, 0.7);
                        backdrop-filter: blur(20px);
                        -webkit-backdrop-filter: blur(20px);
                        border: 1px solid rgba(255, 255, 255, 0.08);
                        border-radius: 24px;
                        padding: 40px;
                        box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4), inset 0 0 0 1px rgba(255, 255, 255, 0.02);
                        position: relative;
                        overflow: hidden;
                        animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
                    }

                    .container::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 4px;
                        background: linear-gradient(90deg, #f38ba8 0%, #fab387 50%, #f38ba8 100%);
                    }

                    @keyframes fadeIn {
                        from { opacity: 0; transform: translateY(20px); }
                        to { opacity: 1; transform: translateY(0); }
                    }

                    .header {
                        display: flex;
                        align-items: center;
                        gap: 20px;
                        margin-bottom: 32px;
                    }

                    .error-badge {
                        background: linear-gradient(135deg, #f38ba8 0%, #eba0b2 100%);
                        color: #111019;
                        width: 56px;
                        height: 56px;
                        border-radius: 16px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 28px;
                        font-weight: 800;
                        box-shadow: 0 8px 24px rgba(243, 139, 168, 0.3);
                        position: relative;
                    }

                    .pulse-ring {
                        border: 3px solid #f38ba8;
                        border-radius: 30px;
                        height: 100%;
                        width: 100%;
                        position: absolute;
                        left: 0;
                        top: 0;
                        animation: pulsate 2s infinite ease-out;
                        opacity: 0;
                    }

                    @keyframes pulsate {
                        0% { transform: scale(0.8, 0.8); opacity: 0.0; }
                        50% { opacity: 0.5; }
                        100% { transform: scale(1.4, 1.4); opacity: 0.0; }
                    }

                    .title-area h1 {
                        font-size: 26px;
                        font-weight: 800;
                        color: #fff;
                        letter-spacing: -0.5px;
                        margin-bottom: 4px;
                    }

                    .title-area p {
                        font-size: 14px;
                        color: #a6adc8;
                        font-weight: 500;
                    }

                    .error-card {
                        background: rgba(17, 17, 27, 0.5);
                        border: 1px solid rgba(255, 255, 255, 0.05);
                        border-radius: 16px;
                        padding: 24px;
                        margin-bottom: 28px;
                    }

                    .meta-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                        gap: 16px;
                        margin-bottom: 20px;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
                        padding-bottom: 20px;
                    }

                    .meta-item {
                        display: flex;
                        flex-direction: column;
                        gap: 4px;
                    }

                    .meta-label {
                        font-size: 11px;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                        color: #585b70;
                        font-weight: 700;
                    }

                    .meta-value {
                        font-size: 14px;
                        color: #cdd6f4;
                        font-weight: 600;
                        word-break: break-all;
                    }

                    .exception-message {
                        font-size: 15px;
                        line-height: 1.6;
                        color: #f38ba8;
                        font-weight: 600;
                        background: rgba(243, 139, 168, 0.08);
                        border-left: 4px solid #f38ba8;
                        padding: 16px;
                        border-radius: 8px;
                    }

                    .section-title {
                        font-size: 13px;
                        font-weight: 700;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                        color: #bac2de;
                        margin-bottom: 12px;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                    }

                    .trace-container {
                        background: #11111b;
                        border: 1px solid rgba(255, 255, 255, 0.04);
                        border-radius: 12px;
                        overflow: hidden;
                    }

                    .trace-header {
                        background: #181825;
                        padding: 12px 20px;
                        font-size: 12px;
                        font-family: 'JetBrains Mono', monospace;
                        color: #89b4fa;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }

                    .trace-body {
                        padding: 20px;
                        font-family: 'JetBrains Mono', monospace;
                        font-size: 13px;
                        line-height: 1.6;
                        color: #a6adc8;
                        max-height: 380px;
                        overflow-y: auto;
                        white-space: pre-wrap;
                        word-break: break-all;
                    }

                    .trace-body::-webkit-scrollbar {
                        width: 8px;
                        height: 8px;
                    }
                    .trace-body::-webkit-scrollbar-track {
                        background: #11111b;
                    }
                    .trace-body::-webkit-scrollbar-thumb {
                        background: #313244;
                        border-radius: 4px;
                    }
                    .trace-body::-webkit-scrollbar-thumb:hover {
                        background: #45475a;
                    }

                    .footer {
                        margin-top: 32px;
                        text-align: center;
                        font-size: 13px;
                        color: #585b70;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        border-top: 1px solid rgba(255, 255, 255, 0.05);
                        padding-top: 24px;
                    }

                    .footer a {
                        color: #89b4fa;
                        text-decoration: none;
                        font-weight: 600;
                        transition: color 0.2s;
                    }

                    .footer a:hover {
                        color: #b4befe;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <div class='error-badge'>
                            ⚠️
                            <div class='pulse-ring'></div>
                        </div>
                        <div class='title-area'>
                            <h1>Sistem Mengalami Kendala</h1>
                            <p>Terjadi pengecualian (exception) selama siklus penanganan request di Vercel.</p>
                        </div>
                    </div>

                    <div class='error-card'>
                        <div class='meta-grid'>
                            <div class='meta-item'>
                                <span class='meta-label'>Exception Class</span>
                                <span class='meta-value'>{$exceptionClass}</span>
                            </div>
                            <div class='meta-item'>
                                <span class='meta-label'>Environment</span>
                                <span class='meta-value'>Production (Vercel Serverless)</span>
                            </div>
                        </div>
                        <div class='exception-message'>
                            {$exceptionMessage}
                        </div>
                        {$chainedInfo}
                    </div>

                    <div class='section-title'>💻 Stack Trace Pelacakan</div>
                    <div class='trace-container'>
                        <div class='trace-header'>
                            <span>laravel_exception_trace.log</span>
                            <span style='color: #bac2de;'>Laravel Request Handling Layer</span>
                        </div>
                        <div class='trace-body'>{$stackTrace}</div>
                    </div>

                    <div class='footer'>
                        <span>Ayo Behacaar &copy; 2026</span>
                        <a href='/'>Kembali ke Beranda</a>
                    </div>
                </div>
            </body>
            </html>
            ";

            // Return a raw Symfony Response that doesn't depend on Laravel's container services
            return new \Symfony\Component\HttpFoundation\Response($html, 500, ['Content-Type' => 'text/html']);
        });
    })->create();

<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

try {
    // Bootstrap Laravel and handle the request...
    /** @var Application $app */
    $app = require_once __DIR__.'/../bootstrap/app.php';

    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    // Log the actual exception to Vercel logs / PHP error log
    error_log('ACTUAL BOOTSTRAP EXCEPTION ON VERCEL: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
    if ($e->getPrevious()) {
        error_log('PREVIOUS EXCEPTION: ' . $e->getPrevious()->getMessage() . "\n" . $e->getPrevious()->getTraceAsString());
    }

    // Set 500 response header
    if (!headers_sent()) {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: text/html; charset=UTF-8');
    }

    // Render a premium developer error page
    $exceptionClass = get_class($e);
    $exceptionMessage = htmlspecialchars($e->getMessage());
    $stackTrace = htmlspecialchars($e->getTraceAsString());

    $chainedInfo = '';
    if ($e->getPrevious()) {
        $prevClass = get_class($e->getPrevious());
        $prevMessage = htmlspecialchars($e->getPrevious()->getMessage());
        $prevTrace = htmlspecialchars($e->getPrevious()->getTraceAsString());
        $chainedInfo = "
            <div class='exception-message' style='background: rgba(245, 158, 11, 0.08); border-left-color: #f59e0b; color: #fbbf24; margin-top: 16px; position: relative;'>
                <span style='font-size: 11px; text-transform: uppercase; font-weight: 800; display: block; margin-bottom: 6px; color: rgba(251, 191, 36, 0.8);'>Chained/Previous Exception ({$prevClass})</span>
                <span id='prev-msg-text'>{$prevMessage}</span>
                <button onclick=\"copyToClipboard('prev-msg-text', this)\" class='mini-copy-btn' title='Salin Error Sebelumnya'>
                    <i class='bi bi-clipboard'></i>
                </button>
            </div>
            <div class='section-title' style='margin-top: 28px;'>
                <span>⛓️ Chained Stack Trace</span>
                <button onclick=\"copyToClipboard('chained-trace-text', this)\" class='copy-btn'>
                    <i class='bi bi-clipboard'></i> Salin Trace Chained
                </button>
            </div>
            <div class='trace-container' style='margin-bottom: 24px;'>
                <div class='trace-header'>
                    <span>chained_trace.log</span>
                    <span style='color: #fbbf24;'>Previous Exception Trace</span>
                </div>
                <div class='trace-body' id='chained-trace-text'>{$prevTrace}</div>
            </div>
        ";
    }

    echo "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Sistem Mengalami Kendala | Ayo Behacaar</title>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css'>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');
            
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }
            
            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: radial-gradient(circle at 50% 50%, #0d1527 0%, #070a13 100%);
                color: #e2e8f0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 50px 24px;
                overflow-x: hidden;
            }

            .container {
                width: 100%;
                max-width: 900px;
                background: rgba(15, 23, 42, 0.65);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(59, 130, 246, 0.15);
                border-radius: 20px;
                padding: 40px;
                box-shadow: 0 24px 64px rgba(3, 7, 18, 0.6), inset 0 0 0 1px rgba(255, 255, 255, 0.02);
                position: relative;
                overflow: hidden;
                animation: fadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .container::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 4px;
                background: linear-gradient(90deg, #3b82f6 0%, #2563eb 50%, #3b82f6 100%);
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(15px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .header {
                display: flex;
                align-items: center;
                gap: 20px;
                margin-bottom: 32px;
            }

            .error-badge {
                background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
                color: #ffffff;
                width: 56px;
                height: 56px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
                position: relative;
            }

            .pulse-ring {
                border: 3px solid #3b82f6;
                border-radius: 20px;
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
                50% { opacity: 0.4; }
                100% { transform: scale(1.4, 1.4); opacity: 0.0; }
            }

            .title-area h1 {
                font-family: 'Poppins', sans-serif;
                font-size: 24px;
                font-weight: 700;
                color: #ffffff;
                letter-spacing: -0.5px;
                margin-bottom: 4px;
            }

            .title-area p {
                font-size: 13px;
                color: #94a3b8;
                font-weight: 500;
            }

            .error-card {
                background: rgba(15, 23, 42, 0.6);
                border: 1px solid rgba(255, 255, 255, 0.04);
                border-radius: 14px;
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
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: #64748b;
                font-weight: 700;
            }

            .meta-value {
                font-size: 13px;
                color: #cbd5e1;
                font-weight: 600;
                word-break: break-all;
            }

            .exception-message {
                font-size: 14px;
                line-height: 1.6;
                color: #f87171;
                font-weight: 600;
                background: rgba(239, 68, 68, 0.08);
                border-left: 4px solid #ef4444;
                padding: 16px;
                border-radius: 8px;
                position: relative;
            }

            .section-title {
                font-family: 'Poppins', sans-serif;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: #94a3b8;
                margin-bottom: 12px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 8px;
            }

            .trace-container {
                background: #090d16;
                border: 1px solid rgba(255, 255, 255, 0.03);
                border-radius: 10px;
                overflow: hidden;
            }

            .trace-header {
                background: #0f172a;
                padding: 12px 20px;
                font-size: 11px;
                font-family: 'JetBrains Mono', monospace;
                color: #60a5fa;
                border-bottom: 1px solid rgba(255, 255, 255, 0.03);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .trace-body {
                padding: 20px;
                font-family: 'JetBrains Mono', monospace;
                font-size: 12px;
                line-height: 1.6;
                color: #94a3b8;
                max-height: 380px;
                overflow-y: auto;
                white-space: pre-wrap;
                word-break: break-all;
            }

            .trace-body::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            .trace-body::-webkit-scrollbar-track {
                background: #090d16;
            }
            .trace-body::-webkit-scrollbar-thumb {
                background: #1e293b;
                border-radius: 3px;
            }
            .trace-body::-webkit-scrollbar-thumb:hover {
                background: #334155;
            }

            /* Copy Buttons Styling */
            .copy-btn {
                background: rgba(59, 130, 246, 0.1);
                color: #60a5fa;
                border: 1px solid rgba(59, 130, 246, 0.2);
                border-radius: 6px;
                padding: 4px 10px;
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                transition: all 0.2s;
                font-family: 'Inter', sans-serif;
            }

            .copy-btn:hover {
                background: rgba(59, 130, 246, 0.2);
                color: #93c5fd;
                border-color: rgba(59, 130, 246, 0.4);
            }

            .copy-btn.copied {
                background: rgba(34, 197, 94, 0.15) !important;
                color: #4ade80 !important;
                border-color: rgba(34, 197, 94, 0.3) !important;
            }

            .mini-copy-btn {
                position: absolute;
                top: 8px;
                right: 8px;
                background: transparent;
                border: none;
                color: rgba(255, 255, 255, 0.3);
                font-size: 14px;
                cursor: pointer;
                padding: 4px;
                border-radius: 4px;
                transition: all 0.2s;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .mini-copy-btn:hover {
                color: #ffffff;
                background: rgba(255, 255, 255, 0.08);
            }

            .mini-copy-btn.copied {
                color: #4ade80 !important;
            }

            .footer {
                margin-top: 32px;
                text-align: center;
                font-size: 12px;
                color: #475569;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-top: 1px solid rgba(255, 255, 255, 0.05);
                padding-top: 24px;
            }

            .footer a {
                color: #3b82f6;
                text-decoration: none;
                font-weight: 600;
                transition: color 0.2s;
            }

            .footer a:hover {
                color: #60a5fa;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <div class='error-badge'>
                    <i class='bi bi-exclamation-triangle'></i>
                    <div class='pulse-ring'></div>
                </div>
                <div class='title-area'>
                    <h1>Sistem Mengalami Kendala</h1>
                    <p>Terjadi pengecualian awal selama fase inisiasi aplikasi (Bootstrap) di Vercel.</p>
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
                    <span id='exception-msg-text'>{$exceptionMessage}</span>
                    <button onclick=\"copyToClipboard('exception-msg-text', this)\" class='mini-copy-btn' title='Salin Pesan Error'>
                        <i class='bi bi-clipboard'></i>
                    </button>
                </div>
                {$chainedInfo}
            </div>

            <div class='section-title'>
                <span>💻 Stack Trace Pelacakan</span>
                <button onclick=\"copyToClipboard('bootstrap-trace-text', this)\" class='copy-btn'>
                    <i class='bi bi-clipboard'></i> Salin Trace Log
                </button>
            </div>
            <div class='trace-container'>
                <div class='trace-header'>
                    <span>bootstrap_trace.log</span>
                    <span style='color: #64748b;'>Laravel Bootstrap Layer</span>
                </div>
                <div class='trace-body' id='bootstrap-trace-text'>{$stackTrace}</div>
            </div>

            <div class='footer'>
                <span>Ayo Behacaar &copy; 2026</span>
                <a href='/'>Kembali ke Beranda</a>
            </div>
        </div>

        <script>
            function copyToClipboard(elementId, btn) {
                var text = document.getElementById(elementId).innerText;
                navigator.clipboard.writeText(text).then(function() {
                    var originalHTML = btn.innerHTML;
                    if (btn.classList.contains('mini-copy-btn')) {
                        btn.innerHTML = \"<i class='bi bi-check-lg'></i>\";
                    } else {
                        btn.innerHTML = \"<i class='bi bi-check-lg'></i> Tersalin!\";
                    }
                    btn.classList.add('copied');
                    setTimeout(function() {
                        btn.innerHTML = originalHTML;
                        btn.classList.remove('copied');
                    }, 2000);
                }).catch(function(err) {
                    console.error('Gagal menyalin teks: ', err);
                });
            }
        </script>
    </body>
    </html>
    ";
    exit(1);
    exit(1);
}


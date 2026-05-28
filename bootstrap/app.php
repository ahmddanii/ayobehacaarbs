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
                    <div class='chained-alert-box'>
                        <span class='chained-meta-label'>Previous/Chained Exception ({$prevClass})</span>
                        <div class='chained-message-container'>
                            <span id='prev-msg-text'>{$prevMessage}</span>
                            <button onclick=\"copyToClipboard('prev-msg-text', this)\" class='mini-copy-btn' title='Salin Error Sebelumnya'>
                                <i class='bi bi-clipboard'></i>
                            </button>
                        </div>
                    </div>
                    <div class='section-title' style='margin-top: 24px;'>
                        <span>⛓️ Chained Stack Trace</span>
                        <button onclick=\"copyToClipboard('chained-trace-text', this)\" class='copy-btn'>
                            <i class='bi bi-clipboard'></i> Salin Trace Chained
                        </button>
                    </div>
                    <div class='trace-container' style='margin-bottom: 20px;'>
                        <div class='trace-header'>
                            <span>chained_trace.log</span>
                            <span class='trace-layer-tag prev-tag'>Chained Exception Trace</span>
                        </div>
                        <div class='trace-body' id='chained-trace-text'>{$prevTrace}</div>
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
                <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css'>
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@500;600&family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');
                    
                    :root {
                        --bg-page: #f8fafc;
                        --bg-card: #ffffff;
                        --border-card: #e2e8f0;
                        --text-primary: #0f172a;
                        --text-secondary: #475569;
                        --text-meta: #64748b;
                        --accent-blue: #2563eb;
                        --accent-blue-hover: #1d4ed8;
                        --accent-blue-light: rgba(37, 99, 235, 0.06);
                        --accent-blue-border: rgba(37, 99, 235, 0.15);
                        --accent-red: #ef4444;
                        --bg-red-light: rgba(239, 68, 68, 0.05);
                        --border-red: rgba(239, 68, 68, 0.12);
                        --shadow-card: 0 10px 30px -10px rgba(15, 23, 42, 0.08), 0 1px 3px rgba(15, 23, 42, 0.02);
                        --code-bg: #0f172a;
                        --code-header-bg: #1e293b;
                        --code-text: #e2e8f0;
                        --transition-speed: 0.25s;
                    }
                    
                    :root.dark {
                        --bg-page: #020617;
                        --bg-card: #0f172a;
                        --border-card: #1e293b;
                        --text-primary: #f1f5f9;
                        --text-secondary: #94a3b8;
                        --text-meta: #64748b;
                        --accent-blue: #3b82f6;
                        --accent-blue-hover: #60a5fa;
                        --accent-blue-light: rgba(59, 130, 246, 0.08);
                        --accent-blue-border: rgba(59, 130, 246, 0.2);
                        --accent-red: #f87171;
                        --bg-red-light: rgba(248, 113, 113, 0.08);
                        --border-red: rgba(248, 113, 113, 0.15);
                        --shadow-card: 0 20px 40px -15px rgba(0, 0, 0, 0.5), inset 0 0 0 1px rgba(255, 255, 255, 0.03);
                        --code-bg: #090d16;
                        --code-header-bg: #0f172a;
                        --code-text: #bac2de;
                    }

                    * {
                        box-sizing: border-box;
                        margin: 0;
                        padding: 0;
                    }
                    
                    body {
                        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                        background-color: var(--bg-page);
                        color: var(--text-primary);
                        min-height: 100vh;
                        display: flex;
                        flex-direction: column;
                        transition: background-color var(--transition-speed) ease, color var(--transition-speed) ease;
                        overflow-x: hidden;
                    }

                    /* Header / Navbar style matching the actual app */
                    .navbar {
                        position: sticky;
                        top: 0;
                        z-index: 50;
                        background-color: var(--bg-card);
                        border-bottom: 1px solid var(--border-card);
                        width: 100%;
                        padding: 12px 24px;
                        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                        transition: background-color var(--transition-speed) ease, border-color var(--transition-speed) ease;
                    }

                    .navbar-container {
                        max-width: 1200px;
                        margin: 0 auto;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }

                    .brand {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        text-decoration: none;
                        font-family: 'Poppins', sans-serif;
                    }

                    .logo {
                        height: 40px;
                        width: auto;
                    }

                    .brand-text {
                        font-size: 19px;
                        font-weight: 600;
                        color: var(--text-primary);
                        letter-spacing: -0.5px;
                    }

                    .brand-blue {
                        color: #2563eb;
                    }

                    :root.dark .brand-blue {
                        color: #3b82f6;
                    }

                    .theme-toggle-btn {
                        background: none;
                        border: 1px solid var(--border-card);
                        color: var(--text-secondary);
                        padding: 8px 12px;
                        border-radius: 10px;
                        cursor: pointer;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 16px;
                        transition: all var(--transition-speed) ease;
                    }

                    .theme-toggle-btn:hover {
                        background-color: var(--accent-blue-light);
                        border-color: var(--accent-blue-border);
                        color: var(--accent-blue);
                        transform: scale(1.05);
                    }

                    .light-icon {
                        display: none;
                    }

                    :root.dark .dark-icon {
                        display: none;
                    }

                    :root.dark .light-icon {
                        display: block;
                        color: #fbbf24;
                    }

                    /* Main Layout */
                    .main-content {
                        flex: 1;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        padding: 40px 24px;
                    }

                    .container {
                        width: 100%;
                        max-width: 900px;
                        background-color: var(--bg-card);
                        border: 1px solid var(--border-card);
                        border-radius: 20px;
                        padding: 36px;
                        box-shadow: var(--shadow-card);
                        position: relative;
                        overflow: hidden;
                        animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                        transition: background-color var(--transition-speed) ease, border-color var(--transition-speed) ease, box-shadow var(--transition-speed) ease;
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
                        from { opacity: 0; transform: translateY(10px); }
                        to { opacity: 1; transform: translateY(0); }
                    }

                    .header {
                        display: flex;
                        align-items: center;
                        gap: 20px;
                        margin-bottom: 28px;
                    }

                    .error-badge {
                        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                        color: #ffffff;
                        width: 56px;
                        height: 56px;
                        border-radius: 14px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 24px;
                        box-shadow: 0 8px 24px rgba(239, 68, 68, 0.2);
                        position: relative;
                    }

                    .pulse-ring {
                        border: 3px solid #ef4444;
                        border-radius: 20px;
                        height: 100%;
                        width: 100%;
                        position: absolute;
                        left: 0;
                        top: 0;
                        animation: pulsate 2.5s infinite ease-out;
                        opacity: 0;
                    }

                    @keyframes pulsate {
                        0% { transform: scale(0.8); opacity: 0.0; }
                        50% { opacity: 0.3; }
                        100% { transform: scale(1.4); opacity: 0.0; }
                    }

                    .title-area h1 {
                        font-family: 'Poppins', sans-serif;
                        font-size: 22px;
                        font-weight: 700;
                        color: var(--text-primary);
                        letter-spacing: -0.5px;
                        margin-bottom: 4px;
                    }

                    .title-area p {
                        font-size: 13px;
                        color: var(--text-secondary);
                        font-weight: 500;
                    }

                    .error-card {
                        background: var(--bg-page);
                        border: 1px solid var(--border-card);
                        border-radius: 14px;
                        padding: 24px;
                        margin-bottom: 24px;
                        transition: background-color var(--transition-speed) ease, border-color var(--transition-speed) ease;
                    }

                    .meta-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                        gap: 16px;
                        margin-bottom: 20px;
                        border-bottom: 1px solid var(--border-card);
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
                        color: var(--text-meta);
                        font-weight: 700;
                    }

                    .meta-value {
                        font-size: 13px;
                        color: var(--text-primary);
                        font-weight: 600;
                        word-break: break-all;
                    }

                    .exception-message {
                        font-size: 14px;
                        line-height: 1.6;
                        color: var(--accent-red);
                        font-weight: 600;
                        background: var(--bg-red-light);
                        border: 1px solid var(--border-red);
                        border-left: 4px solid var(--accent-red);
                        padding: 16px;
                        border-radius: 8px;
                        position: relative;
                        display: flex;
                        justify-content: space-between;
                        align-items: flex-start;
                        gap: 20px;
                    }

                    .chained-alert-box {
                        background: rgba(245, 158, 11, 0.06);
                        border: 1px solid rgba(245, 158, 11, 0.15);
                        border-left: 4px solid #f59e0b;
                        padding: 16px;
                        border-radius: 8px;
                        margin-top: 16px;
                    }

                    .chained-meta-label {
                        font-size: 11px;
                        text-transform: uppercase;
                        font-weight: 800;
                        display: block;
                        margin-bottom: 6px;
                        color: #d97706;
                    }

                    :root.dark .chained-meta-label {
                        color: #fbbf24;
                    }

                    .chained-message-container {
                        font-size: 14px;
                        line-height: 1.6;
                        color: #d97706;
                        font-weight: 600;
                        position: relative;
                        display: flex;
                        justify-content: space-between;
                        align-items: flex-start;
                        gap: 20px;
                    }

                    :root.dark .chained-message-container {
                        color: #fbbf24;
                    }

                    .section-title {
                        font-family: 'Poppins', sans-serif;
                        font-size: 12px;
                        font-weight: 700;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                        color: var(--text-meta);
                        margin-bottom: 12px;
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        gap: 8px;
                    }

                    .trace-container {
                        background-color: var(--code-bg);
                        border: 1px solid var(--border-card);
                        border-radius: 10px;
                        overflow: hidden;
                        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                    }

                    .trace-header {
                        background-color: var(--code-header-bg);
                        padding: 12px 20px;
                        font-size: 11px;
                        font-family: 'JetBrains Mono', monospace;
                        color: var(--accent-blue);
                        border-bottom: 1px solid var(--border-card);
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }

                    .trace-layer-tag {
                        font-size: 10px;
                        font-weight: 700;
                        padding: 2px 8px;
                        border-radius: 4px;
                        background-color: var(--accent-blue-light);
                        color: var(--accent-blue);
                    }

                    .prev-tag {
                        background-color: rgba(245, 158, 11, 0.1);
                        color: #d97706;
                    }

                    :root.dark .prev-tag {
                        color: #fbbf24;
                    }

                    .trace-body {
                        padding: 20px;
                        font-family: 'JetBrains Mono', monospace;
                        font-size: 12px;
                        line-height: 1.6;
                        color: var(--code-text);
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
                        background: var(--code-bg);
                    }
                    .trace-body::-webkit-scrollbar-thumb {
                        background: var(--border-card);
                        border-radius: 3px;
                    }
                    .trace-body::-webkit-scrollbar-thumb:hover {
                        background: var(--text-meta);
                    }

                    /* Copy Buttons Styling */
                    .copy-btn {
                        background-color: var(--accent-blue-light);
                        color: var(--accent-blue);
                        border: 1px solid var(--accent-blue-border);
                        border-radius: 6px;
                        padding: 5px 12px;
                        font-size: 10px;
                        font-weight: 700;
                        text-transform: uppercase;
                        cursor: pointer;
                        display: inline-flex;
                        align-items: center;
                        gap: 6px;
                        transition: all 0.2s ease;
                        font-family: 'Inter', sans-serif;
                    }

                    .copy-btn:hover {
                        background-color: var(--accent-blue-border);
                        color: var(--accent-blue-hover);
                        transform: translateY(-1px);
                    }

                    .copy-btn.copied {
                        background-color: rgba(34, 197, 94, 0.1) !important;
                        color: #22c55e !important;
                        border-color: rgba(34, 197, 94, 0.2) !important;
                    }

                    .mini-copy-btn {
                        background: none;
                        border: none;
                        color: var(--text-meta);
                        font-size: 14px;
                        cursor: pointer;
                        padding: 4px;
                        border-radius: 4px;
                        transition: all 0.2s ease;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .mini-copy-btn:hover {
                        color: var(--text-primary);
                        background-color: var(--border-card);
                    }

                    .mini-copy-btn.copied {
                        color: #22c55e !important;
                    }

                    /* Global copy report action button */
                    .action-bar {
                        display: flex;
                        gap: 12px;
                        margin-bottom: 24px;
                    }

                    .btn-primary {
                        background-color: var(--accent-blue);
                        color: #ffffff;
                        border: none;
                        border-radius: 10px;
                        padding: 10px 18px;
                        font-size: 12px;
                        font-weight: 700;
                        text-transform: uppercase;
                        cursor: pointer;
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                        transition: all 0.2s ease;
                        box-shadow: 0 4px 12px var(--accent-blue-border);
                    }

                    .btn-primary:hover {
                        background-color: var(--accent-blue-hover);
                        transform: translateY(-1px);
                        box-shadow: 0 6px 16px var(--accent-blue-border);
                    }

                    .btn-primary.copied {
                        background-color: #22c55e !important;
                        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2) !important;
                    }

                    .footer {
                        margin-top: 32px;
                        text-align: center;
                        font-size: 12px;
                        color: var(--text-meta);
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        border-top: 1px solid var(--border-card);
                        padding-top: 24px;
                        transition: border-color var(--transition-speed) ease;
                    }

                    .footer a {
                        color: var(--accent-blue);
                        text-decoration: none;
                        font-weight: 600;
                        transition: color var(--transition-speed) ease;
                    }

                    .footer a:hover {
                        color: var(--accent-blue-hover);
                    }
                </style>
            </head>
            <body>
                <header class='navbar'>
                    <div class='navbar-container'>
                        <a href='/' class='brand'>
                            <img src='/assets/img/ayobehacaar.png' alt='Logo' class='logo' onerror=\"this.style.display='none'\">
                            <span class='brand-text'>ayo<span class='brand-blue'>behacaar</span></span>
                        </a>
                        <button id='theme-toggle' class='theme-toggle-btn' title='Ubah Mode Tema'>
                            <i class='bi bi-moon-stars-fill dark-icon'></i>
                            <i class='bi bi-sun-fill light-icon'></i>
                        </button>
                    </div>
                </header>

                <main class='main-content'>
                    <div class='container'>
                        <div class='header'>
                            <div class='error-badge'>
                                <i class='bi bi-exclamation-triangle'></i>
                                <div class='pulse-ring'></div>
                            </div>
                            <div class='title-area'>
                                <h1>Sistem Mengalami Kendala</h1>
                                <p>Terjadi pengecualian (exception) selama siklus penanganan request di Vercel.</p>
                            </div>
                        </div>

                        <div class='action-bar'>
                            <button onclick='copyFullReport(this)' class='btn-primary'>
                                <i class='bi bi-bug'></i> Salin Laporan Error Lengkap
                            </button>
                        </div>

                        <div class='error-card'>
                            <div class='meta-grid'>
                                <div class='meta-item'>
                                    <span class='meta-label'>Exception Class</span>
                                    <span class='meta-value' id='exception-class'>{$exceptionClass}</span>
                                </div>
                                <div class='meta-item'>
                                    <span class='meta-label'>Environment</span>
                                    <span class='meta-value' id='meta-env'>Production (Vercel Serverless)</span>
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
                            <button onclick=\"copyToClipboard('laravel-exception-trace-text', this)\" class='copy-btn'>
                                <i class='bi bi-clipboard'></i> Salin Trace Log
                            </button>
                        </div>
                        <div class='trace-container'>
                            <div class='trace-header'>
                                <span>laravel_exception_trace.log</span>
                                <span class='trace-layer-tag'>Laravel Request Handling Layer</span>
                            </div>
                            <div class='trace-body' id='laravel-exception-trace-text'>{$stackTrace}</div>
                        </div>

                        <div class='footer'>
                            <span>Ayo Behacaar &copy; 2026</span>
                            <a href='/'>Kembali ke Beranda</a>
                        </div>
                    </div>
                </main>

                <script>
                    // Initialize Theme from localStorage or prefers-color-scheme
                    const currentTheme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                    setTheme(currentTheme);

                    function setTheme(theme) {
                        if (theme === 'dark') {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                        localStorage.setItem('theme', theme);
                    }

                    document.getElementById('theme-toggle').addEventListener('click', function() {
                        const isDark = document.documentElement.classList.contains('dark');
                        setTheme(isDark ? 'light' : 'dark');
                    });

                    // Copy to Clipboard Utility
                    function copyToClipboard(elementId, btn) {
                        const text = document.getElementById(elementId).innerText;
                        navigator.clipboard.writeText(text).then(function() {
                            const originalHTML = btn.innerHTML;
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

                    // Copy Full Error Report
                    function copyFullReport(btn) {
                        const errorTitle = document.getElementById('exception-class').innerText;
                        const errorMessage = document.getElementById('exception-msg-text').innerText;
                        const environment = document.getElementById('meta-env').innerText;
                        const url = window.location.href;
                        const timestamp = new Date().toISOString();
                        const trace = document.getElementById('laravel-exception-trace-text') ? document.getElementById('laravel-exception-trace-text').innerText : '';
                        
                        let prevInfo = '';
                        const prevMsgEl = document.getElementById('prev-msg-text');
                        if (prevMsgEl) {
                            const prevTrace = document.getElementById('chained-trace-text') ? document.getElementById('chained-trace-text').innerText : '';
                            prevInfo = `\\n### Previous Exception\\n- **Message**: \${prevMsgEl.innerText}\\n\\n\`\`\`\\n\${prevTrace}\\n\`\`\``;
                        }

                        const reportText = `### Ayo Behacaar - Error Report\\n- **Timestamp**: \${timestamp}\\n- **URL**: \${url}\\n- **Environment**: \${environment}\\n- **Exception Class**: \${errorTitle}\\n- **Message**: \${errorMessage}\${prevInfo}\\n\\n### Stack Trace\\n\`\`\`\\n\${trace}\\n\`\`\``;

                        navigator.clipboard.writeText(reportText).then(function() {
                            const originalHTML = btn.innerHTML;
                            btn.innerHTML = \"<i class='bi bi-check-lg'></i> Laporan Tersalin!\";
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

            // Return a raw Symfony Response that doesn't depend on Laravel's container services
            return new \Symfony\Component\HttpFoundation\Response($html, 500, ['Content-Type' => 'text/html']);
        });
    })->create();

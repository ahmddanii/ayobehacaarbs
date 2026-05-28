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
    }

    // Render a helpful, clean debug page for production/Vercel debugging
    echo "<h1>500 Internal Server Error</h1>";
    echo "<p>An early exception occurred during Laravel's bootstrap phase on Vercel.</p>";
    echo "<pre style='background: #f4f4f4; padding: 15px; border: 1px solid #ccc; overflow: auto;'>";
    echo "<b>Exception:</b> " . htmlspecialchars($e->getMessage()) . "\n\n";
    if ($e->getPrevious()) {
        echo "<b>Chained/Previous Exception:</b> " . htmlspecialchars($e->getPrevious()->getMessage()) . "\n\n";
        echo "<b>Chained Trace:</b>\n" . htmlspecialchars($e->getPrevious()->getTraceAsString()) . "\n\n";
    }
    echo "<b>Stack Trace:</b>\n" . htmlspecialchars($e->getTraceAsString());
    echo "</pre>";
    exit(1);
}


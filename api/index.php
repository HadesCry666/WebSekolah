<?php

// Pastikan folder /tmp untuk cache views tersedia di serverless Vercel
$dirs = ['/tmp/views', '/tmp/cache'];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Set HTTPS headers for serverless reverse proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

require __DIR__ . '/../public/index.php';

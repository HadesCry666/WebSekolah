<?php

// Pastikan folder /tmp untuk cache views tersedia di serverless Vercel
$dirs = ['/tmp/views', '/tmp/cache'];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

require __DIR__ . '/../public/index.php';

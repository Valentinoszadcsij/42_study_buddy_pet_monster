<?php


function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        throw new Exception(".env file not found at: $filePath");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            $value = trim($value, '"\'');

            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

$envFile = __DIR__ . '/../../.env';
if (file_exists($envFile)) {
    loadEnv($envFile);
}

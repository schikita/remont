<?php

/**
 * Router for PHP built-in server (`php -S … -t public`).
 * Serves existing files from `public/`, otherwise boots Laravel via `index.php`.
 *
 * Usage from project root:
 *   php -S localhost:8080 -t public public/router.php
 */

$publicPath = __DIR__;

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

if ($uri !== '/' && file_exists($publicPath.$uri)) {
    return false;
}

require_once $publicPath.'/index.php';

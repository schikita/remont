<?php

namespace App\Support;

final class MediaUrl
{
    /**
     * Public URL for a file on the `public` disk.
     * Uses a root-relative path so the logo works on any host/port (APP_URL may be localhost while the site is opened via 127.0.0.1, etc.).
     */
    public static function public(?string $path): ?string
    {
        $path = self::normalizePath($path);
        if ($path === null || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $path = str_replace('\\', '/', $path);
        $path = ltrim($path, '/');
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        return '/storage/'.$path;
    }

    private static function normalizePath(?string $path): ?string
    {
        if ($path === null) {
            return null;
        }

        $path = trim($path);
        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, '[')) {
            $decoded = json_decode($path, true);
            if (is_array($decoded)) {
                $first = $decoded[0] ?? null;
                if (is_string($first) && $first !== '') {
                    return $first;
                }
            }
        }

        return $path;
    }
}

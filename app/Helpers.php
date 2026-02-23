<?php
declare(strict_types=1);

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function format_price(int $cents): string {
    return number_format($cents / 100, 2, ',', ' ') . ' €';
}

function url(string $path = ''): string {
    $base = rtrim(BASE_URL, '/');
    $path = ltrim($path, '/');
    return $base . '/' . $path;
}

function redirect(string $path): void {
    header('Location: ' . url($path));
    exit;
}

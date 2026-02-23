<?php
declare(strict_types=1);

final class Session {
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = []; // productId => qty
            }
        }
    }

    public static function csrfToken(): string {
        return $_SESSION['csrf_token'] ?? '';
    }

    public static function checkCsrf(?string $token): bool {
        return $token !== null && hash_equals(self::csrfToken(), $token);
    }

    public static function flash(string $key, ?string $message = null): ?string {
        if ($message === null) {
            $msg = $_SESSION['_flash'][$key] ?? null;
            unset($_SESSION['_flash'][$key]);
            return $msg;
        }
        $_SESSION['_flash'][$key] = $message;
        return null;
    }
}

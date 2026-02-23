<?php
declare(strict_types=1);

final class Cart {
    public static function all(): array {
        return $_SESSION['cart'] ?? [];
    }

    public static function add(int $productId, int $qty = 1): void {
        if ($qty < 1) $qty = 1;
        $_SESSION['cart'][$productId] = (int)(($_SESSION['cart'][$productId] ?? 0) + $qty);
    }

    public static function set(int $productId, int $qty): void {
        if ($qty <= 0) {
            unset($_SESSION['cart'][$productId]);
        } else {
            $_SESSION['cart'][$productId] = (int)$qty;
        }
    }

    public static function remove(int $productId): void {
        unset($_SESSION['cart'][$productId]);
    }

    public static function empty(): void {
        $_SESSION['cart'] = [];
    }
}

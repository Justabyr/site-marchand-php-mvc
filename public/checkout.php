<?php
require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Db.php';
require_once __DIR__ . '/../app/Session.php';
require_once __DIR__ . '/../app/Helpers.php';
require_once __DIR__ . '/../app/Cart.php';
Session::start();

$pdo = DB::pdo();
$cart = Cart::all();

if (!$cart) {
    Session::flash('error', 'Panier vide.');
    redirect('cart.php');
}

// Calcul du total et constitution des lignes
$ids = implode(',', array_map('intval', array_keys($cart)));
$rows = $pdo->query("SELECT id, name, price_cents FROM produits WHERE id IN ($ids)")->fetchAll();
$map = [];
foreach ($rows as $r) $map[$r['id']] = $r;

$total = 0;
$lines = [];
foreach ($cart as $pid => $qty) {
    if (!isset($map[$pid])) continue;
    $price = (int)$map[$pid]['price_cents'];
    $line = $price * $qty;
    $total += $line;
    $lines[] = ['product_id' => (int)$pid, 'qty' => (int)$qty, 'unit_price_cents' => $price];
}

$pdo->beginTransaction();
try {
    // Création commande (simulée payée)
    $stmt = $pdo->prepare("INSERT INTO commandes (user_id, total_cents, status, created_at) VALUES (NULL, ?, 'payee', NOW())");
    $stmt->execute([$total]);
    $orderId = (int)$pdo->lastInsertId();

    // Détails
    $stmt2 = $pdo->prepare("INSERT INTO commande_items (commande_id, product_id, qty, unit_price_cents) VALUES (?, ?, ?, ?)");
    foreach ($lines as $ln) {
        $stmt2->execute([$orderId, $ln['product_id'], $ln['qty'], $ln['unit_price_cents']]);
    }

    $pdo->commit();
    Cart::empty();
    redirect('order-confirmation.php?id=' . $orderId);
} catch (Throwable $e) {
    $pdo->rollBack();
    Session::flash('error', 'Erreur lors de la commande.');
    redirect('cart.php');
}

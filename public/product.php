<?php
require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Db.php';
require_once __DIR__ . '/../app/Session.php';
require_once __DIR__ . '/../app/Helpers.php';
require_once __DIR__ . '/../app/Cart.php';
Session::start();

$slug = (string)($_GET['slug'] ?? '');
$pdo = DB::pdo();
$stmt = $pdo->prepare("SELECT * FROM produits WHERE slug = ? AND actif = 1 LIMIT 1");
$stmt->execute([$slug]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
    echo "Produit introuvable.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Session::checkCsrf($_POST['csrf'] ?? null)) {
        Session::flash('error', 'Action invalide (CSRF).');
        redirect('product.php?slug=' . urlencode($slug));
    }
    $qty = (int)($_POST['qty'] ?? 1);
    Cart::add((int)$product['id'], $qty);
    Session::flash('success', 'Produit ajouté au panier.');
    redirect('product.php?slug=' . urlencode($slug));
}
?>
<?php include __DIR__ . '/partials/head.php'; ?>
<?php include __DIR__ . '/partials/header.php'; ?>

<article class="card">
  <h1><?= e($product['name']) ?></h1>
  <p><?= nl2br(e($product['description'])) ?></p>
  <p class="price"><?= format_price((int)$product['price_cents']) ?></p>
  <form method="post">
    <input type="hidden" name="csrf" value="<?= e(Session::csrfToken()) ?>">
    <input type="number" name="qty" value="1" min="1">
    <button type="submit" class="btn">Ajouter au panier</button>
  </form>
</article>

<?php include __DIR__ . '/partials/footer.php'; ?>

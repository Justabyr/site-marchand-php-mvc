<?php
require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Db.php';
require_once __DIR__ . '/../app/Session.php';
require_once __DIR__ . '/../app/Helpers.php';
require_once __DIR__ . '/../app/Cart.php';
Session::start();

$pdo = DB::pdo();
$products = $pdo->query("SELECT id, name, slug, price_cents FROM produits WHERE actif = 1 ORDER BY id DESC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Session::checkCsrf($_POST['csrf'] ?? null)) {
        Session::flash('error', 'Action invalide (CSRF).');
        redirect('shop.php');
    }
    $id = (int)($_POST['id'] ?? 0);
    $qty = (int)($_POST['qty'] ?? 1);
    Cart::add($id, $qty);
    Session::flash('success', 'Produit ajouté au panier.');
    redirect('shop.php');
}
?>
<?php include __DIR__ . '/partials/head.php'; ?>
<?php include __DIR__ . '/partials/header.php'; ?>

<h1>Produits</h1>
<div class="grid">
  <?php foreach ($products as $p): ?>
    <article class="card">
      <h3><a href="<?= url('product.php?slug=' . urlencode($p['slug'])) ?>"><?= e($p['name']) ?></a></h3>
      <p class="price"><?= format_price((int)$p['price_cents']) ?></p>
      <form method="post">
        <input type="hidden" name="csrf" value="<?= e(Session::csrfToken()) ?>">
        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
        <input type="number" name="qty" value="1" min="1">
        <button type="submit" class="btn">Ajouter</button>
      </form>
    </article>
  <?php endforeach; ?>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>

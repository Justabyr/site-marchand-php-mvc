<?php
require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Db.php';
require_once __DIR__ . '/../app/Session.php';
require_once __DIR__ . '/../app/Helpers.php';
require_once __DIR__ . '/../app/Cart.php';
Session::start();

$pdo = DB::pdo();
$cart = Cart::all();

// Handle updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Session::checkCsrf($_POST['csrf'] ?? null)) {
        Session::flash('error', 'Action invalide (CSRF).');
        redirect('cart.php');
    }
    if (isset($_POST['update'])) {
        foreach ($_POST['qty'] ?? [] as $pid => $qty) {
            Cart::set((int)$pid, (int)$qty);
        }
        Session::flash('success', 'Panier mis à jour.');
    } elseif (isset($_POST['empty'])) {
        Cart::empty();
        Session::flash('success', 'Panier vidé.');
    }
    redirect('cart.php');
}

// Resolve product infos
$items = [];
$total = 0;
if ($cart) {
    $ids = implode(',', array_map('intval', array_keys($cart)));
    $rows = $pdo->query("SELECT id, name, price_cents FROM produits WHERE id IN ($ids)")->fetchAll();
    $map = [];
    foreach ($rows as $r) $map[$r['id']] = $r;
    foreach ($cart as $pid => $qty) {
        if (!isset($map[$pid])) continue;
        $name = $map[$pid]['name'];
        $price = (int)$map[$pid]['price_cents'];
        $line = $price * $qty;
        $items[] = ['id'=>$pid, 'name'=>$name, 'qty'=>$qty, 'unit'=>$price, 'line'=>$line];
        $total += $line;
    }
}
?>
<?php include __DIR__ . '/partials/head.php'; ?>
<?php include __DIR__ . '/partials/header.php'; ?>

<h1>Votre panier</h1>
<?php if (!$items): ?>
  <p>Votre panier est vide.</p>
<?php else: ?>
  <form method="post">
    <input type="hidden" name="csrf" value="<?= e(Session::csrfToken()) ?>">
    <table class="table">
      <thead><tr><th>Produit</th><th>Qté</th><th>Prix</th><th>Total</th></tr></thead>
      <tbody>
      <?php foreach ($items as $it): ?>
        <tr>
          <td><?= e($it['name']) ?></td>
          <td><input type="number" name="qty[<?= (int)$it['id'] ?>]" value="<?= (int)$it['qty'] ?>" min="0"></td>
          <td><?= format_price($it['unit']) ?></td>
          <td><?= format_price($it['line']) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
      <tfoot><tr><th colspan="3" class="right">Total</th><th><?= format_price($total) ?></th></tr></tfoot>
    </table>
    <div class="actions">
      <button class="btn" type="submit" name="update">Mettre à jour</button>
      <button class="btn outline" type="submit" name="empty">Vider</button>
      <a class="btn primary" href="<?= url('checkout.php') ?>">Valider la commande</a>
    </div>
  </form>
<?php endif; ?>

<?php include __DIR__ . '/partials/footer.php'; ?>

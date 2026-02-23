<?php
require_once __DIR__ . '/../../app/Config.php';
require_once __DIR__ . '/../../app/Db.php';
require_once __DIR__ . '/../../app/Session.php';
require_once __DIR__ . '/../../app/Helpers.php';
Session::start();

if (!isset($_SESSION['admin_id'])) {
    redirect('login.php');
}

$pdo = DB::pdo();
$orders = $pdo->query("
    SELECT c.id, c.total_cents, c.status, c.created_at, COUNT(ci.id) AS items
    FROM commandes c
    LEFT JOIN commande_items ci ON ci.commande_id = c.id
    GROUP BY c.id
    ORDER BY c.id DESC
")->fetchAll();

?>
<?php include __DIR__ . '/../partials/head.php'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<h1>Admin — Commandes</h1>
<table class="table">
  <thead><tr><th>#</th><th>Créée le</th><th>Articles</th><th>Total</th><th>Statut</th></tr></thead>
  <tbody>
  <?php foreach ($orders as $o): ?>
    <tr>
      <td>#<?= (int)$o['id'] ?></td>
      <td><?= e($o['created_at']) ?></td>
      <td><?= (int)$o['items'] ?></td>
      <td><?= format_price((int)$o['total_cents']) ?></td>
      <td><?= e($o['status']) ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../partials/footer.php'; ?>

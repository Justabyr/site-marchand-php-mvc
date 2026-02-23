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

// CRUD très simple (Create + toggle actif)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Session::checkCsrf($_POST['csrf'] ?? null)) {
        Session::flash('error', 'Action invalide (CSRF).');
        redirect('products.php');
    }
    if (isset($_POST['create'])) {
        $name = trim((string)($_POST['name'] ?? ''));
        $slug = trim((string)($_POST['slug'] ?? ''));
        $desc = trim((string)($_POST['description'] ?? ''));
        $price = (int)($_POST['price_cents'] ?? 0);
        $pdo->prepare("INSERT INTO produits (name, slug, description, price_cents, stock, actif, created_at, updated_at) VALUES (?, ?, ?, ?, 100, 1, NOW(), NOW())")
            ->execute([$name, $slug, $desc, $price]);
        Session::flash('success', 'Produit créé.');
    } elseif (isset($_POST['toggle'])) {
        $id = (int)$_POST['id'];
        $pdo->prepare("UPDATE produits SET actif = 1 - actif, updated_at = NOW() WHERE id = ?")->execute([$id]);
        Session::flash('success', 'Statut produit modifié.');
    }
    redirect('products.php');
}

$products = $pdo->query("SELECT * FROM produits ORDER BY id DESC")->fetchAll();
?>
<?php include __DIR__ . '/../partials/head.php'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<h1>Admin — Produits</h1>

<form method="post" class="card">
  <input type="hidden" name="csrf" value="<?= e(Session::csrfToken()) ?>">
  <h2>Créer un produit</h2>
  <div class="grid g2">
    <div class="field"><label>Nom</label><input name="name" required></div>
    <div class="field"><label>Slug</label><input name="slug" required></div>
  </div>
  <div class="field"><label>Description</label><textarea name="description" rows="3"></textarea></div>
  <div class="field"><label>Prix (centimes)</label><input name="price_cents" type="number" value="990"></div>
  <button class="btn" name="create" type="submit">Créer</button>
</form>

<table class="table">
  <thead><tr><th>ID</th><th>Nom</th><th>Prix</th><th>Actif</th><th>Action</th></tr></thead>
  <tbody>
  <?php foreach ($products as $p): ?>
    <tr>
      <td><?= (int)$p['id'] ?></td>
      <td><?= e($p['name']) ?></td>
      <td><?= format_price((int)$p['price_cents']) ?></td>
      <td><?= (int)$p['actif'] ? 'Oui' : 'Non' ?></td>
      <td>
        <form method="post" style="display:inline">
          <input type="hidden" name="csrf" value="<?= e(Session::csrfToken()) ?>">
          <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
          <button class="btn outline" name="toggle" type="submit">Activer/Désactiver</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../partials/footer.php'; ?>

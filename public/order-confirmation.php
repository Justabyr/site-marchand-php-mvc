<?php
require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Db.php';
require_once __DIR__ . '/../app/Session.php';
require_once __DIR__ . '/../app/Helpers.php';
Session::start();

$id = (int)($_GET['id'] ?? 0);
?>
<?php include __DIR__ . '/partials/head.php'; ?>
<?php include __DIR__ . '/partials/header.php'; ?>

<h1>Merci pour votre commande</h1>
<p>Votre numéro de commande est <strong>#<?= $id ?></strong>.</p>
<p><a class="btn" href="<?= url('shop.php') ?>">Continuer mes achats</a></p>

<?php include __DIR__ . '/partials/footer.php'; ?>

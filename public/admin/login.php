<?php
require_once __DIR__ . '/../../app/Config.php';
require_once __DIR__ . '/../../app/Db.php';
require_once __DIR__ . '/../../app/Session.php';
require_once __DIR__ . '/../../app/Helpers.php';
Session::start();

// Simple login d'admin en exemple (sans système de rôles complet pour MVP)
$pdo = DB::pdo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash']) && $user['role'] === 'admin') {
        $_SESSION['admin_id'] = (int)$user['id'];
        redirect('products.php');
    }
    Session::flash('error', 'Identifiants invalides.');
    redirect('login.php');
}
?>
<?php include __DIR__ . '/../partials/head.php'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<h1>Connexion Admin</h1>
<form method="post">
  <input type="hidden" name="csrf" value="<?= e(Session::csrfToken()) ?>">
  <div class="field"><label>Email</label><input type="email" name="email" required></div>
  <div class="field"><label>Mot de passe</label><input type="password" name="password" required></div>
  <button class="btn" type="submit">Se connecter</button>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>

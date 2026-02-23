<header class="container">
  <nav class="nav">
    <a href="<?= url('') ?>" class="brand">Ma Boutique</a>
    <div class="links">
      <a href="<?= url('shop.php') ?>">Boutique</a>
      <a href="<?= url('cart.php') ?>">Panier (<?= array_sum(Cart::all()) ?>)</a>
      <a href="<?= url('admin/login.php') ?>">Admin</a>
    </div>
  </nav>
  <?php if ($msg = Session::flash('success')): ?>
    <div class="flash success"><?= e($msg) ?></div>
  <?php endif; ?>
  <?php if ($msg = Session::flash('error')): ?>
    <div class="flash error"><?= e($msg) ?></div>
  <?php endif; ?>
</header>
<main class="container">

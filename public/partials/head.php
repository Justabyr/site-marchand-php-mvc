<?php
require_once __DIR__ . '/../../app/Config.php';
require_once __DIR__ . '/../../app/Db.php';
require_once __DIR__ . '/../../app/Session.php';
require_once __DIR__ . '/../../app/Helpers.php';
require_once __DIR__ . '/../../app/Cart.php';

Session::start();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ma Boutique — MVP</title>
  <link rel="stylesheet" href="<?= url('assets/style.css') ?>">
</head>
<body>

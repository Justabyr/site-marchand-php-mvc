<?php
// Configuration globale du projet
declare(strict_types=1);

define('DB_HOST', 'localhost');
define('DB_NAME', 'boutique_mvp');
define('DB_USER', 'root');
define('DB_PASS', '');

// Adaptez au dossier local (ex: http://localhost/site-marchand-mvp/public)
define('BASE_URL', 'http://localhost:8000');

// Affichage des erreurs en dev (à désactiver en prod)
ini_set('display_errors', '1');
error_reporting(E_ALL);

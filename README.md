# Site Marchand (PHP - MVC)

## Description
Site e-commerce développé en **PHP** avec une **architecture MVC**, permettant la gestion d’un catalogue produits, panier, commandes et une interface administrateur.

## Fonctionnalités
- Affichage catalogue produits
- Page produit
- Ajout au panier / gestion quantités
- Passage de commande
- Interface **Admin** : gestion produits & commandes
- Base de données **MySQL** (script de création + données de test)

## Architecture
- `app/` : logique métier (classes, helpers, config, DB…)
- `public/` : pages accessibles + assets + admin
- `sql/` : scripts `schema.sql` et `seed.sql`

## Installation (local)
1. Installer un serveur local (WAMP/XAMPP)
2. Importer la base :
   - `sql/schema.sql`
   - `sql/seed.sql`
3. Configurer l’accès BDD dans `app/Config.php`
4. Lancer : `http://localhost/siteMarchand/public/shop.php`

## 🛠 Technologies
- PHP
- MySQL
- HTML / CSS
- Architecture MVC

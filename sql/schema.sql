-- Base & charset
CREATE DATABASE IF NOT EXISTS boutique CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE boutique;

-- Utilisateurs
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(191) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('client','admin') NOT NULL DEFAULT 'client',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
     
-- Produits
CREATE TABLE IF NOT EXISTS produits (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  produit VARCHAR(191) NOT NULL,                    -- ou nom
  descriptions TEXT NULL,                            -- (singulier)
  prix DECIMAL(10, 2) UNSIGNED NOT NULL,                 -- 
  stock INT UNSIGNED NOT NULL DEFAULT 0,
  image_url VARCHAR(255) NULL,                      -- pour les visuels
  actif TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_produits_actif (actif),
  INDEX idx_produits_created (created_at)
) ENGINE=InnoDB;

-- Commandes
CREATE TABLE IF NOT EXISTS commandes (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NULL,                        -- NULL = invité possible
  total DECIMAL(10, 2) UNSIGNED NOT NULL,               
  statut ENUM('en_attente','payee','annulee') NOT NULL DEFAULT 'en_attente',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_commandes_user FOREIGN KEY (user_id) REFERENCES users(id) 
    ON DELETE SET NULL ON UPDATE CASCADE,
  INDEX idx_commandes_user_date (user_id, created_at),
  INDEX idx_commandes_statut (statut)
) ENGINE=InnoDB;

-- Lignes de commande
CREATE TABLE IF NOT EXISTS commande_items (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  commande_id BIGINT UNSIGNED NOT NULL,
  produit_id INT UNSIGNED NOT NULL,
  qty INT UNSIGNED NOT NULL,
  unit_prix DECIMAL(10, 2) UNSIGNED NOT NULL,
  CONSTRAINT fk_items_commande FOREIGN KEY (commande_id) REFERENCES commandes(id) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_items_produit FOREIGN KEY (produit_id) REFERENCES produits(id) 
    ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX idx_items_commande (commande_id),
  INDEX idx_items_produit (produit_id),
  INDEX idx_items_commande_produit (commande_id, produit_id)
) ENGINE=InnoDB;

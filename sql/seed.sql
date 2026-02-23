USE boutique;

-- Seed utilisateurs (1 admin par défaut, mot de passe = 'admin123')
INSERT INTO users (email, password_hash, role) VALUES
('admin@boutique.com', 
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- hash de 'password'
 'admin');

-- Seed produits
INSERT INTO produits (produit, slug, description, prix_cents, stock, image_url, actif) VALUES
('Smartphone Galaxy Z', 'smartphone-galaxy-z', 'Smartphone dernière génération avec écran pliable et 5G.', 89999, 10, 'public/assets/images/smartphone_galaxyz.jpg', 1),
('iPhone 15 Pro', 'iphone-15-pro', 'iPhone haut de gamme avec puce A17 et triple capteur photo.', 119900, 12, 'public/assets/images/iphone15pro.jpg', 1),
('Ordinateur Portable Ultrabook', 'ultrabook', 'PC portable léger avec 16Go RAM et SSD 512Go.', 109900, 8, 'public/assets/images/ultrabook.jpg', 1),
('MacBook Air M2', 'macbook-air-m2', 'Laptop Apple avec puce M2, 13 pouces, autonomie 18h.', 129900, 5, 'public/assets/images/macbook_air_m2.jpg', 1),
('Casque Bluetooth Pro', 'casque-bluetooth-pro', 'Casque sans fil avec réduction active du bruit.', 14999, 15, 'public/assets/images/casque_bluetooth.jpg', 1),
('Écouteurs AirPods Pro 2', 'airpods-pro-2', 'Écouteurs Apple avec réduction de bruit et autonomie 6h.', 24900, 20, 'public/assets/images/airpods_pro2.jpg', 1),
('Tablette Galaxy Tab S9', 'galaxy-tab-s9', 'Tablette AMOLED 11 pouces, 8Go RAM et stylet inclus.', 79999, 7, 'public/assets/images/galaxy_tab_s9.jpg', 1),
('iPad Pro 12.9', 'ipad-pro-129', 'Tablette Apple avec puce M2 et écran Liquid Retina.', 139900, 6, 'public/assets/images/ipad_pro.jpg', 1),
('Montre Connectée FitPro', 'montre-fitpro', 'Montre intelligente avec suivi santé et GPS.', 12900, 18, 'public/assets/images/fitpro_watch.jpg', 1),
('Apple Watch Series 9', 'apple-watch-9', 'Montre connectée Apple avec suivi avancé.', 49900, 10, 'public/assets/images/apple_watch9.jpg', 1),
('Enceinte Bluetooth JBL Charge 5', 'jbl-charge-5', 'Enceinte portable étanche avec son puissant.', 17999, 25, 'public/assets/images/jbl_charge5.jpg', 1),
('GoPro Hero 12', 'gopro-hero-12', 'Caméra sportive 5K avec stabilisation avancée.', 49900, 9, 'public/assets/images/gopro_hero12.jpg', 1),
('Appareil Photo Sony Alpha 7 IV', 'sony-alpha-7-iv', 'Hybride plein format 33 MP, vidéo 4K 60fps.', 249900, 4, 'public/assets/images/sony_a7iv.jpg', 1),
('Clavier Mécanique RGB', 'clavier-rgb', 'Clavier gaming mécanique avec rétroéclairage RGB.', 9999, 30, 'public/assets/images/clavier_rgb.jpg', 1),
('Souris Gaming Logitech G502', 'logitech-g502', 'Souris gaming filaire avec capteur HERO 25K.', 7999, 35, 'public/assets/images/logitech_g502.jpg', 1);


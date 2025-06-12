CREATE DATABASE IF NOT EXISTS product_catalog;
USE product_catalog;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    author VARCHAR(100) NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO products (name, image_path, price, description) VALUES
('Смартфон Apple iPhone 16 Pro 256GB Desert Titanium', 'img/products/iphone-16-pro-256-desert-titamium.avif', 124999, 'Современный смартфон с мощным процессором и ярким экраном'),
('Ноутбук HONOR Magicbook X16 2025/16"/Core i5 13420H/16/512Gb/Win11/Серый (5301ALWS)', 'img/products/honor-5301ALWS.avif', 56999, 'Легкий и производительный ноутбук для работы и учебы'),
('Наушники Apple AirPods Pro 2 generation MagSafe Case USB-C (MTJV3)', 'img/products/airpods-MTJV3.avif', 23999, 'Беспроводные наушники с шумоподавлением и высоким качеством звука');

INSERT INTO reviews (product_id, author, rating, comment) VALUES
(1, 'Александр', 5, 'Отличный смартфон, очень доволен покупкой!'),
(1, 'Елена', 4, 'Хороший телефон, но батарея могла бы работать дольше'),
(2, 'Иван', 5, 'Ноутбук превзошел все мои ожидания!'),
(3, 'Мария', 3, 'Наушники хорошие, но есть проблемы с подключением по Bluetooth');
CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    parent_id INT NULL,
    FOREIGN KEY (parent_id) REFERENCES menu_items(id) ON DELETE CASCADE
);

INSERT INTO menu_items (id, name, parent_id) VALUES (1, 'Каталог товаров', NULL);

INSERT INTO menu_items (id, name, parent_id) VALUES (2, 'Мойки', 1);
INSERT INTO menu_items (id, name, parent_id) VALUES (3, 'Фильтры', 1);

INSERT INTO menu_items (id, name, parent_id) VALUES (4, 'Ulgran', 2);
INSERT INTO menu_items (id, name, parent_id) VALUES (5, 'Vigro Mramor', 2);
INSERT INTO menu_items (id, name, parent_id) VALUES (6, 'Handmade', 2);
INSERT INTO menu_items (id, name, parent_id) VALUES (7, 'Vigro Glass', 2);

INSERT INTO menu_items (id, name, parent_id) VALUES (8, 'Ulgran', 3);
INSERT INTO menu_items (id, name, parent_id) VALUES (9, 'Vigro Mramor', 3);

INSERT INTO menu_items (id, name, parent_id) VALUES (10, 'Smth', 4);
INSERT INTO menu_items (id, name, parent_id) VALUES (11, 'Smth', 4);

INSERT INTO menu_items (id, name, parent_id) VALUES (12, 'Smth', 6);
INSERT INTO menu_items (id, name, parent_id) VALUES (13, 'Smth', 6);

INSERT INTO menu_items (id, name, parent_id) VALUES (14, 'Smth', 8);
INSERT INTO menu_items (id, name, parent_id) VALUES (15, 'Smth', 8);

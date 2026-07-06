SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS suppliers;
DROP TABLE IF EXISTS categories;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE categories (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    created_at DATETIME NULL,
    is_deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE suppliers (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    company_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NULL,
    country VARCHAR(100) NOT NULL,
    created_at DATETIME NULL,
    is_deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY suppliers_email_unique (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE products (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    sku VARCHAR(80) NOT NULL,
    weight INT UNSIGNED NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    supplier_id INT UNSIGNED NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    is_deleted TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY products_sku_unique (sku),
    KEY products_category_id_index (category_id),
    KEY products_supplier_id_index (supplier_id),
    CONSTRAINT products_category_id_foreign
        FOREIGN KEY (category_id) REFERENCES categories (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT products_supplier_id_foreign
        FOREIGN KEY (supplier_id) REFERENCES suppliers (id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO categories (id, name, description, created_at, is_deleted) VALUES
(1, 'Electronics', 'Electronic devices and accessories', NOW(), 0),
(2, 'Furniture', 'Home and office furniture', NOW(), 0),
(3, 'Kitchen', 'Kitchen tools and appliances', NOW(), 0),
(4, 'Office Supplies', 'Products used in offices and workspaces', NOW(), 0),
(5, 'Sports', 'Sports equipment and accessories', NOW(), 0);

INSERT INTO suppliers (id, company_name, email, phone, country, created_at, is_deleted) VALUES
(1, 'Tech Supplier', 'contact@techsupplier.com', '+33123456789', 'France', NOW(), 0),
(2, 'Home Distribution', 'sales@homedistribution.com', '+33456789123', 'France', NOW(), 0),
(3, 'Office Pro', 'hello@officepro.com', '+33199887766', 'Belgium', NOW(), 0),
(4, 'Global Sports Supply', 'contact@globalsports.com', '+34987654321', 'Spain', NOW(), 0);

INSERT INTO products (
    id,
    name,
    sku,
    weight,
    price,
    stock_quantity,
    category_id,
    supplier_id,
    created_at,
    updated_at,
    is_deleted
) VALUES
(1, 'Gaming Mouse', 'MOUSE-001', 1200, 39.99, 8, 1, 1, NOW(), NOW(), 0),
(2, 'Mechanical Keyboard', 'KEYBOARD-001', 1100, 79.99, 12, 1, 1, NOW(), NOW(), 0),
(3, 'USB-C Cable', 'CABLE-001', 100, 9.99, 50, 1, 1, NOW(), NOW(), 0),
(4, 'Office Chair', 'CHAIR-001', 7000, 89.99, 15, 2, 2, NOW(), NOW(), 0),
(5, 'Wooden Desk', 'DESK-001', 25000, 149.99, 6, 2, 2, NOW(), NOW(), 0),
(6, 'Electric Kettle', 'KETTLE-001', 900, 29.99, 5, 3, 1, NOW(), NOW(), 0),
(7, 'Coffee Machine', 'COFFEE-001', 1800, 45.99, 4, 3, 2, NOW(), NOW(), 0),
(8, 'Notebook Pack', 'NOTEBOOK-001', 600, 12.99, 30, 4, 3, NOW(), NOW(), 0),
(9, 'Printer Paper Box', 'PAPER-001', 2500, 19.99, 9, 4, 3, NOW(), NOW(), 0),
(10, 'Yoga Mat', 'YOGA-001', 1300, 24.99, 20, 5, 4, NOW(), NOW(), 0),
(11, 'Football', 'FOOTBALL-001', 450, 19.99, 7, 5, 4, NOW(), NOW(), 0);

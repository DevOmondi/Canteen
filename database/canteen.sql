CREATE DATABASE IF NOT EXISTS canteen_system;
USE canteen_system;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff', 'customer') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    department VARCHAR(255),
    position VARCHAR(255),
    contact_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    quantity_in_stock INT NOT NULL DEFAULT 0,
    status ENUM('in_stock', 'out_of_stock') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Orders table 
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_type ENUM('regular', 'pre_order') NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'canceled') NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    pickup_datetime DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Order items table (to store individual items in each order)
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price_per_unit DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Create views for easy statistics
CREATE VIEW vw_total_staff AS
SELECT COUNT(*) as total_staff FROM staff;

CREATE VIEW vw_product_stats AS
SELECT 
    COUNT(*) as total_products,
    SUM(CASE WHEN status = 'in_stock' THEN 1 ELSE 0 END) as in_stock_products,
    SUM(CASE WHEN status = 'out_of_stock' THEN 1 ELSE 0 END) as out_of_stock_products
FROM products;

CREATE VIEW vw_order_stats AS
SELECT 
    COUNT(*) as total_orders,
    SUM(CASE WHEN order_type = 'pre_order' THEN 1 ELSE 0 END) as total_preorders,
    SUM(CASE WHEN order_type = 'regular' THEN 1 ELSE 0 END) as total_regular_orders
FROM orders;

-- Sample data for testing
-- INSERT INTO users (name, email, password, role) VALUES
-- ('Admin User', 'admin@example.com', '$2y$10$example_hash', 'admin'),
-- ('Staff User', 'staff@example.com', '$2y$10$example_hash', 'staff');

INSERT INTO products (name, description, price, quantity_in_stock, status) VALUES
('Burger', 'Delicious beef burger', 9.99, 50, 'in_stock'),
('Pizza', 'Margherita pizza', 12.99, 30, 'in_stock'),
('Salad', 'Fresh garden salad', 6.99, 0, 'out_of_stock');
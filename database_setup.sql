-- Database Setup for Warehouse Pro
-- Run this SQL script to create the correct database structure

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS demo;
USE demo;

-- User table
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    user_name VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Invoice table (CORRECTED STRUCTURE)
DROP TABLE IF EXISTS invoice;
CREATE TABLE invoice (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(200) NOT NULL,
    email VARCHAR(150) NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'paid', 'cancelled') DEFAULT 'pending',
    total_amount DECIMAL(10,2) DEFAULT 0.00,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_customer_name (customer_name),
    INDEX idx_date (date),
    INDEX idx_status (status)
);

-- Invoice items table (CORRECTED STRUCTURE)
-- This is the main fix - ensuring 'id' is the PRIMARY KEY, not 'invoice_id'
DROP TABLE IF EXISTS invoice_item;
CREATE TABLE invoice_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    item_name VARCHAR(200) NOT NULL,
    qty INT NOT NULL DEFAULT 1,
    mrp DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (invoice_id) REFERENCES invoice(id) ON DELETE CASCADE,
    INDEX idx_invoice_id (invoice_id)
);

-- Insert sample data for testing (optional)
INSERT IGNORE INTO user (first_name, last_name, email, user_name, password) VALUES
('Admin', 'User', 'admin@warehouse.com', 'admin', MD5('admin123')),
('John', 'Doe', 'john@example.com', 'john', MD5('password123'));

-- Sample invoice data
INSERT INTO invoice (id, customer_name, email, total_amount) VALUES
(1, 'Sample Customer', 'sample@example.com', 350.00);

-- Clear any existing invoice_item data that might be causing conflicts
DELETE FROM invoice_item WHERE invoice_id = 1;

-- Insert sample invoice items
INSERT INTO invoice_item (invoice_id, item_name, qty, mrp, total_price) VALUES
(1, 'Sample Item 1', 2, 100.00, 200.00),
(1, 'Sample Item 2', 1, 150.00, 150.00);

-- Verify the structure
DESCRIBE invoice_item;

-- Show sample data
SELECT 
    i.id as invoice_id,
    i.customer_name,
    i.date,
    ii.id as item_id,
    ii.item_name,
    ii.qty,
    ii.mrp,
    ii.total_price
FROM invoice i
LEFT JOIN invoice_item ii ON i.id = ii.invoice_id
WHERE i.id = 1;

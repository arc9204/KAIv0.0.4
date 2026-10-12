-- ------------------------------------------------------------
-- KAI Aluminum & Glass Supply - website database
-- import this in phpMyAdmin (XAMPP) before running the site
-- ------------------------------------------------------------

CREATE DATABASE IF NOT EXISTS kai_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE kai_db;

-- messages from the "Send a Message" form
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    inquiry_type VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- appointments from the booking page
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reference_no VARCHAR(20) NOT NULL UNIQUE,
    service VARCHAR(50) NOT NULL,
    project_type VARCHAR(50) NOT NULL,
    booking_date DATE NOT NULL,
    booking_time VARCHAR(20) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    notes TEXT,
    status ENUM('Pending', 'Confirmed', 'Done', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- preliminary quotes from the estimator on the home page
CREATE TABLE IF NOT EXISTS quote_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50) NOT NULL,
    product_type VARCHAR(50) NOT NULL,
    width_cm DECIMAL(8,2) NOT NULL,
    height_cm DECIMAL(8,2) NOT NULL,
    quantity INT NOT NULL,
    glass_type VARCHAR(50),
    finish VARCHAR(50),
    estimated_cost DECIMAL(12,2) NOT NULL,
    plan_file VARCHAR(255),
    full_name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

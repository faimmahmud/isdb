CREATE DATABASE IF NOT EXISTS tourism_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tourism_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') NOT NULL DEFAULT 'user',
    created_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    destination VARCHAR(180) NOT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    rating DECIMAL(2,1) NOT NULL DEFAULT 4.5,
    category VARCHAR(60) NOT NULL DEFAULT 'Luxury',
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    package_id INT NULL,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    travel_date DATE NOT NULL,
    people INT NOT NULL DEFAULT 1,
    message TEXT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'Pending',
    created_at DATETIME NOT NULL,
    CONSTRAINT fk_booking_package FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE SET NULL
);

INSERT INTO users (name, email, password, role, created_at) VALUES
('Admin', 'admin@tourism.com', '$2y$12$T.JbVTOLVRHoglvXltzN4urDLRGxWxoxYCewV3XPiXe2f6zhBW7SS', 'admin', NOW())
ON DUPLICATE KEY UPDATE email = email;

INSERT INTO packages (title, destination, price, rating, category, description, image, created_at) VALUES
('Royal Bali Escape', 'Bali, Indonesia', 699.00, 4.9, 'Luxury', 'Private villa stay, ocean views, and a curated sunset itinerary for luxury travelers.', 'https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?auto=format&fit=crop&w=1200&q=80', NOW()),
('Swiss Alpine Retreat', 'Swiss Alps', 899.00, 5.0, 'Adventure', 'Premium mountain experience with scenic trains, chalet comfort, and snow adventures.', 'https://images.unsplash.com/photo-1517299321609-52687d1bc55a?auto=format&fit=crop&w=1200&q=80', NOW()),
('Dubai Skyline Luxe', 'Dubai, UAE', 799.00, 4.8, 'Luxury', 'City lights, luxury shopping, and an iconic stay with futuristic skyline views.', 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1200&q=80', NOW()),
('Kyoto Serenity Tour', 'Kyoto, Japan', 649.00, 4.7, 'Romantic', 'Elegant temples, garden walks, and a calm cultural escape with premium comfort.', 'https://images.unsplash.com/photo-1492571350019-22de08371fd3?auto=format&fit=crop&w=1200&q=80', NOW())
ON DUPLICATE KEY UPDATE title = title;

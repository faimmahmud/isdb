CREATE DATABASE IF NOT EXISTS tourism_arc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tourism_arc;

DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS packages;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE packages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  location VARCHAR(120) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  duration VARCHAR(80) NOT NULL,
  rating DECIMAL(2,1) NOT NULL DEFAULT 4.5,
  badge VARCHAR(40) NOT NULL DEFAULT 'Popular',
  image VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL,
  package VARCHAR(180) NOT NULL,
  travel_date DATE NOT NULL,
  guests INT NOT NULL DEFAULT 1,
  note TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO packages (title, location, price, duration, rating, badge, image, description) VALUES
('Cox’s Bazar Coastal Escape', 'Bangladesh', 14900, '3 Days / 2 Nights', 4.9, 'Trending', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80', 'A luxury beach getaway with sunrise views, private transfers, and premium resort stays.'),
('Sylhet Tea Garden Retreat', 'Bangladesh', 9900, '2 Days / 1 Night', 4.8, 'Popular', 'https://images.unsplash.com/photo-1518391846015-55a9cc003b25?auto=format&fit=crop&w=1200&q=80', 'Peaceful hills, tea gardens, waterfalls, and an elegant nature-first experience.'),
('Rangamati Lake Adventure', 'Bangladesh', 11600, '3 Days / 2 Nights', 4.7, 'Adventure', 'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1200&q=80', 'Boating, hill views, and a curated adventure itinerary for modern explorers.'),
('Saint Martin Island Luxury', 'Bangladesh', 18900, '4 Days / 3 Nights', 5.0, 'Luxury', 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=1200&q=80', 'Premium island vibes, crystal water, and a carefully designed premium holiday package.'),
('Bangkok City Lights', 'Thailand', 25900, '5 Days / 4 Nights', 4.8, 'International', 'https://images.unsplash.com/photo-1508009603885-50cf7c579365?auto=format&fit=crop&w=1200&q=80', 'Urban energy, shopping, nightlife, and guided city tours with smooth support.'),
('Bali Wellness Retreat', 'Indonesia', 32900, '6 Days / 5 Nights', 4.9, 'Wellness', 'https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?auto=format&fit=crop&w=1200&q=80', 'A serene escape with wellness experiences, premium villas, and a tropical arc aesthetic.');

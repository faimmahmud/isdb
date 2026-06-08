USE royal_atlas;

INSERT INTO users (id, name, email, password_hash, role) VALUES
(1, 'Royal Atlas Admin', 'admin@royalatlas.test', '$2y$10$SWAueklvVyaNiBl9SQOGzOt0nmheCdDc36FTHWLs7vkdMtGNkTQua', 'admin'),
(2, 'Demo Traveler', 'traveler@royalatlas.test', '$2y$10$SWAueklvVyaNiBl9SQOGzOt0nmheCdDc36FTHWLs7vkdMtGNkTQua', 'customer')
ON DUPLICATE KEY UPDATE name = VALUES(name), role = VALUES(role);

INSERT INTO destinations (id, title, country, category, summary, image, sort_order) VALUES
(1, 'Maldives Overwater Sanctuaries', 'Maldives', 'island', 'Private reef villas, glass lagoons, and moonlit dining above the Indian Ocean.', 'assets/images/destinations/maldives.webp', 1),
(2, 'Swiss Alpine Grand Tour', 'Switzerland', 'mountain', 'Helicopter transfers, glacier rail journeys, and quiet chalets above blue valleys.', 'assets/images/destinations/swiss-alps.webp', 2),
(3, 'Dubai Future Coast', 'United Arab Emirates', 'city', 'A polished skyline escape with desert dinners, yacht lounges, and private shopping.', 'assets/images/destinations/dubai.webp', 3),
(4, 'Santorini Blue Hour', 'Greece', 'heritage', 'Cycladic suites, caldera sailing, and a slow golden descent into the Aegean.', 'assets/images/destinations/santorini.webp', 4),
(5, 'Kyoto Silk Season', 'Japan', 'heritage', 'Temple gardens, tea rituals, ryokan evenings, and private cultural access.', 'assets/images/destinations/kyoto.webp', 5),
(6, 'Sahara Starlight Convoy', 'Morocco', 'desert', 'Cinematic dunes, luxury tented camps, and sunrise drives through copper sand.', 'assets/images/destinations/sahara.webp', 6),
(7, 'Bali Rainforest Hideaway', 'Indonesia', 'beach', 'Clifftop pools, rice terrace mornings, and slow island hospitality.', 'assets/images/destinations/bali.webp', 7),
(8, 'Iceland Aurora Circuit', 'Iceland', 'adventure', 'Black beaches, ice caves, geothermal retreats, and northern light nights.', 'assets/images/destinations/iceland.webp', 8)
ON DUPLICATE KEY UPDATE title = VALUES(title), summary = VALUES(summary), image = VALUES(image);

INSERT INTO packages (id, title, destination, category, price, rating, duration, description, highlights, image, status) VALUES
(1, 'Maldives Celestial Villa', 'Maldives', 'island', 4850, 4.9, '6 days', 'A private overwater escape with reef snorkeling, champagne sandbank dining, and sunset seaplane arrivals.', 'Overwater villa,Private reef guide,Sunset yacht dinner,Spa ritual', 'assets/images/destinations/maldives.webp', 'active'),
(2, 'Swiss Alps Signature Route', 'Switzerland', 'mountain', 6200, 4.8, '8 days', 'Glacier rail, helicopter viewpoints, lake hotels, and a private alpine dining program.', 'Glacier Express,Private chalet,Heli viewpoint,Michelin dinner', 'assets/images/destinations/swiss-alps.webp', 'active'),
(3, 'Dubai Golden Horizon', 'United Arab Emirates', 'city', 3900, 4.7, '5 days', 'A polished city and desert journey with skyline suites, yacht evenings, and private souk styling.', 'Skyline suite,Desert supper,Yacht lounge,Private shopping', 'assets/images/destinations/dubai.webp', 'active'),
(4, 'Kyoto Private Season', 'Japan', 'heritage', 5400, 4.9, '7 days', 'A quiet cultural itinerary with temple access, ryokan stays, tea ceremony, and chef-led dining.', 'Private temples,Ryokan suite,Tea master,Chef table', 'assets/images/destinations/kyoto.webp', 'active'),
(5, 'Sahara Nightfall Caravan', 'Morocco', 'desert', 3150, 4.8, '6 days', 'Luxury desert camping, cinematic dune drives, Atlas foothill lodges, and stargazing suppers.', 'Tented camp,Dune drive,Atlas lodge,Stargazing', 'assets/images/destinations/sahara.webp', 'active'),
(6, 'Iceland Aurora Atelier', 'Iceland', 'adventure', 5700, 4.8, '7 days', 'A northern light journey through black beaches, ice caves, geothermal spas, and volcanic coastlines.', 'Aurora chase,Ice cave,Geothermal spa,Black beach', 'assets/images/destinations/iceland.webp', 'active')
ON DUPLICATE KEY UPDATE title = VALUES(title), price = VALUES(price), status = VALUES(status);

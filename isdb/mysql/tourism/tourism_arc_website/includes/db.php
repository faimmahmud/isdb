<?php
declare(strict_types=1);

function tourism_db_connect(): ?mysqli
{
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'tourism_arc';

    $conn = @new mysqli($host, $user, $pass, $db);

    if ($conn->connect_errno) {
        return null;
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}

function tourism_fetch_packages(int $limit = 6): array
{
    $fallback = [
        [
            'id' => 1,
            'title' => 'Cox’s Bazar Coastal Escape',
            'location' => 'Bangladesh',
            'price' => 14900,
            'duration' => '3 Days / 2 Nights',
            'rating' => 4.9,
            'badge' => 'Trending',
            'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
            'description' => 'A luxury beach getaway with sunrise views, private transfers, and premium resort stays.'
        ],
        [
            'id' => 2,
            'title' => 'Sylhet Tea Garden Retreat',
            'location' => 'Bangladesh',
            'price' => 9900,
            'duration' => '2 Days / 1 Night',
            'rating' => 4.8,
            'badge' => 'Popular',
            'image' => 'https://images.unsplash.com/photo-1518391846015-55a9cc003b25?auto=format&fit=crop&w=1200&q=80',
            'description' => 'Peaceful hills, tea gardens, waterfalls, and an elegant nature-first experience.'
        ],
        [
            'id' => 3,
            'title' => 'Rangamati Lake Adventure',
            'location' => 'Bangladesh',
            'price' => 11600,
            'duration' => '3 Days / 2 Nights',
            'rating' => 4.7,
            'badge' => 'Adventure',
            'image' => 'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1200&q=80',
            'description' => 'Boating, hill views, and a curated adventure itinerary for modern explorers.'
        ],
        [
            'id' => 4,
            'title' => 'Saint Martin Island Luxury',
            'location' => 'Bangladesh',
            'price' => 18900,
            'duration' => '4 Days / 3 Nights',
            'rating' => 5.0,
            'badge' => 'Luxury',
            'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=1200&q=80',
            'description' => 'Premium island vibes, crystal water, and a carefully designed premium holiday package.'
        ],
        [
            'id' => 5,
            'title' => 'Bangkok City Lights',
            'location' => 'Thailand',
            'price' => 25900,
            'duration' => '5 Days / 4 Nights',
            'rating' => 4.8,
            'badge' => 'International',
            'image' => 'https://images.unsplash.com/photo-1508009603885-50cf7c579365?auto=format&fit=crop&w=1200&q=80',
            'description' => 'Urban energy, shopping, nightlife, and guided city tours with smooth support.'
        ],
        [
            'id' => 6,
            'title' => 'Bali Wellness Retreat',
            'location' => 'Indonesia',
            'price' => 32900,
            'duration' => '6 Days / 5 Nights',
            'rating' => 4.9,
            'badge' => 'Wellness',
            'image' => 'https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?auto=format&fit=crop&w=1200&q=80',
            'description' => 'A serene escape with wellness experiences, premium villas, and a tropical arc aesthetic.'
        ],
    ];

    $conn = tourism_db_connect();
    if (!$conn) {
        return array_slice($fallback, 0, $limit);
    }

    $sql = "SELECT id, title, location, price, duration, rating, badge, image, description
            FROM packages
            ORDER BY id DESC
            LIMIT ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $conn->close();
        return array_slice($fallback, 0, $limit);
    }

    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    $stmt->close();
    $conn->close();

    if (!$rows) {
        return array_slice($fallback, 0, $limit);
    }

    return $rows;
}

function tourism_fetch_all_destinations(): array
{
    return [
        ['name' => 'Cox’s Bazar', 'country' => 'Bangladesh', 'type' => 'Beach', 'description' => 'Golden beach, luxury resorts, sunsets'],
        ['name' => 'Sylhet', 'country' => 'Bangladesh', 'type' => 'Nature', 'description' => 'Tea gardens, rivers, hill views'],
        ['name' => 'Saint Martin', 'country' => 'Bangladesh', 'type' => 'Island', 'description' => 'Crystal water, coral vibe, island retreat'],
        ['name' => 'Rangamati', 'country' => 'Bangladesh', 'type' => 'Adventure', 'description' => 'Lakes, hills, boat tours, tribal culture'],
        ['name' => 'Bangkok', 'country' => 'Thailand', 'type' => 'City', 'description' => 'City lights, shopping, street food'],
        ['name' => 'Bali', 'country' => 'Indonesia', 'type' => 'Wellness', 'description' => 'Villas, beaches, spa, and calm escape'],
    ];
}

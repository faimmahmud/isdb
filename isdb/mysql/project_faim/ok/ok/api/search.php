<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';
header('Content-Type: application/json');

$term = strtolower(trim((string) ($_GET['q'] ?? '')));
$results = [];

if ($term !== '') {
    foreach (get_packages(['search' => $term], 6) as $package) {
        $results[] = [
            'type' => 'Package',
            'title' => $package['title'],
            'subtitle' => $package['destination'] . ' · $' . number_format((float) $package['price']),
            'url' => 'booking.php?package=' . (int) $package['id'],
        ];
    }

    foreach (get_destinations() as $destination) {
        $haystack = strtolower($destination['title'] . ' ' . $destination['country'] . ' ' . $destination['category']);

        if (str_contains($haystack, $term)) {
            $results[] = [
                'type' => 'Destination',
                'title' => $destination['title'],
                'subtitle' => $destination['country'] . ' · ' . ucfirst($destination['category']),
                'url' => 'destinations.php',
            ];
        }
    }
}

echo json_encode([
    'ok' => true,
    'results' => array_slice($results, 0, 8),
], JSON_UNESCAPED_SLASHES);

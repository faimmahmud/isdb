<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Method not allowed.']);
    exit;
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$phone = trim((string) ($_POST['phone'] ?? ''));
$packageId = (int) ($_POST['package_id'] ?? 0);
$travelDate = trim((string) ($_POST['travel_date'] ?? ''));
$guests = max(1, min(30, (int) ($_POST['guests'] ?? 1)));
$notes = trim((string) ($_POST['notes'] ?? ''));

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $phone === '' || !$packageId || $travelDate === '') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please complete all required booking fields.']);
    exit;
}

if (!get_package($packageId)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Choose a valid package.']);
    exit;
}

$bookingId = create_booking([
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'package_id' => $packageId,
    'travel_date' => $travelDate,
    'guests' => $guests,
    'notes' => $notes,
]);

echo json_encode([
    'ok' => true,
    'message' => 'Booking request received. Your concierge will contact you shortly.',
    'booking_id' => $bookingId,
], JSON_UNESCAPED_SLASHES);

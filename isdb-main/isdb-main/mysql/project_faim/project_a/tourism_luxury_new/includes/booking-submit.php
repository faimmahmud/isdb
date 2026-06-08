<?php
require_once __DIR__ . '/functions.php';
header('Content-Type: application/json');

ensure_storage();

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$package = trim($_POST['package'] ?? '');
$date = trim($_POST['date'] ?? '');
$people = (int)($_POST['people'] ?? 1);
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $phone === '' || $package === '' || $date === '') {
    echo json_encode(['success' => false, 'message' => 'Please complete all required booking fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

$bookings = read_bookings();
$bookings[] = [
    'id' => uniqid('bk_', true),
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'package' => $package,
    'date' => $date,
    'people' => $people,
    'message' => $message,
    'created_at' => date('c')
];

write_bookings($bookings);
echo json_encode(['success' => true, 'message' => 'Booking submitted successfully. We will contact you shortly.']);

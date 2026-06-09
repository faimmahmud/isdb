<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'success' => false,
    'message' => 'Invalid request.'
  ]);
  exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$destination = trim($_POST['destination'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $destination === '' || $message === '') {
  echo json_encode([
    'success' => false,
    'message' => 'Please fill all required fields.'
  ]);
  exit;
}

$payload = [
  'name' => $name,
  'email' => $email,
  'phone' => $phone,
  'destination' => $destination,
  'message' => $message,
  'time' => date('Y-m-d H:i:s')
];

file_put_contents('submissions.txt', json_encode($payload) . PHP_EOL, FILE_APPEND);

echo json_encode([
  'success' => true,
  'message' => 'Your inquiry has been received.'
]);
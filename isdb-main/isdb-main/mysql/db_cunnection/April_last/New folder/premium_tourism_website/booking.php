<?php
require_once __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $travel_date = trim($_POST['travel_date'] ?? '');
    $people = (int)($_POST['people'] ?? 1);
    $package_id = (int)($_POST['package_id'] ?? 0);
    $message = trim($_POST['message'] ?? '');

    $errors = [];
    if ($name === '') $errors[] = 'Name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if ($phone === '') $errors[] = 'Phone number is required.';
    if ($travel_date === '') $errors[] = 'Travel date is required.';
    if ($people < 1) $errors[] = 'People must be at least 1.';
    if ($package_id < 1) $errors[] = 'Please select a package.';

    if ($errors) {
        $payload = ['status' => 'error', 'message' => implode(' ', $errors)];
    } else {
        $stmt = db()->prepare("INSERT INTO bookings (package_id, name, email, phone, travel_date, people, message, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())");
        $stmt->bind_param('issssis', $package_id, $name, $email, $phone, $travel_date, $people, $message);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $payload = ['status' => 'success', 'message' => 'Booking submitted successfully. Our team will contact you soon.'];
        } else {
            $payload = ['status' => 'error', 'message' => 'Booking failed. Please try again.'];
        }
    }

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) || (isset($_POST['ajax']) && $_POST['ajax'] == '1')) {
        header('Content-Type: application/json');
        echo json_encode($payload);
        exit;
    }

    flash_set($payload['status'] === 'success' ? 'success' : 'danger', $payload['message']);
    header('Location: booking.php');
    exit;
}

$page_title = 'Booking';
require_once __DIR__ . '/includes/header.php';

$packages = fetch_all("SELECT id, title, destination FROM packages ORDER BY created_at DESC");
$selected = (int)($_GET['package_id'] ?? 0);
?>
<section class="section-pad">
    <div class="container">
        <div class="row align-items-stretch g-4">
            <div class="col-lg-5 reveal">
                <div class="booking-card p-4 p-lg-5 h-100">
                    <span class="hero-badge mb-3">Book your trip</span>
                    <h1 class="section-title mb-3">Reserve your luxury journey.</h1>
                    <p class="text-muted">Fill the booking form and our team will confirm the schedule quickly.</p>

                    <div class="mt-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="feature-icon"><i class="fa-solid fa-headset"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Dedicated support</h6>
                                <p class="text-muted mb-0">Quick response and friendly assistance.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="feature-icon"><i class="fa-solid fa-credit-card"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Flexible booking</h6>
                                <p class="text-muted mb-0">Easy reservation flow for modern travelers.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <div class="feature-icon"><i class="fa-solid fa-shield-heart"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Trusted experience</h6>
                                <p class="text-muted mb-0">Secure, clean, and professional backend flow.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 reveal">
                <div class="booking-card p-4 p-lg-5">
                    <h3 class="fw-bold mb-4">Booking form</h3>
                    <div id="bookingMessage" class="alert d-none"></div>
                    <form id="bookingForm" method="post" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Travel Date</label>
                                <input type="date" name="travel_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Package</label>
                                <select name="package_id" class="form-select" required>
                                    <option value="">Choose a package</option>
                                    <?php foreach ($packages as $pkg): ?>
                                        <option value="<?php echo (int)$pkg['id']; ?>" <?php echo $selected === (int)$pkg['id'] ? 'selected' : ''; ?>>
                                            <?php echo e($pkg['title'] . ' - ' . $pkg['destination']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Travelers</label>
                                <input type="number" min="1" name="people" class="form-control" value="2" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message</label>
                                <textarea name="message" rows="5" class="form-control" placeholder="Tell us about your travel style or special requests..."></textarea>
                            </div>
                            <div class="col-12 d-grid">
                                <button type="submit" class="btn btn-arc btn-lg">Submit Booking</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>

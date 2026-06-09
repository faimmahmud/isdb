<?php
$pageTitle = 'Booking | Tourism Arc';
require_once 'includes/db.php';

$message = '';
$alertClass = 'alert-success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $package = trim($_POST['package'] ?? '');
    $travel_date = trim($_POST['travel_date'] ?? '');
    $guests = (int)($_POST['guests'] ?? 1);
    $note = trim($_POST['note'] ?? '');

    if ($name === '' || $email === '' || $package === '' || $travel_date === '') {
        $message = 'Please fill in all required fields.';
        $alertClass = 'alert-danger';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        $alertClass = 'alert-danger';
    } else {
        $conn = tourism_db_connect();
        if ($conn) {
            $stmt = $conn->prepare("INSERT INTO bookings (name, email, package, travel_date, guests, note, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            if ($stmt) {
                $stmt->bind_param('ssssis', $name, $email, $package, $travel_date, $guests, $note);
                $stmt->execute();
                $stmt->close();
                $message = 'Booking submitted successfully. We will contact you soon.';
            } else {
                $message = 'Booking could not be saved right now, but your data looks valid.';
                $alertClass = 'alert-warning';
            }
            $conn->close();
        } else {
            $message = 'Database connection not available, but form validation passed.';
            $alertClass = 'alert-warning';
        }
    }
}

require_once 'includes/header.php';
?>

<section class="page-hero page-hero-booking">
    <div class="container">
        <span class="eyebrow">Booking</span>
        <h1 class="display-5 fw-bold mt-3">Reserve your trip in a premium form layout</h1>
        <p class="text-muted col-lg-7">This form is ready for PHP processing, validation, and database saving.</p>
    </div>
</section>

<section class="section-pad pt-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <?php if ($message !== ''): ?>
                    <div class="alert <?= htmlspecialchars($alertClass) ?>"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form class="glass-form" method="post" id="bookingForm" novalidate>
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
                            <label class="form-label">Package Name</label>
                            <input type="text" name="package" class="form-control" required placeholder="Cox’s Bazar Coastal Escape">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Travel Date</label>
                            <input type="date" name="travel_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Guests</label>
                            <input type="number" name="guests" class="form-control" min="1" value="1" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Special Note</label>
                            <textarea name="note" rows="5" class="form-control" placeholder="Tell us about hotel preferences, meal choices, or anything special."></textarea>
                        </div>
                        <div class="col-12 d-flex flex-wrap gap-3 align-items-center">
                            <button class="btn btn-glow btn-lg px-4" type="submit">Submit Booking</button>
                            <span class="text-muted small">Demo form with PHP + MySQL structure.</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="info-panel reveal">
                    <h3 class="h4 mb-3">What this page includes</h3>
                    <ul class="clean-list">
                        <li>Beautiful form layout</li>
                        <li>Basic validation with jQuery</li>
                        <li>PHP processing and database insert</li>
                        <li>Ready for real booking workflow</li>
                    </ul>
                </div>
                <div class="info-panel reveal mt-4">
                    <h3 class="h4 mb-3">Suggested next steps</h3>
                    <p class="text-muted mb-0">Connect this form to email, add payment, and show booking history in admin dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

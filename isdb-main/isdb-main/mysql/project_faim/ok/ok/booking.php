<?php
$pageTitle = 'Booking';
$bodyClass = 'booking-page';
require_once __DIR__ . '/includes/header.php';

$packages = get_packages();
$selectedPackage = (int) ($_GET['package'] ?? 0);
?>

<section class="booking-hero panel-full parallax-media">
    <img src="assets/images/destinations/santorini.webp" alt="Luxury travel booking view" loading="eager">
    <div class="panel-shade"></div>
    <div class="container">
        <div class="booking-layout">
            <div class="booking-copy reveal">
                <p class="eyebrow">Concierge booking</p>
                <h1 class="display-heading">Begin with a date. We handle the choreography.</h1>
                <p class="hero-copy">Send your preferred journey, group size, and travel window. Royal Atlas will shape the route around your taste.</p>
            </div>
            <form class="booking-form glass-panel reveal" id="bookingForm">
                <div class="form-status" id="bookingStatus" aria-live="polite"></div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name">Full name</label>
                        <input id="name" name="name" type="text" required minlength="2">
                    </div>
                    <div class="col-md-6">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone">Phone</label>
                        <input id="phone" name="phone" type="tel" required minlength="6">
                    </div>
                    <div class="col-md-6">
                        <label for="travel_date">Travel date</label>
                        <input id="travel_date" name="travel_date" type="date" required>
                    </div>
                    <div class="col-md-8">
                        <label for="package_id">Package</label>
                        <select id="package_id" name="package_id" required>
                            <option value="">Choose a package</option>
                            <?php foreach ($packages as $package): ?>
                                <option value="<?= (int) $package['id'] ?>" <?= $selectedPackage === (int) $package['id'] ? 'selected' : '' ?>>
                                    <?= e($package['title']) ?> · $<?= number_format((float) $package['price']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="guests">Guests</label>
                        <input id="guests" name="guests" type="number" min="1" max="30" value="2" required>
                    </div>
                    <div class="col-12">
                        <label for="notes">Travel notes</label>
                        <textarea id="notes" name="notes" rows="4" placeholder="Private transfers, dietary needs, hotel style, special occasion..."></textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-arc btn-lg magnetic w-100" type="submit">
                            <i data-lucide="calendar-check"></i>
                            Request Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

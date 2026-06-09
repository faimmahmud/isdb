<?php $root = app_root(); ?>
</main>

<footer class="footer-luxury">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-5">
                <div class="brand-mark footer-brand">
                    <span class="brand-sigil">RA</span>
                    <span>Royal Atlas</span>
                </div>
                <p class="footer-copy">Cinematic journeys, private access, and polished travel design for clients who want the world to feel personal.</p>
            </div>
            <div class="col-6 col-lg-2">
                <h2 class="footer-title">Explore</h2>
                <a href="<?= $root ?>destinations.php">Destinations</a>
                <a href="<?= $root ?>packages.php">Packages</a>
                <a href="<?= $root ?>world.php">World Atlas</a>
            </div>
            <div class="col-6 col-lg-2">
                <h2 class="footer-title">Company</h2>
                <a href="<?= $root ?>booking.php">Booking</a>
                <a href="<?= $root ?>login.php">Client Login</a>
                <a href="<?= $root ?>register.php">Register</a>
            </div>
            <div class="col-lg-3">
                <h2 class="footer-title">Concierge</h2>
                <p class="footer-copy small">Dhaka, Dubai, London<br>hello@royalatlas.example</p>
                <div class="footer-icons">
                    <i data-lucide="instagram"></i>
                    <i data-lucide="youtube"></i>
                    <i data-lucide="linkedin"></i>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© <?= date('Y') ?> Royal Atlas.</span>
            <span>Luxury tourism demo project.</span>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script src="<?= $root ?>script.js"></script>
</body>
</html>

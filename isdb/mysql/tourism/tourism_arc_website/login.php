<?php
$pageTitle = 'Login | Tourism Arc';
require_once 'includes/header.php';
?>

<section class="page-hero page-hero-auth">
    <div class="container">
        <span class="eyebrow">Account</span>
        <h1 class="display-5 fw-bold mt-3">Login page starter</h1>
        <p class="text-muted col-lg-7">Use this page as the base for PHP session login later.</p>
    </div>
</section>

<section class="section-pad pt-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <form class="glass-form">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Password">
                    </div>
                    <button class="btn btn-glow w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<?php
$pageTitle = 'Register | Tourism Arc';
require_once 'includes/header.php';
?>

<section class="page-hero page-hero-auth">
    <div class="container">
        <span class="eyebrow">Account</span>
        <h1 class="display-5 fw-bold mt-3">Register page starter</h1>
        <p class="text-muted col-lg-7">Use this page to build your user registration system.</p>
    </div>
</section>

<section class="section-pad pt-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form class="glass-form">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" placeholder="Your name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" placeholder="+880">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="name@example.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" placeholder="Create password">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-glow w-100">Create Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

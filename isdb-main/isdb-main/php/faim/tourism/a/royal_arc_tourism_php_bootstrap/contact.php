<?php
$pageTitle = "Contact — Royal Arc Tourism";
$pageClass = "page-contact";
include "includes/header.php";
?>
<div class="container container-wide">
  <section class="page-hero reveal">
    <div class="page-card">
      <span class="eyebrow">Contact channel</span>
      <h1 class="mt-3">Speak to the royal travel team.</h1>
      <p class="lead mt-3 mb-0">A calm functional page for booking requests, support, and premium inquiry handling.</p>
    </div>
  </section>

  <section class="section-block reveal">
    <div class="row g-4">
      <div class="col-lg-7">
        <div class="feature-card h-100">
          <h3>Send an inquiry</h3>
          <form class="row g-3 mt-2">
            <div class="col-md-6">
              <label class="form-label text-white-50">Full name</label>
              <input type="text" class="form-control" placeholder="Your name">
            </div>
            <div class="col-md-6">
              <label class="form-label text-white-50">Email</label>
              <input type="email" class="form-control" placeholder="name@example.com">
            </div>
            <div class="col-md-6">
              <label class="form-label text-white-50">Package</label>
              <select class="form-select">
                <option>Royal Signature</option>
                <option>Grand Weekend</option>
                <option>Palace Privilege</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label text-white-50">Travel date</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label text-white-50">Message</label>
              <textarea class="form-control" rows="6" placeholder="Write your travel needs..."></textarea>
            </div>
            <div class="col-12 d-flex gap-2 flex-wrap">
              <button type="button" class="btn btn-gold">Submit Inquiry</button>
              <a href="packages.php" class="btn btn-outline-light">Browse Packages</a>
            </div>
          </form>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="glass-card h-100 p-4">
          <span class="eyebrow">Royal office</span>
          <h2 class="mt-3">Support details</h2>
          <p class="lead mt-3">
            This area is styled like a premium office wall with a map grid and clear contact information.
          </p>

          <div class="puzzle-grid mt-4">
            <div class="puzzle span-12" style="min-height:220px">
              <h3>Global support</h3>
              <p class="text-muted mt-2">Fast response, luxury itinerary support, and administrative coordination.</p>
              <div class="progress mt-4"><span style="width:86%"></span></div>
            </div>
          </div>

          <div class="mt-4 text-white-50">
            <p><strong class="text-white">Email:</strong> support@royalarc.example</p>
            <p><strong class="text-white">Phone:</strong> +00 123 456 789</p>
            <p><strong class="text-white">Office:</strong> Royal District, Travel Avenue</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include "includes/footer.php"; ?>

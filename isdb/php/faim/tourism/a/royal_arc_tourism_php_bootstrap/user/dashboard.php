<?php
$pageTitle = "User Dashboard — Royal Arc Tourism";
$pageClass = "page-user";
include "../includes/header.php";
?>
<div class="container container-wide">
  <section class="page-hero reveal">
    <div class="page-card">
      <span class="eyebrow">User panel</span>
      <h1 class="mt-3">Your bookings and travel memory.</h1>
      <p class="lead mt-3 mb-0">A clean dashboard for users to track trips, saved routes, and preferences.</p>
    </div>
  </section>

  <section class="section-block reveal">
    <div class="dashboard-grid">
      <div class="kpi span-3"><strong>04</strong><span>Upcoming trips</span></div>
      <div class="kpi span-3"><strong>12</strong><span>Saved places</span></div>
      <div class="kpi span-3"><strong>98%</strong><span>Profile complete</span></div>
      <div class="kpi span-3"><strong>VIP</strong><span>Travel tier</span></div>
    </div>
  </section>

  <section class="section-block reveal">
    <div class="row g-4">
      <div class="col-lg-7">
        <div class="user-box h-100">
          <span class="eyebrow">Next journey</span>
          <h2 class="mt-3">Golden Coast Grand</h2>
          <p class="lead mt-3">Booking progress, stay details, and a calm premium trip overview.</p>
          <div class="progress mt-4"><span style="width:74%"></span></div>
          <p class="text-muted mt-2">Progress: 74%</p>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="user-box h-100">
          <span class="eyebrow">Preferences</span>
          <h2 class="mt-3">Royal comfort settings</h2>
          <ul class="mt-3 text-white-50">
            <li>Luxury stay</li>
            <li>Private guide</li>
            <li>Calm itinerary</li>
            <li>Black / white premium mode</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include "../includes/footer.php"; ?>

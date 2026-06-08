<?php
$pageTitle = "Admin Dashboard — Royal Arc Tourism";
$pageClass = "page-admin";
include "../includes/header.php";
?>
<div class="container container-wide">
  <section class="page-hero reveal">
    <div class="page-card">
      <span class="eyebrow">Admin control</span>
      <h1 class="mt-3">Operate the travel brand with precision.</h1>
      <p class="lead mt-3 mb-0">Administrative dashboard for bookings, users, package management, and performance overview.</p>
    </div>
  </section>

  <section class="section-block reveal">
    <div class="dashboard-grid">
      <div class="kpi span-3"><strong>128</strong><span>New requests</span></div>
      <div class="kpi span-3"><strong>2,560</strong><span>Total users</span></div>
      <div class="kpi span-3"><strong>18</strong><span>Active packages</span></div>
      <div class="kpi span-3"><strong>$48.2k</strong><span>Monthly revenue</span></div>
    </div>
  </section>

  <section class="section-block reveal">
    <div class="row g-4">
      <div class="col-lg-6">
        <div class="admin-box h-100">
          <span class="eyebrow">Performance</span>
          <h2 class="mt-3">Live booking analytics</h2>
          <div class="mt-4">
            <p class="mb-1">Approval rate</p>
            <div class="progress mb-3"><span style="width:92%"></span></div>
            <p class="mb-1">Guest satisfaction</p>
            <div class="progress mb-3"><span style="width:88%"></span></div>
            <p class="mb-1">Package occupancy</p>
            <div class="progress"><span style="width:76%"></span></div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="admin-box h-100">
          <span class="eyebrow">Recent activity</span>
          <h2 class="mt-3">Booking table</h2>
          <div class="table-responsive mt-3">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>Guest</th>
                  <th>Package</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr><td>Elina</td><td>Royal Signature</td><td>Approved</td></tr>
                <tr><td>Ahmed</td><td>Grand Weekend</td><td>Pending</td></tr>
                <tr><td>Sara</td><td>Palace Privilege</td><td>Confirmed</td></tr>
                <tr><td>Rafi</td><td>Golden Coast Grand</td><td>Review</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include "../includes/footer.php"; ?>

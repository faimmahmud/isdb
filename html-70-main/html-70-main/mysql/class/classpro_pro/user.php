<?php
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_user'])) {
    $name = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $contact_no = trim($_POST['contact_no'] ?? '');

    if ($name === '' || $address === '' || $contact_no === '') {
        flash_set('error', 'Please fill in all user fields.');
        header("Location: user.php");
        exit;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO `user` (name, address, contact_no) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $name, $address, $contact_no);

    if (mysqli_stmt_execute($stmt)) {
        flash_set('success', 'User saved successfully.');
    } else {
        flash_set('error', 'User save failed: ' . mysqli_error($conn));
    }

    mysqli_stmt_close($stmt);
    header("Location: user.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $id = (int)($_POST['user_id'] ?? 0);

    if ($id > 0) {
        $stmt = mysqli_prepare($conn, "DELETE FROM `user` WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            flash_set('info', 'User removed from the system.');
        } else {
            flash_set('error', 'User delete failed.');
        }

        mysqli_stmt_close($stmt);
    }

    header("Location: user.php");
    exit;
}

$page_title = "ClassPro Pro — Users";
$page_body_class = "users-page";
$page_css = [
    "assets/css/base.css",
    "assets/css/user.css"
];
$active_page = "users";

$users = [];
$res = mysqli_query($conn, "SELECT id, name, address, contact_no FROM `user` ORDER BY id DESC");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $users[] = $row;
    }
}

include "partials/header.php";
?>

<section class="user-layout">
    <div class="user-hero">
        <span class="kicker">User Control Center</span>
        <h1>Elegant user management with a separate visual identity.</h1>
        <p>
            This page uses a brighter, cleaner design so the form and table feel focused and easy to use.
            It is built to look distinct from the dashboard and product pages while staying part of the same system.
        </p>

        <div class="feature-list">
            <div class="feature">
                <div class="badge badge-green">01</div>
                <div>
                    <strong>Fast data entry</strong>
                    <span>Structured input fields help keep user records clean and consistent.</span>
                </div>
            </div>
            <div class="feature">
                <div class="badge badge-accent">02</div>
                <div>
                    <strong>Clear records</strong>
                    <span>All users are listed below with quick access to delete actions.</span>
                </div>
            </div>
            <div class="feature">
                <div class="badge badge-orange">03</div>
                <div>
                    <strong>Professional spacing</strong>
                    <span>Panels, shadows, and typography are designed for a premium look.</span>
                </div>
            </div>
        </div>
    </div>

    <div class="surface-card form-card">
        <h2 class="section-title">Add new user</h2>
        <p class="section-subtitle">Store name, address, and contact number into the <code>user</code> table.</p>

        <form method="POST" class="grid" style="margin-top:18px">
            <div class="form-grid">
                <div class="full">
                    <label class="label">Full Name</label>
                    <input class="input" type="text" name="name" placeholder="Enter user name" required>
                </div>
                <div class="full">
                    <label class="label">Address</label>
                    <input class="input" type="text" name="address" placeholder="Enter address" required>
                </div>
                <div class="full">
                    <label class="label">Contact Number</label>
                    <input class="input" type="text" name="contact_no" placeholder="Enter contact number" required>
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit" name="save_user">Save User</button>
                <a class="btn btn-ghost" href="index.php">Back to Dashboard</a>
            </div>
        </form>
    </div>
</section>

<section class="surface-card table-card" style="margin-top:22px">
    <h2 class="section-title">All users</h2>
    <p class="section-subtitle">Recent records are displayed in a clean table with quick deletion support.</p>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($users): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo h($user['id']); ?></td>
                            <td>
                                <strong><?php echo h($user['name']); ?></strong>
                                <div class="mini">User profile entry</div>
                            </td>
                            <td><?php echo h($user['address']); ?></td>
                            <td><?php echo h($user['contact_no']); ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Delete this user?');">
                                    <input type="hidden" name="user_id" value="<?php echo h($user['id']); ?>">
                                    <button class="btn btn-danger" type="submit" name="delete_user">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="muted">No users found yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include "partials/footer.php"; ?>

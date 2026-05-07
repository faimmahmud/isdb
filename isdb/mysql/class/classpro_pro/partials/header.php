<?php
if (!isset($page_title)) {
    $page_title = "ClassPro Pro";
}
if (!isset($page_body_class)) {
    $page_body_class = "page-default";
}
if (!isset($page_css)) {
    $page_css = [];
}
if (!isset($active_page)) {
    $active_page = "";
}
$flash = flash_get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($page_title); ?></title>
    <?php foreach ($page_css as $css): ?>
        <link rel="stylesheet" href="<?php echo h($css); ?>">
    <?php endforeach; ?>
</head>
<body class="<?php echo h($page_body_class); ?>">
<header class="topbar">
    <div class="brand-wrap">
        <div class="brand-mark">CP</div>
        <div>
            <div class="brand-title">ClassPro Pro</div>
            <div class="brand-subtitle">OpenAI x World AI concept interface</div>
        </div>
    </div>

    <nav class="nav-links" aria-label="Main navigation">
        <a class="<?php echo $active_page === 'dashboard' ? 'active' : ''; ?>" href="index.php">Dashboard</a>
        <a class="<?php echo $active_page === 'users' ? 'active' : ''; ?>" href="user.php">Users</a>
        <a class="<?php echo $active_page === 'products' ? 'active' : ''; ?>" href="product.php">Products</a>
    </nav>
</header>

<main class="app-shell">

<?php if ($flash): ?>
    <div class="flash flash-<?php echo h($flash['type']); ?>">
        <?php echo h($flash['message']); ?>
    </div>
<?php endif; ?>

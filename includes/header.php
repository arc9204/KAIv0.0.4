<?php
/*
 * header.php
 * Included at the top of every page.
 * Before including this, set:
 *   $pageTitle  - text sa browser tab
 *   $pageCss    - (optional) page specific css file, ex: 'home.css'
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/icons.php';

// which page are we on? used to make the nav link bold
$currentPage = basename($_SERVER['PHP_SELF']);

if (!isset($pageTitle)) {
    $pageTitle = 'Home';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="KAI Aluminum & Glass Supply - premium aluminum and glass solutions in Dinalupihan, Bataan.">
    <title><?= e($pageTitle) ?> | <?= e(SITE_NAME) ?></title>

    <link rel="icon" type="image/svg+xml" href="assets/images/icons/logo.svg">

    <!-- fonts from figma: Manrope, Inter, Cormorant Garamond, Actor -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Actor&family=Cormorant+Garamond:ital,wght@1,400;1,500&family=Inter:wght@300;400;500;600;700&family=Manrope:wght@400;500;600;700&family=Metal&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
    <?php if (!empty($pageCss)): ?>
        <link rel="stylesheet" href="<?= e(asset('css/' . $pageCss)) ?>">
    <?php endif; ?>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="navbar" id="navbar">
    <a href="index.php" class="nav-logo">
        <img src="assets/images/icons/logo.svg" alt="KAI logo" width="37" height="39">
        <span>KAI</span>
    </a>

    <nav class="nav-links" id="navLinks">
        <?php foreach (NAV_LINKS as $file => $label): ?>
            <a href="<?= $file ?>" class="<?= $currentPage === $file ? 'active' : '' ?>"><?= e($label) ?></a>
        <?php endforeach; ?>
        <!-- only shows inside the mobile menu -->
        <a href="booking.php" class="mobile-only">Booking</a>
    </nav>

    <div class="nav-right">
        <a href="booking.php" class="btn-booking <?= $currentPage === 'booking.php' ? 'active' : '' ?>">Booking</a>
    </div>

    <button class="nav-toggle" id="navToggle" aria-label="Open menu">
        <?= icon('menu') ?>
    </button>
</header>

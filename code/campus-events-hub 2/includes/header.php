<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Campus Events Hub';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Campus Events Hub for university activities and student registration">
    <title><?php echo e($pageTitle); ?> | Campus Events Hub</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="index.php" aria-label="Campus Events Hub home">
            <span class="brand-mark">CE</span>
            <span>
                <strong>Campus Events Hub</strong>
                <small>Connect. Learn. Participate.</small>
            </span>
        </a>

        <nav class="main-nav" aria-label="Main navigation">
            <a class="<?php echo active_page('index.php'); ?>" href="index.php">Home</a>
            <a class="<?php echo active_page('events.php') || active_page('event.php') ? 'active' : ''; ?>" href="events.php">Events</a>
            <a class="<?php echo active_page('register.php'); ?>" href="register.php">Register</a>
            <a class="<?php echo active_page('registrations.php'); ?>" href="registrations.php">Registrations</a>
            <a class="<?php echo active_page('about.php'); ?>" href="about.php">About &amp; Contact</a>
        </nav>
    </div>
</header>

<main>

<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$pageTitle = 'Event Details';
$event = null;
$errorMessage = '';

$eventId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$eventId || $eventId < 1) {
    $errorMessage = 'The event ID is missing or invalid.';
} else {
    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, title, category, event_date, event_time, location,
                short_description, full_description, image,
                available_seats, organizer
         FROM events
         WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, 'i', $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $event = mysqli_fetch_assoc($result);

    if (!$event) {
        $errorMessage = 'The selected event could not be found.';
    }

    mysqli_stmt_close($stmt);
}

require 'includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <span class="eyebrow">Event information</span>
        <h1>Event Details</h1>
        <p>Review the activity information before submitting your registration.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if ($errorMessage): ?>
            <div class="alert alert-error">
                <h2>Unable to open this event</h2>
                <p><?php echo e($errorMessage); ?></p>
                <a class="button button-primary" href="events.php">Return to Events</a>
            </div>
        <?php else: ?>
            <article class="detail-layout">
                <div class="detail-image">
                    <img src="assets/images/<?php echo e($event['image']); ?>"
                         alt="<?php echo e($event['title']); ?>">
                </div>

                <div class="detail-content">
                    <span class="category-badge static-badge"><?php echo e($event['category']); ?></span>
                    <h2><?php echo e($event['title']); ?></h2>
                    <p class="lead"><?php echo e($event['short_description']); ?></p>

                    <dl class="detail-list">
                        <div>
                            <dt>Date</dt>
                            <dd><?php echo e(format_event_date($event['event_date'])); ?></dd>
                        </div>
                        <div>
                            <dt>Time</dt>
                            <dd><?php echo e(format_event_time($event['event_time'])); ?></dd>
                        </div>
                        <div>
                            <dt>Location</dt>
                            <dd><?php echo e($event['location']); ?></dd>
                        </div>
                        <div>
                            <dt>Available seats</dt>
                            <dd><?php echo (int) $event['available_seats']; ?></dd>
                        </div>
                        <div>
                            <dt>Organizer</dt>
                            <dd><?php echo e($event['organizer']); ?></dd>
                        </div>
                    </dl>

                    <div class="detail-description">
                        <h3>About this event</h3>
                        <p><?php echo nl2br(e($event['full_description'])); ?></p>
                    </div>

                    <div class="detail-actions">
                        <a class="button button-primary"
                           href="register.php?event_id=<?php echo (int) $event['id']; ?>">
                            Register for this event
                        </a>
                        <a class="button button-outline" href="events.php">Back to Events</a>
                    </div>
                </div>
            </article>
        <?php endif; ?>
    </div>
</section>

<?php require 'includes/footer.php'; ?>

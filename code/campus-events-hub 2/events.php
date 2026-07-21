<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$pageTitle = 'Events';

$sql = "SELECT id, title, category, event_date, event_time, location,
               short_description, image
        FROM events
        ORDER BY event_date ASC, event_time ASC";

$result = mysqli_query($conn, $sql);

require 'includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <span class="eyebrow">Campus calendar</span>
        <h1>Upcoming Events</h1>
        <p>Browse activities planned for students across different Saudi university campuses.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card-grid">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($event = mysqli_fetch_assoc($result)): ?>
                    <article class="event-card">
                        <div class="event-image">
                            <img src="assets/images/<?php echo e($event['image']); ?>"
                                 alt="<?php echo e($event['title']); ?>">
                            <span class="category-badge"><?php echo e($event['category']); ?></span>
                        </div>

                        <div class="event-body">
                            <h2><?php echo e($event['title']); ?></h2>
                            <ul class="event-meta">
                                <li><?php echo e(format_event_date($event['event_date'])); ?></li>
                                <li><?php echo e(format_event_time($event['event_time'])); ?></li>
                                <li><?php echo e($event['location']); ?></li>
                            </ul>
                            <p><?php echo e($event['short_description']); ?></p>
                            <a class="card-link" href="event.php?id=<?php echo (int) $event['id']; ?>">
                                View Details
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <h2>No events are available</h2>
                    <p>Please return later to check the updated campus schedule.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>

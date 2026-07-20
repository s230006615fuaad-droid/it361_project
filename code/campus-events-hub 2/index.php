<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$pageTitle = 'Home';

$sql = "SELECT id, title, category, event_date, event_time, location,
               short_description, image
        FROM events
        WHERE event_date >= CURDATE()
        ORDER BY event_date ASC, event_time ASC
        LIMIT 3";

$result = mysqli_query($conn, $sql);

require 'includes/header.php';
?>

<section class="hero">
    <div class="container hero-grid">
        <div class="hero-content">
            <span class="eyebrow">University life beyond the classroom</span>
            <h1>Find events that make your campus experience more meaningful.</h1>
            <p>
                Explore workshops, seminars, competitions, cultural activities,
                sports events, and student trips taking place across our campuses.
            </p>
            <div class="hero-actions">
                <a class="button button-primary" href="events.php">Explore Events</a>
                <a class="button button-light" href="register.php">Register Now</a>
            </div>
        </div>

        <aside class="hero-panel" aria-label="Website highlights">
            <div class="stat-card">
                <strong>8+</strong>
                <span>Upcoming activities</span>
            </div>
            <div class="stat-card">
                <strong>6</strong>
                <span>Event categories</span>
            </div>
            <div class="stat-card">
                <strong>4</strong>
                <span>Student team members</span>
            </div>
        </aside>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Coming soon</span>
                <h2>Next campus events</h2>
            </div>
            <a class="text-link" href="events.php">View all events</a>
        </div>

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
                            <h3><?php echo e($event['title']); ?></h3>
                            <ul class="event-meta">
                                <li><?php echo e(format_event_date($event['event_date'])); ?></li>
                                <li><?php echo e(format_event_time($event['event_time'])); ?></li>
                                <li><?php echo e($event['location']); ?></li>
                            </ul>
                            <p><?php echo e($event['short_description']); ?></p>
                            <a class="card-link" href="event.php?id=<?php echo (int) $event['id']; ?>">
                                View event details
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <h3>No upcoming events</h3>
                    <p>New activities will be added soon.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section section-soft">
    <div class="container split-section">
        <div>
            <span class="eyebrow">About the hub</span>
            <h2>A simple way to stay involved</h2>
            <p>
                Campus Events Hub brings university activities into one clear place.
                Students can compare upcoming events, read full details, and submit
                their registration online.
            </p>
        </div>

        <div class="feature-list">
            <article>
                <span>01</span>
                <div>
                    <h3>Discover useful activities</h3>
                    <p>Find academic, cultural, professional, and social opportunities.</p>
                </div>
            </article>

            <article>
                <span>02</span>
                <div>
                    <h3>Register in a few steps</h3>
                    <p>Choose an event and complete one clear student registration form.</p>
                </div>
            </article>

            <article>
                <span>03</span>
                <div>
                    <h3>Build campus connections</h3>
                    <p>Meet students with shared interests and learn outside class.</p>
                </div>
            </article>
        </div>
    </div>
</section>
<?php require 'includes/footer.php'; ?>

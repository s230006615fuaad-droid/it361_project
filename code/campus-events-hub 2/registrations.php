<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$pageTitle = 'Registrations';

$sql = "SELECT r.id, r.full_name, r.student_id, r.email, r.phone,
               r.registered_at, e.title AS event_title
        FROM registrations r
        INNER JOIN events e ON r.event_id = e.id
        ORDER BY r.registered_at DESC";

$result = mysqli_query($conn, $sql);

require 'includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <span class="eyebrow">Stored records</span>
        <h1>Event Registrations</h1>
        <p>This page displays student registrations saved in the database.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <div class="table-wrap">
                <table>
                    <caption>Students registered for campus events</caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student name</th>
                            <th>Student ID</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Event</th>
                            <th>Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($registration = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td data-label="ID"><?php echo (int) $registration['id']; ?></td>
                                <td data-label="Student name"><?php echo e($registration['full_name']); ?></td>
                                <td data-label="Student ID"><?php echo e($registration['student_id']); ?></td>
                                <td data-label="Email"><?php echo e($registration['email']); ?></td>
                                <td data-label="Phone"><?php echo e($registration['phone']); ?></td>
                                <td data-label="Event"><?php echo e($registration['event_title']); ?></td>
                                <td data-label="Registered">
                                    <?php echo e(date('d M Y, g:i A', strtotime($registration['registered_at']))); ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h2>No registrations have been submitted</h2>
                <p>Student records will appear here after the first valid registration.</p>
                <a class="button button-primary" href="register.php">Open Registration Form</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require 'includes/footer.php'; ?>

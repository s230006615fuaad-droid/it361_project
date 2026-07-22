<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$pageTitle = 'Register';

$errors = [];
$successMessage = '';

$fullName = '';
$studentId = '';
$email = '';
$phone = '';
$selectedEvent = '';
$notes = '';
$agreement = '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $urlEventId = filter_input(INPUT_GET, 'event_id', FILTER_VALIDATE_INT);
    if ($urlEventId && $urlEventId > 0) {
        $selectedEvent = (string) $urlEventId;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $studentId = trim($_POST['student_id'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $selectedEvent = trim($_POST['event_id'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    $agreement = $_POST['agreement'] ?? '';

    if ($fullName === '') {
        $errors['full_name'] = 'Please enter your full name.';
    } elseif (strlen($fullName) < 4) {
        $errors['full_name'] = 'The full name must contain at least 4 characters.';
    }

    if ($studentId === '') {
        $errors['student_id'] = 'Please enter your student ID.';
    } elseif (!preg_match('/^S?\d{9}$/i', $studentId)) {
        $errors['student_id'] = 'Use 9 digits, with an optional S at the beginning.';
    }

    if ($email === '') {
        $errors['email'] = 'Please enter your email address.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if ($phone === '') {
        $errors['phone'] = 'Please enter your mobile number.';
    } elseif (!preg_match('/^05\d{8}$/', $phone)) {
        $errors['phone'] = 'Use a Saudi mobile number in the format 05XXXXXXXX.';
    }

    if (!ctype_digit($selectedEvent) || (int) $selectedEvent < 1) {
        $errors['event_id'] = 'Please select a valid event.';
    } else {
        $eventCheck = mysqli_prepare($conn, "SELECT id FROM events WHERE id = ?");
        $eventNumber = (int) $selectedEvent;
        mysqli_stmt_bind_param($eventCheck, 'i', $eventNumber);
        mysqli_stmt_execute($eventCheck);
        $eventResult = mysqli_stmt_get_result($eventCheck);

        if (mysqli_num_rows($eventResult) !== 1) {
            $errors['event_id'] = 'The selected event does not exist.';
        }

        mysqli_stmt_close($eventCheck);
    }

    if (strlen($notes) > 500) {
        $errors['notes'] = 'Notes must not exceed 500 characters.';
    }

    if ($agreement !== 'yes') {
        $errors['agreement'] = 'You must confirm that the information is correct.';
    }

    if (!$errors) {
        $eventNumber = (int) $selectedEvent;

        $duplicateStmt = mysqli_prepare(
            $conn,
            "SELECT id FROM registrations WHERE event_id = ? AND student_id = ?"
        );
        mysqli_stmt_bind_param($duplicateStmt, 'is', $eventNumber, $studentId);
        mysqli_stmt_execute($duplicateStmt);
        $duplicateResult = mysqli_stmt_get_result($duplicateStmt);

        if (mysqli_num_rows($duplicateResult) > 0) {
            $errors['general'] = 'This student ID is already registered for the selected event.';
        }

        mysqli_stmt_close($duplicateStmt);
    }

    if (!$errors) {
        $insertStmt = mysqli_prepare(
            $conn,
            "INSERT INTO registrations
             (event_id, full_name, student_id, email, phone, notes)
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $insertStmt,
            'isssss',
            $eventNumber,
            $fullName,
            $studentId,
            $email,
            $phone,
            $notes
        );

        if (mysqli_stmt_execute($insertStmt)) {
            $successMessage = 'Your registration was submitted successfully.';
            $fullName = '';
            $studentId = '';
            $email = '';
            $phone = '';
            $selectedEvent = '';
            $notes = '';
            $agreement = '';
        } else {
            $errors['general'] = 'The registration could not be saved. Please try again.';
        }

        mysqli_stmt_close($insertStmt);
    }
}

$eventsResult = mysqli_query(
    $conn,
    "SELECT id, title, event_date
     FROM events
     WHERE event_date >= CURDATE()
     ORDER BY event_date ASC"
);

require 'includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <span class="eyebrow">Student registration</span>
        <h1>Register for an Event</h1>
        <p>Complete the form below using accurate university and contact information.</p>
    </div>
</section>

<section class="section">
    <div class="container form-layout">
        <aside class="form-intro">
            <span class="eyebrow">Before you submit</span>
            <h2>Join a campus activity</h2>
            <p>
                Choose one event and make sure your student ID, university email,
                and mobile number are entered correctly.
            </p>
            <ul class="check-list">
                <li>One registration per student for each event</li>
                <li>Required fields are checked on the server</li>
                <li>Your selected event must exist in the database</li>
            </ul>
        </aside>

        <div class="form-card">
            <?php if ($successMessage): ?>
                <div class="alert alert-success">
                    <strong>Registration complete</strong>
                    <p><?php echo e($successMessage); ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($errors['general'])): ?>
                <div class="alert alert-error">
                    <strong>Registration not completed</strong>
                    <p><?php echo e($errors['general']); ?></p>
                </div>
            <?php endif; ?>

            <form method="post" action="register.php" novalidate>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="full_name">Full name</label>
                        <input type="text" id="full_name" name="full_name"
                               value="<?php echo e($fullName); ?>"
                               autocomplete="name" required>
                        <?php if (isset($errors['full_name'])): ?>
                            <small class="field-error"><?php echo e($errors['full_name']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="student_id">Student ID</label>
                        <input type="text" id="student_id" name="student_id"
                               value="<?php echo e($studentId); ?>"
                               placeholder="S240123456" required>
                        <?php if (isset($errors['student_id'])): ?>
                            <small class="field-error"><?php echo e($errors['student_id']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="phone">Saudi mobile number</label>
                        <input type="tel" id="phone" name="phone"
                               value="<?php echo e($phone); ?>"
                               placeholder="05XXXXXXXX" required>
                        <?php if (isset($errors['phone'])): ?>
                            <small class="field-error"><?php echo e($errors['phone']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group full-width">
                        <label for="email">University email</label>
                        <input type="email" id="email" name="email"
                               value="<?php echo e($email); ?>"
                               placeholder="student@university.edu.sa"
                               autocomplete="email" required>
                        <?php if (isset($errors['email'])): ?>
                            <small class="field-error"><?php echo e($errors['email']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group full-width">
                        <label for="event_id">Select event</label>
                        <select id="event_id" name="event_id" required>
                            <option value="">Choose an upcoming event</option>
                            <?php if ($eventsResult): ?>
                                <?php while ($eventOption = mysqli_fetch_assoc($eventsResult)): ?>
                                    <option value="<?php echo (int) $eventOption['id']; ?>"
                                        <?php echo (string) $eventOption['id'] === (string) $selectedEvent ? 'selected' : ''; ?>>
                                        <?php echo e($eventOption['title']); ?>
                                        - <?php echo e(format_event_date($eventOption['event_date'])); ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                        <?php if (isset($errors['event_id'])): ?>
                            <small class="field-error"><?php echo e($errors['event_id']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group full-width">
                        <label for="notes">Notes <span class="optional">(optional)</span></label>
                        <textarea id="notes" name="notes" rows="4"
                                  maxlength="500"><?php echo e($notes); ?></textarea>
                        <?php if (isset($errors['notes'])): ?>
                            <small class="field-error"><?php echo e($errors['notes']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group full-width checkbox-group">
                        <label>
                            <input type="checkbox" name="agreement" value="yes"
                                <?php echo $agreement === 'yes' ? 'checked' : ''; ?>>
                            I confirm that the information provided is correct.
                        </label>
                        <?php if (isset($errors['agreement'])): ?>
                            <small class="field-error"><?php echo e($errors['agreement']); ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <button class="button button-primary button-full" type="submit">
                    Submit Registration
                </button>
            </form>
        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>

<?php
require_once 'includes/functions.php';

$pageTitle = 'About and Contact';

$errors = [];
$successMessage = '';

$name = '';
$email = '';
$subject = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') {
        $errors['name'] = 'Please enter your name.';
    } elseif (strlen($name) < 3) {
        $errors['name'] = 'The name must contain at least 3 characters.';
    }

    if ($email === '') {
        $errors['email'] = 'Please enter your email address.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if ($subject === '') {
        $errors['subject'] = 'Please enter a subject.';
    } elseif (strlen($subject) < 4) {
        $errors['subject'] = 'The subject must contain at least 4 characters.';
    }

    if ($message === '') {
        $errors['message'] = 'Please enter your message.';
    } elseif (strlen($message) < 10) {
        $errors['message'] = 'The message must contain at least 10 characters.';
    }

    if (!$errors) {
        $successMessage = 'Thank you. Your message passed validation successfully.';
        $name = '';
        $email = '';
        $subject = '';
        $message = '';
    }
}

require 'includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <span class="eyebrow">Project and team</span>
        <h1>About Campus Events Hub</h1>
        <p>Learn about the project purpose, student team, and development responsibilities.</p>
    </div>
</section>

<section class="section">
    <div class="container split-section">
        <div>
            <span class="eyebrow">Our background</span>
            <h2>Supporting student participation</h2>
            <p>
                Campus Events Hub is a fictional university service created to make
                campus activities easier to find and join. It brings event information
                and registration into one simple website.
            </p>

            <h3>Mission</h3>
            <p>
                Our mission is to help students discover useful academic, cultural,
                professional, and social opportunities across university campuses.
            </p>

            <h3>Objectives</h3>
            <ul class="check-list">
                <li>Present upcoming events in a clear and consistent format.</li>
                <li>Allow students to register using a validated online form.</li>
                <li>Store and display registrations using a simple database.</li>
                <li>Apply core HTML, CSS, PHP, and MySQL skills in one project.</li>
            </ul>
        </div>

        <aside class="project-card">
            <span class="eyebrow">Project period</span>
            <h2>15 July–9 August 2026</h2>
            <p>
                The work was divided into planning, interface development,
                PHP implementation, database connection, validation, and testing.
            </p>
        </aside>
    </div>
</section>

<section class="section section-soft">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Group members</span>
                <h2>Team contributions</h2>
            </div>
        </div>

        <div class="team-grid">
            <article class="team-card">
                <span>FA</span>
                <h3>Fuaad Ali Alnakhli</h3>
                <p>Developed the home page, shared header, and main navigation.</p>
            </article>

            <article class="team-card">
                <span>AA</span>
                <h3>Abdulah Naif Aldossry</h3>
                <p>Worked on the Events page, event details, and database event records.</p>
            </article>

            <article class="team-card">
                <span>JA</span>
                <h3>JASER ESSA ALJASIR</h3>
                <p>Prepared the registration form, validation rules, and database storage.</p>
            </article>

            <article class="team-card">
                <span>MF</span>
                <h3>Mohammed Fahad Alanazi</h3>
                <p>Completed the About/Contact page, registrations table, testing, and responsive CSS.</p>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container form-layout">
        <aside class="form-intro">
            <span class="eyebrow">Contact form</span>
            <h2>Send a message</h2>
            <p>
                This form demonstrates server-side validation. It does not send
                an email or save the message.
            </p>
        </aside>

        <div class="form-card">
            <?php if ($successMessage): ?>
                <div class="alert alert-success">
                    <strong>Message accepted</strong>
                    <p><?php echo e($successMessage); ?></p>
                </div>
            <?php endif; ?>

            <form method="post" action="about.php#contact" id="contact" novalidate>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name"
                               value="<?php echo e($name); ?>"
                               autocomplete="name" required>
                        <?php if (isset($errors['name'])): ?>
                            <small class="field-error"><?php echo e($errors['name']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="contact_email">Email</label>
                        <input type="email" id="contact_email" name="email"
                               value="<?php echo e($email); ?>"
                               autocomplete="email" required>
                        <?php if (isset($errors['email'])): ?>
                            <small class="field-error"><?php echo e($errors['email']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group full-width">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject"
                               value="<?php echo e($subject); ?>" required>
                        <?php if (isset($errors['subject'])): ?>
                            <small class="field-error"><?php echo e($errors['subject']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group full-width">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="6"
                                  required><?php echo e($message); ?></textarea>
                        <?php if (isset($errors['message'])): ?>
                            <small class="field-error"><?php echo e($errors['message']); ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <button class="button button-primary button-full" type="submit">
                    Validate Message
                </button>
            </form>
        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>

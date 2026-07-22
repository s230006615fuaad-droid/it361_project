# Campus Events Hub

Campus Events Hub is a small dynamic university website for publishing campus activities and allowing students to register online. The project uses simple procedural PHP and MySQL so that the code remains easy to read, explain, and present.

## Project Period

15/07/2026 to 09/08/2026

## Technologies

- HTML5
- CSS3
- Purple-and-gold visual theme
- Procedural PHP
- MySQL
- MySQLi prepared statements
- XAMPP

No frameworks, site builders, external libraries, or content management systems are used.

## Main Pages

- `index.php` — introduction and the next three upcoming events
- `events.php` — complete list of events from the database
- `event.php` — selected event details using a GET parameter
- `register.php` — validated student registration form
- `registrations.php` — stored registrations displayed in a table
- `about.php` — project information, team contributions, and contact form

## Folder Structure

```text
campus-events-hub/
│
├── index.php
├── events.php
├── event.php
├── register.php
├── registrations.php
├── about.php
├── database.sql
├── README.md
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── db.php
│   └── functions.php
│
└── assets/
    ├── css/
    │   └── style.css
    └── images/
        ├── coding-workshop.jpg
        ├── career-seminar.jpg
        ├── innovation-challenge.jpg
        ├── volunteering-day.jpg
        ├── cultural-event.jpg
        ├── sports-tournament.jpg
        ├── cybersecurity-session.jpg
        └── educational-trip.jpg
```

## XAMPP Setup

1. Install and open XAMPP.
2. Start Apache and MySQL.
3. Copy the `campus-events-hub` folder into the XAMPP `htdocs` folder.
4. Open phpMyAdmin at `http://localhost/phpmyadmin/`.
5. Select the **Import** tab.
6. Import the `database.sql` file.
7. Check the database settings in `includes/db.php`.
8. Open the website at:

```text
http://localhost/campus-events-hub/
```

## Default Database Settings

```text
Host: localhost
Username: root
Password: empty
Database: campus_events_hub
```

Change these values in `includes/db.php` if your MySQL installation uses different settings.

## Event Images

The required event images are included in `assets/images`. They are simple project placeholders created for the website. They may be replaced with suitable royalty-free campus images while keeping the same file names.

## Validation

The registration form checks:

- Required fields
- Email format
- Student ID format
- Saudi mobile format
- Valid event selection
- Agreement checkbox
- Duplicate registration for the same event and student ID

The contact form checks all required fields and validates the email address. It does not send an email or save contact messages.

## Team Members and Contributions

- **Fuaad Ali Alnakhli:** home page, shared header, and navigation
- **Abdulah Naif Aldossry:** Events page, event details page, and database event data
- **JASER ESSA ALJASIR:** registration form, validation, and registration storage
- **Mohammed Fahad Alanazi:** About/Contact page, registrations table, testing, and responsive CSS

## Development Timeline

- **Week 1:** Team formation, club theme selection, sitemap, and page sketches.
- **Weeks 2–3:** Static HTML and CSS version of all pages.
- **End of Week 3:** Mid-project progress report.
- **Weeks 4–5:** PHP templates, forms, validation, database storage, and dynamic display.
- **Week 6:** Testing, design polishing, final report, and submission.

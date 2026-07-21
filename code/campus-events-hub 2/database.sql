CREATE DATABASE IF NOT EXISTS campus_event_hub
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE campus_event_hub;

DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS events;

CREATE TABLE events (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(80) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    location VARCHAR(180) NOT NULL,
    short_description VARCHAR(255) NOT NULL,
    full_description TEXT NOT NULL,
    image VARCHAR(120) NOT NULL,
    available_seats INT UNSIGNED NOT NULL DEFAULT 30,
    organizer VARCHAR(150) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE registrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id INT UNSIGNED NOT NULL,
    full_name VARCHAR(120) NOT NULL,
    student_id VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    notes VARCHAR(500) DEFAULT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_registration_event
        FOREIGN KEY (event_id) REFERENCES events(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT unique_student_event
        UNIQUE (event_id, student_id)
) ENGINE=InnoDB;

INSERT INTO events
(title, category, event_date, event_time, location, short_description, full_description, image, available_seats, organizer)
VALUES
(
    'Practical Web Coding Workshop',
    'Technology',
    '2026-08-16',
    '10:00:00',
    'Computer Lab 2, Riyadh Campus',
    'A guided workshop covering the basics of building a responsive web page.',
    'Students will create a small responsive web page using semantic HTML and CSS. The session includes layout practice, form design, and a short review of common coding mistakes. Participants should bring a laptop.',
    'coding-workshop.jpg',
    35,
    'Digital Skills Club'
),
(
    'Career Readiness Seminar',
    'Professional Development',
    '2026-08-20',
    '12:30:00',
    'Main Auditorium, Jeddah Campus',
    'A seminar about CV writing, interviews, and preparing for graduate opportunities.',
    'The seminar introduces practical ways to improve a student CV, prepare for interviews, and present academic projects clearly. A guest speaker from a local recruitment team will answer student questions.',
    'career-seminar.jpg',
    80,
    'Career Support Unit'
),
(
    'Saudi Innovation Challenge',
    'Competition',
    '2026-08-25',
    '09:00:00',
    'Innovation Center, Riyadh Campus',
    'Student teams develop simple ideas that address everyday campus challenges.',
    'Teams will identify a campus problem, propose a practical solution, and present a short prototype or concept. Evaluation will focus on usefulness, clarity, teamwork, and realistic implementation.',
    'innovation-challenge.jpg',
    60,
    'Innovation and Entrepreneurship Club'
);

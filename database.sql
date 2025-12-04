-- Drop database if it already exists
DROP DATABASE IF EXISTS Maw11Looper;

-- Create database
CREATE DATABASE Maw11Looper CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Use the new database
USE Maw11Looper;

-- ==========================================
-- Table: exercises
-- Stores quiz exercises created by teachers
-- ==========================================
CREATE TABLE exercises (
    exercise_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    status ENUM('building', 'answering', 'closed') DEFAULT 'building'
);

-- ==========================================
-- Table: fields
-- Defines questions for each exercise
-- ==========================================
CREATE TABLE fields (
    field_id INT AUTO_INCREMENT PRIMARY KEY,
    exercise_id INT NOT NULL,
    label VARCHAR(255) NOT NULL,
    value_kind ENUM('single_line', 'single_line_list', 'multi_line') DEFAULT 'single_line',
    FOREIGN KEY (exercise_id) REFERENCES exercises(exercise_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- ==========================================
-- Table: fulfillments
-- Represents one student's completion of an exercise
-- ==========================================
CREATE TABLE fulfillments (
    fulfillment_id INT AUTO_INCREMENT PRIMARY KEY,
    exercise_id INT NOT NULL,
    fulfillment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (exercise_id) REFERENCES exercises(exercise_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- ==========================================
-- Table: answers
-- Stores student responses to exercises
-- ==========================================
CREATE TABLE answers (
    answer_id INT AUTO_INCREMENT PRIMARY KEY,
    fulfillment_id INT NOT NULL,
    field_id INT NOT NULL,
    answer_text TEXT,
    FOREIGN KEY (fulfillment_id) REFERENCES fulfillments(fulfillment_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (field_id) REFERENCES fields(field_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- ==========================================
-- Sample data for testing
-- ==========================================
INSERT INTO exercises (title, status) VALUES 
('Introduction to PHP', 'building'),
('Database Design', 'building');

INSERT INTO fields (exercise_id, label, value_kind) VALUES 
(1, 'Your Name', 'single_line'),
(1, 'Favorite Programming Languages', 'single_line_list'),
(1, 'Why do you want to learn PHP?', 'multi_line');

-- Sample fulfillment
INSERT INTO fulfillments (exercise_id) VALUES (1);

-- Sample answers for this fulfillment
INSERT INTO answers (fulfillment_id, field_id, answer_text) VALUES
(1, 1, 'John Doe'),
(1, 2, 'PHP, JavaScript, Python'),
(1, 3, 'Because it is widely used for web development');
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
    position INT DEFAULT 0,
    FOREIGN KEY (exercise_id) REFERENCES exercises(exercise_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- ==========================================
-- Table: Answers
-- Stores student responses to exercises
-- ==========================================
CREATE TABLE answers (
    answer_id INT AUTO_INCREMENT PRIMARY KEY,
    field_id INT NOT NULL,
    answer_text TEXT,
    answer_date DATETIME DEFAULT CURRENT_TIMESTAMP,
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

INSERT INTO fields (exercise_id, label, value_kind, position) VALUES 
(1, 'Your Name', 'single_line', 1),
(1, 'Favorite Programming Languages', 'single_line_list', 2),
(1, 'Why do you want to learn PHP?', 'multi_line', 3);
-- Day 9: Database Setup for Student Management System
-- Run this in phpMyAdmin or MySQL command line

CREATE DATABASE IF NOT EXISTS students_management;
USE students_management;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    college VARCHAR(100) NOT NULL,
    branch VARCHAR(50) NOT NULL,
    cgpa DECIMAL(3,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO students (name, email, college, branch, cgpa) VALUES
('Vinayak', 'vinayak@edu.com', 'JECRC University', 'CSE', 8.40),
('Ankit Verma', 'ankit@edu.com', 'JECRC University', 'ECE', 7.90),
('Priya Singh', 'priya@edu.com', 'Manipal University', 'IT', 9.10),
('Sara Khan', 'sara@edu.com', 'Amity University', 'CSE', 8.80),
('Dev Patel', 'dev@edu.com', 'JECRC University', 'ECE', 7.50),
('Neha Gupta', 'neha@edu.com', 'Manipal University', 'IT', 9.50);

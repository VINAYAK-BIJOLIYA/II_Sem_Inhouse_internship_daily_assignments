-- Day 12: Full Project Database Setup
CREATE DATABASE IF NOT EXISTS students_management;
USE students_management;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) DEFAULT NULL,
    college VARCHAR(100) NOT NULL,
    branch VARCHAR(50) NOT NULL,
    cgpa DECIMAL(3,2) DEFAULT 0.00,
    photo VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (name, email, password, college, branch, cgpa) VALUES
('Vinayak', 'vinayak@edu.com', 'admin123', 'SKIT', 'CSE', 8.40),
('Ankit Verma', 'ankit@edu.com', 'admin123', 'JECRC University', 'ECE', 7.90),
('Priya Singh', 'priya@edu.com', 'admin123', 'Manipal University', 'IT', 9.10),
('Sara Khan', 'sara@edu.com', 'admin123', 'Amity University', 'CSE', 8.80),
('Dev Patel', 'dev@edu.com', 'admin123', 'JECRC University', 'ECE', 7.50),
('Neha Gupta', 'neha@edu.com', 'admin123', 'Manipal University', 'IT', 9.50);

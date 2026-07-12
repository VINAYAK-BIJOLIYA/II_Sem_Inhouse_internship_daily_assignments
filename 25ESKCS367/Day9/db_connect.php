<?php
/**
 * Database Connection File
 * For Day 9: PHP and MySQL - Saving Data Permanently
 * 
 * Create database: CREATE DATABASE students_management;
 * Create table:
 *   CREATE TABLE students (
 *     id INT AUTO_INCREMENT PRIMARY KEY,
 *     name VARCHAR(100) NOT NULL,
 *     email VARCHAR(100) NOT NULL,
 *     college VARCHAR(100) NOT NULL,
 *     branch VARCHAR(50) NOT NULL,
 *     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 *   );
 */

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'students_management';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>

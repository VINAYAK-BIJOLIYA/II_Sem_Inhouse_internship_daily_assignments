<?php
session_start();
include "db_connect.php";

// ADD student
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $college = mysqli_real_escape_string($conn, trim($_POST['college']));
    $branch = mysqli_real_escape_string($conn, trim($_POST['branch']));
    $cgpa = floatval($_POST['cgpa'] ?? 0);
    $password = $_POST['password'] ?? '';

    $check = mysqli_query($conn, "SELECT id FROM students WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Email already exists";
    } else {
        $passwordCol = $password ? ", password='$password'" : "";
        $sql = "INSERT INTO students (name, email, college, branch, cgpa$passwordCol) 
                VALUES ('$name', '$email', '$college', '$branch', $cgpa)";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Student added successfully!";
        } else {
            $_SESSION['error'] = "Error: " . mysqli_error($conn);
        }
    }
    header("Location: index.php?tab=students");
    exit;
}

// UPDATE student
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $college = mysqli_real_escape_string($conn, trim($_POST['college']));
    $branch = mysqli_real_escape_string($conn, trim($_POST['branch']));
    $cgpa = floatval($_POST['cgpa'] ?? 0);

    $sql = "UPDATE students SET name='$name', email='$email', college='$college', branch='$branch', cgpa=$cgpa WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Student updated successfully!";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }
    header("Location: index.php?tab=students");
    exit;
}

// DELETE student
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM students WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Student deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting student";
    }
    header("Location: index.php?tab=students");
    exit;
}

header("Location: index.php");
exit;
?>

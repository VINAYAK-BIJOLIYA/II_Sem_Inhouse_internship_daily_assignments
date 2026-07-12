<?php
session_start();
include "db_connect.php";

// INSERT student
if (isset($_POST['add_student'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $college = mysqli_real_escape_string($conn, trim($_POST['college']));
    $branch = mysqli_real_escape_string($conn, trim($_POST['branch']));

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT id FROM students WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Email already exists!";
    } else {
        $sql = "INSERT INTO students (name, email, college, branch) VALUES ('$name', '$email', '$college', '$branch')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Student added successfully!";
        } else {
            $_SESSION['error'] = "Error: " . mysqli_error($conn);
        }
    }
    header("Location: index.php");
    exit;
}

// UPDATE student
if (isset($_POST['update_student'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $college = mysqli_real_escape_string($conn, trim($_POST['college']));
    $branch = mysqli_real_escape_string($conn, trim($_POST['branch']));

    $sql = "UPDATE students SET name='$name', email='$email', college='$college', branch='$branch' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Student updated successfully!";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }
    header("Location: index.php");
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
    header("Location: index.php");
    exit;
}

header("Location: index.php");
exit;
?>

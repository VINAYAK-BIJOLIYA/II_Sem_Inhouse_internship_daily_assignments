<?php
session_start();
include "db_connect.php";

// LOGIN
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password required";
        header("Location: index.php?tab=login");
        exit;
    }

    $stmt = mysqli_prepare($conn, "SELECT id, name, email FROM students WHERE email = ? AND password = ?");
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];
        header("Location: index.php?tab=dashboard");
    } else {
        $_SESSION['error'] = "Invalid email or password";
        header("Location: index.php?tab=login");
    }
    exit;
}

// REGISTER
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];
    $college = mysqli_real_escape_string($conn, trim($_POST['college']));
    $branch = mysqli_real_escape_string($conn, trim($_POST['branch']));

    if (empty($name) || empty($email) || empty($password) || empty($college) || empty($branch)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: index.php?tab=register");
        exit;
    }

    if (strlen($password) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters";
        header("Location: index.php?tab=register");
        exit;
    }

    $check = mysqli_query($conn, "SELECT id FROM students WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Email already registered";
    } else {
        $sql = "INSERT INTO students (name, email, password, college, branch) VALUES ('$name', '$email', '$password', '$college', '$branch')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Registration successful! Please login.";
        } else {
            $_SESSION['error'] = "Registration failed: " . mysqli_error($conn);
        }
    }
    header("Location: index.php?tab=login");
    exit;
}

header("Location: index.php");
exit;
?>

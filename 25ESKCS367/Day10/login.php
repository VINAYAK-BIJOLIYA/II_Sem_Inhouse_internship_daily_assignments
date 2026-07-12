<?php
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include "db_connect.php";
    
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Email and password are required";
    } else {
        // Query user
        $stmt = mysqli_prepare($conn, "SELECT id, name, email, password FROM students WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            if ($password === $row['password']) {
                // Login successful - set session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "No account found with this email";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Day 10</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1a1a2e, #16213e); min-height: 100vh; display: flex; align-items: center; }
        .login-card { border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Login</h2>
                        <p class="text-center text-muted mb-4">Student Management System</p>
                        
                        <?php if ($error) { ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php } ?>
                        
                        <form method="POST" action="login.php">
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" 
                                       placeholder="you@example.com" required 
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" 
                                       placeholder="Enter password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        
                        <hr>
                        <p class="text-center text-muted">
                            Don't have an account? <a href="register.php">Register here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
session_start();
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include "db_connect.php";
    
    $name = mysqli_real_escape_string($conn, trim($_POST['name'] ?? ''));
    $email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $college = mysqli_real_escape_string($conn, trim($_POST['college'] ?? ''));
    $branch = mysqli_real_escape_string($conn, trim($_POST['branch'] ?? ''));

    if (empty($name) || empty($email) || empty($password) || empty($college) || empty($branch)) {
        $error = "All fields are required";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } else {
        // Check if email exists
        $check = mysqli_query($conn, "SELECT id FROM students WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already registered";
        } else {
            $sql = "INSERT INTO students (name, email, password, college, branch) 
                    VALUES ('$name', '$email', '$password', '$college', '$branch')";
            if (mysqli_query($conn, $sql)) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Registration failed: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Day 10</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1a1a2e, #16213e); min-height: 100vh; display: flex; align-items: center; }
        .reg-card { border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card reg-card">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Register</h2>
                        
                        <?php if ($error) { ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php } ?>
                        <?php if ($success) { ?>
                            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                        <?php } ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" required
                                       value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">College</label>
                                <input type="text" name="college" class="form-control" required
                                       value="<?= htmlspecialchars($_POST['college'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Branch</label>
                                <input type="text" name="branch" class="form-control" required
                                       value="<?= htmlspecialchars($_POST['branch'] ?? '') ?>">
                            </div>
                            <button type="submit" class="btn btn-success w-100">Register</button>
                        </form>
                        
                        <hr>
                        <p class="text-center text-muted">
                            Already have an account? <a href="login.php">Login here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

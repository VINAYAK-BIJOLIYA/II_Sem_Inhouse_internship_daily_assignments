<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "db_connect.php";

// Get total students count
$countQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM students");
$totalStudents = mysqli_fetch_assoc($countQuery)['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Day 10</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-gradient { background: linear-gradient(135deg, #1a1a2e, #16213e); }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-gradient">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Student Management</a>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3">
                    Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>
                </span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success">
                    <strong>Login Successful!</strong> You are now authenticated.
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-start border-4 border-primary">
                    <div class="card-body">
                        <h5 class="text-muted">Total Students</h5>
                        <h2 class="text-primary"><?= $totalStudents ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-start border-4 border-success">
                    <div class="card-body">
                        <h5 class="text-muted">Your Role</h5>
                        <h2 class="text-success">Admin</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-start border-4 border-info">
                    <div class="card-body">
                        <h5 class="text-muted">Session Active</h5>
                        <h2 class="text-info">Yes</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student List -->
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Student Directory</h5>
            </div>
            <div class="card-body">
                <?php
                $students = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
                if (mysqli_num_rows($students) > 0) {
                ?>
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr><th>#</th><th>Name</th><th>Email</th><th>Branch</th></tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($students)) {
                            ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['branch']) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p class="text-muted text-center">No students in the database yet.</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-4">
        <p class="mb-0">&copy; 2026 Day 10 — Secure Login System | Session: <?= $_SESSION['user_email'] ?></p>
    </footer>
</body>
</html>

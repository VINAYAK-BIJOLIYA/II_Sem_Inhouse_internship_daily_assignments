<?php
session_start();
include "db_connect.php";

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

// For edit mode
$editStudent = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
    $editStudent = mysqli_fetch_assoc($result);
}

// Fetch all students
$students = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");

// Count stats
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM students");
$totalStudents = mysqli_fetch_assoc($totalQuery)['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System - Day 9</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .bg-gradient { background: linear-gradient(135deg, #1a1a2e, #16213e); color: white; }
        .stat-card { border-radius: 10px; padding: 15px; text-align: center; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-gradient">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Student Management System</a>
            <span class="navbar-text">Day 9 — PHP + MySQL CRUD</span>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card bg-white shadow-sm border-start border-4 border-primary">
                    <h2 class="text-primary"><?= $totalStudents ?></h2>
                    <p class="text-muted mb-0">Total Students</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-white shadow-sm border-start border-4 border-success">
                    <h2 class="text-success"><?= mysqli_num_rows($students) ?></h2>
                    <p class="text-muted mb-0">Active Records</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-white shadow-sm border-start border-4 border-info">
                    <h2 class="text-info"><?= date('Y') ?></h2>
                    <p class="text-muted mb-0">Academic Year</p>
                </div>
            </div>
        </div>

        <?php if ($success) { ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php } ?>
        <?php if ($error) { ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php } ?>

        <div class="row">
            <!-- Add/Edit Form -->
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><?= $editStudent ? 'Edit Student' : 'Add Student' ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="process.php" method="POST">
                            <input type="hidden" name="id" value="<?= $editStudent['id'] ?? '' ?>">

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="<?= $editStudent['name'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?= $editStudent['email'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">College</label>
                                <input type="text" name="college" class="form-control"
                                    value="<?= $editStudent['college'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Branch</label>
                                <input type="text" name="branch" class="form-control"
                                    value="<?= $editStudent['branch'] ?? '' ?>" required>
                            </div>

                            <?php if ($editStudent) { ?>
                                <div class="d-flex gap-2">
                                    <button type="submit" name="update_student" class="btn btn-success">Update</button>
                                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            <?php } else { ?>
                                <button type="submit" name="add_student" class="btn btn-primary w-100">Add Student</button>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Students Table -->
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">All Students</h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if (mysqli_num_rows($students) > 0) { ?>
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>College</th>
                                        <th>Branch</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($students)) {
                                        $gradeClass = ($row['cgpa'] > 8) ? 'table-success' : 'table-warning';
                                    ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= htmlspecialchars($row['name']) ?></td>
                                            <td><?= htmlspecialchars($row['email']) ?></td>
                                            <td><?= htmlspecialchars($row['college']) ?></td>
                                            <td><?= htmlspecialchars($row['branch']) ?></td>
                                            <td>
                                                <a href="index.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="process.php?delete=<?= $row['id'] ?>"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Delete this student?')">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <div class="text-center py-4 text-muted">
                                No students found. Add your first student using the form.
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-4">
        <p class="mb-0">&copy; 2026 Student Management System — Day 9 | PHP + MySQL CRUD</p>
    </footer>
</body>
</html>

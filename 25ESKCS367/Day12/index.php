<?php
session_start();
include "db_connect.php";

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
$tab = $_GET['tab'] ?? 'students';
$search = $_GET['search'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

// Search query
$searchQuery = "";
$tabQuery = "";
if ($search) {
    $s = mysqli_real_escape_string($conn, $search);
    $searchQuery = " AND (name LIKE '%$s%' OR email LIKE '%$s%' OR branch LIKE '%$s%')";
}

// Count students
$studentCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM students"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Project - Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #1a1a2e, #16213e); color: white; }
        .sidebar a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; padding: 12px 20px; border-radius: 8px; margin: 4px 10px; transition: all 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); color: white; }
        .sidebar a i { width: 25px; }
        .stat-box { border-radius: 12px; padding: 20px; color: white; }
        .main-content { padding: 20px; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-3">
                <h4 class="text-center mb-4">
                    <i class="fas fa-graduation-cap"></i>
                    <br><span style="font-size:14px;">SMS Pro</span>
                </h4>
                <a href="index.php?tab=dashboard" class="<?= $tab === 'dashboard' ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="index.php?tab=students" class="<?= $tab === 'students' ? 'active' : '' ?>">
                    <i class="fas fa-users"></i> Students
                </a>
                <a href="index.php?tab=add" class="<?= $tab === 'add' ? 'active' : '' ?>">
                    <i class="fas fa-user-plus"></i> Add Student
                </a>
                <a href="index.php?tab=login" class="<?= $tab === 'login' ? 'active' : '' ?>">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="index.php?tab=register" class="<?= $tab === 'register' ? 'active' : '' ?>">
                    <i class="fas fa-user-check"></i> Register
                </a>
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <a href="logout.php" class="text-danger mt-3">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                <?php } ?>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
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

                <!-- DASHBOARD TAB -->
                <?php if ($tab === 'dashboard' || $tab === '') { ?>
                    <h3 class="mb-4"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h3>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="stat-box" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                <h2><?= $studentCount ?></h2>
                                <p class="mb-0">Total Students</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-box" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                                <h2><?= date('d M') ?></h2>
                                <p class="mb-0">Today's Date</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-box" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                                <h2><?= date('l') ?></h2>
                                <p class="mb-0">Day</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-box" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                                <h2><?= date('H:i') ?></h2>
                                <p class="mb-0">Current Time</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Students -->
                    <div class="card card-custom">
                        <div class="card-header bg-white fw-bold">
                            <i class="fas fa-clock me-2"></i>Recent Students
                        </div>
                        <div class="card-body">
                            <?php
                            $recent = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC LIMIT 5");
                            if (mysqli_num_rows($recent) > 0) {
                            ?>
                                <table class="table table-hover">
                                    <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Branch</th><th>CGPA</th></tr></thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($recent)) { ?>
                                            <tr>
                                                <td><?= $row['id'] ?></td>
                                                <td><?= htmlspecialchars($row['name']) ?></td>
                                                <td><?= htmlspecialchars($row['email']) ?></td>
                                                <td><?= htmlspecialchars($row['branch']) ?></td>
                                                <td><strong><?= $row['cgpa'] ?></strong></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <p class="text-muted text-center">No students yet. Add some students first!</p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <!-- STUDENTS TAB -->
                <?php if ($tab === 'students') { ?>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3><i class="fas fa-users me-2"></i>All Students</h3>
                        <a href="index.php?tab=add" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Add Student
                        </a>
                    </div>

                    <form method="GET" class="mb-3">
                        <input type="hidden" name="tab" value="students">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search students..." value="<?= htmlspecialchars($search) ?>">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </form>

                    <div class="card card-custom">
                        <div class="card-body p-0">
                            <?php
                            $students = mysqli_query($conn, "SELECT * FROM students WHERE 1=1$searchQuery ORDER BY id DESC");
                            if (mysqli_num_rows($students) > 0) {
                            ?>
                                <table class="table table-hover mb-0">
                                    <thead class="table-dark">
                                        <tr><th>#</th><th>Name</th><th>Email</th><th>College</th><th>Branch</th><th>CGPA</th><th>Actions</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($students)) {
                                            $grade = $row['cgpa'] >= 9 ? 'A+' : ($row['cgpa'] >= 8 ? 'A' : ($row['cgpa'] >= 7 ? 'B+' : 'B'));
                                            $badge = $row['cgpa'] >= 9 ? 'bg-success' : ($row['cgpa'] >= 8 ? 'bg-primary' : ($row['cgpa'] >= 7 ? 'bg-warning' : 'bg-danger'));
                                        ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= htmlspecialchars($row['name']) ?></td>
                                                <td><?= htmlspecialchars($row['email']) ?></td>
                                                <td><?= htmlspecialchars($row['college']) ?></td>
                                                <td><?= htmlspecialchars($row['branch']) ?></td>
                                                <td><strong><?= $row['cgpa'] ?></strong> <span class="badge <?= $badge ?>"><?= $grade ?></span></td>
                                                <td>
                                                    <a href="index.php?tab=add&edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="process.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Delete this student?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    No students found
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <!-- ADD/EDIT STUDENT TAB -->
                <?php if ($tab === 'add') { ?>
                    <h3 class="mb-4">
                        <i class="fas fa-user-plus me-2"></i>
                        <?= isset($_GET['edit']) ? 'Edit Student' : 'Add New Student' ?>
                    </h3>
                    <?php
                    $editData = null;
                    if (isset($_GET['edit'])) {
                        $editId = intval($_GET['edit']);
                        $res = mysqli_query($conn, "SELECT * FROM students WHERE id=$editId");
                        $editData = mysqli_fetch_assoc($res);
                    }
                    ?>
                    <div class="card card-custom">
                        <div class="card-body">
                            <form method="POST" action="process.php">
                                <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="name" class="form-control" 
                                               value="<?= $editData['name'] ?? '' ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" 
                                               value="<?= $editData['email'] ?? '' ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">College</label>
                                        <input type="text" name="college" class="form-control" 
                                               value="<?= $editData['college'] ?? '' ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Branch</label>
                                        <input type="text" name="branch" class="form-control" 
                                               value="<?= $editData['branch'] ?? '' ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CGPA</label>
                                        <input type="number" step="0.01" name="cgpa" class="form-control" 
                                               value="<?= $editData['cgpa'] ?? '' ?>" placeholder="e.g. 8.45">
                                    </div>
                                    <?php if (!$editData) { ?>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" 
                                               placeholder="Set password for login">
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php if ($editData) { ?>
                                    <button type="submit" name="update" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>Update Student
                                    </button>
                                <?php } else { ?>
                                    <button type="submit" name="add" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i>Add Student
                                    </button>
                                <?php } ?>
                                <a href="index.php?tab=students" class="btn btn-outline-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                <?php } ?>

                <!-- LOGIN TAB -->
                <?php if ($tab === 'login') { ?>
                    <?php if (isset($_SESSION['user_id'])) {
                        header("Location: index.php?tab=dashboard");
                        exit;
                    } ?>
                    <div class="row justify-content-center mt-5">
                        <div class="col-md-5">
                            <div class="card card-custom">
                                <div class="card-body p-4">
                                    <h3 class="text-center mb-4"><i class="fas fa-sign-in-alt me-2"></i>Login</h3>
                                    <form method="POST" action="auth.php">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                        <button type="submit" name="login" class="btn btn-primary w-100">
                                            <i class="fas fa-sign-in-alt me-1"></i>Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- REGISTER TAB -->
                <?php if ($tab === 'register') { ?>
                    <?php if (isset($_SESSION['user_id'])) {
                        header("Location: index.php?tab=dashboard");
                        exit;
                    } ?>
                    <div class="row justify-content-center mt-5">
                        <div class="col-md-5">
                            <div class="card card-custom">
                                <div class="card-body p-4">
                                    <h3 class="text-center mb-4"><i class="fas fa-user-check me-2"></i>Register</h3>
                                    <form method="POST" action="auth.php">
                                        <div class="mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" required minlength="6">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">College</label>
                                            <input type="text" name="college" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Branch</label>
                                            <input type="text" name="branch" class="form-control" required>
                                        </div>
                                        <button type="submit" name="register" class="btn btn-success w-100">
                                            <i class="fas fa-user-check me-1"></i>Register
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

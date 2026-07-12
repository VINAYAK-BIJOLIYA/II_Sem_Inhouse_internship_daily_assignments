<?php
$errors = [];
$success = "";
$name = $email = $gender = $course = $city = "";
$skills = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $gender = $_POST["gender"] ?? "";
    $course = $_POST["course"] ?? "";
    $skills = $_POST["skills"] ?? [];
    $city = $_POST["city"] ?? "";

    // Validation
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
    if (empty($gender)) $errors[] = "Please select gender";
    if (empty($course)) $errors[] = "Please select a course";
    if (empty($skills)) $errors[] = "Please select at least one skill";
    if (empty($city)) $errors[] = "Please select a city";

    if (empty($errors)) {
        $success = "Registration Successful! Welcome, $name!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Registration Form - Day 7</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Student Registration — PHP Backend</h2>

        <?php if (!empty($errors)) { ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error) { ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <?php if ($success) { ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php } ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="register.php">
                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
                    </div>
                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
                    </div>
                    <!-- Gender -->
                    <div class="mb-3">
                        <label class="form-label">Gender</label><br>
                        <input type="radio" name="gender" value="Male" <?= $gender === "Male" ? "checked" : "" ?>> Male
                        <input type="radio" name="gender" value="Female" <?= $gender === "Female" ? "checked" : "" ?>> Female
                    </div>
                    <!-- Course -->
                    <div class="mb-3">
                        <label class="form-label">Course</label>
                        <select name="course" class="form-select" required>
                            <option value="">Select Course</option>
                            <option value="B.Tech CSE" <?= $course === "B.Tech CSE" ? "selected" : "" ?>>B.Tech CSE</option>
                            <option value="B.Tech IT" <?= $course === "B.Tech IT" ? "selected" : "" ?>>B.Tech IT</option>
                            <option value="BCA" <?= $course === "BCA" ? "selected" : "" ?>>BCA</option>
                            <option value="MCA" <?= $course === "MCA" ? "selected" : "" ?>>MCA</option>
                        </select>
                    </div>
                    <!-- Skills -->
                    <div class="mb-3">
                        <label class="form-label">Skills</label><br>
                        <?php
                        $skillOptions = ["HTML", "CSS", "JavaScript", "PHP", "MySQL"];
                        foreach ($skillOptions as $skill) {
                            $checked = in_array($skill, $skills) ? "checked" : "";
                            echo "<input type='checkbox' name='skills[]' value='$skill' $checked> $skill ";
                        }
                        ?>
                    </div>
                    <!-- City -->
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <select name="city" class="form-select">
                            <option value="">Select City</option>
                            <?php
                            $cities = ["Jaipur", "Delhi", "Mumbai", "Bangalore", "Hyderabad"];
                            foreach ($cities as $c) {
                                $sel = $city === $c ? "selected" : "";
                                echo "<option value='$c' $sel>$c</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>

        <?php if ($success) { ?>
            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-success text-white">Registration Details</div>
                <div class="card-body">
                    <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
                    <p><strong>Gender:</strong> <?= htmlspecialchars($gender) ?></p>
                    <p><strong>Course:</strong> <?= htmlspecialchars($course) ?></p>
                    <p><strong>Skills:</strong> <?= htmlspecialchars(implode(", ", $skills)) ?></p>
                    <p><strong>City:</strong> <?= htmlspecialchars($city) ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>

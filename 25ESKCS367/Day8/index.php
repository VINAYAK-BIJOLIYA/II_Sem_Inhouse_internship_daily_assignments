<?php
// Day 8: Building Dynamic Web Pages with PHP
// Demonstration of PHP dynamic pages, includes, functions, and loops

$pageTitle = "Day 8 - Dynamic PHP Pages";
$students = [
    ["name" => "Vinayak", "branch" => "CSE", "cgpa" => 8.4, "year" => "2nd"],
    ["name" => "Vishal", "branch" => "ECE", "cgpa" => 7.9, "year" => "3rd"],
    ["name" => "Vikash", "branch" => "IT", "cgpa" => 9.1, "year" => "2nd"],
    ["name" => "Yuvraj", "branch" => "CSE", "cgpa" => 8.8, "year" => "1st"],
    ["name" => "Yash", "branch" => "ECE", "cgpa" => 7.5, "year" => "3rd"],
    ["name" => "Neha Gupta", "branch" => "IT", "cgpa" => 9.5, "year" => "4th"]
];

// Helper function
function getGrade($cgpa) {
    if ($cgpa >= 9.0) return "A+";
    if ($cgpa >= 8.0) return "A";
    if ($cgpa >= 7.0) return "B+";
    if ($cgpa >= 6.0) return "B";
    return "C";
}

function getGradeClass($cgpa) {
    if ($cgpa >= 9.0) return "bg-success";
    if ($cgpa >= 8.0) return "bg-primary";
    if ($cgpa >= 7.0) return "bg-warning";
    return "bg-danger";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include __DIR__ . '/header.php'; ?>

    <div class="container mt-4">
        <!-- Section 1: PHP Functions -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">1. PHP Functions</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>CGPA</th>
                            <th>Grade</th>
                            <th>Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student) { ?>
                            <tr>
                                <td><?= htmlspecialchars($student['name']) ?></td>
                                <td><?= htmlspecialchars($student['branch']) ?></td>
                                <td><strong><?= $student['cgpa'] ?></strong></td>
                                <td>
                                    <span class="badge <?= getGradeClass($student['cgpa']) ?>">
                                        <?= getGrade($student['cgpa']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($student['year']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 2: Dynamic Cards -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">2. Dynamic Bootstrap Cards</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($students as $student) { ?>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($student['name']) ?></h5>
                                    <p class="card-text">
                                        <strong>Branch:</strong> <?= htmlspecialchars($student['branch']) ?><br>
                                        <strong>CGPA:</strong> <?= $student['cgpa'] ?><br>
                                        <strong>Year:</strong> <?= htmlspecialchars($student['year']) ?>
                                    </p>
                                    <span class="badge <?= getGradeClass($student['cgpa']) ?> fs-6">
                                        Grade: <?= getGrade($student['cgpa']) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Section 3: PHP String & Math -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">3. PHP String & Math Functions</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>String Functions</h5>
                        <ul>
                            <li>Length of 'Rahul': <?= strlen('Vinayak') ?></li>
                            <li>Uppercase: <?= strtoupper('hello world') ?></li>
                            <li>Word count: <?= str_word_count('PHP is great for web') ?></li>
                            <li>Reversed: <?= strrev('Hello') ?></li>
                            <li>Replace: <?= str_replace('great', 'amazing', 'PHP is great') ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>Math Functions</h5>
                        <ul>
                            <li>Average CGPA: <?= round(array_sum(array_column($students, 'cgpa')) / count($students), 2) ?></li>
                            <li>Highest CGPA: <?= max(array_column($students, 'cgpa')) ?></li>
                            <li>Lowest CGPA: <?= min(array_column($students, 'cgpa')) ?></li>
                            <li>Random number: <?= rand(1, 100) ?></li>
                            <li>PI value: <?= pi() ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Conditional Display -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-warning">
                <h4 class="mb-0">4. Conditional Display (Ternary)</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr><th>Name</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student) { ?>
                            <tr class="<?= ($student['cgpa'] >= 8) ? 'table-success' : 'table-warning' ?>">
                                <td><?= htmlspecialchars($student['name']) ?></td>
                                <td>
                                    <?= ($student['cgpa'] >= 8) ? 'Top Performer' : 'Needs Improvement' ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>

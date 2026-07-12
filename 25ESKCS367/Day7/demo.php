<?php
// Demo: PHP Basics
$name = "Vinayak";
$branch = "CSE";
$year = "2nd Year";

echo "<h2>Welcome to PHP Backend!</h2>";
echo "<p>Student: <strong>$name</strong></p>";
echo "<p>Branch: <strong>$branch</strong></p>";
echo "<p>Year: <strong>$year</strong></p>";
echo "<p>Server Time: <strong>" . date("h:i:s A") . "</strong></p>";
echo "<p>Server Date: <strong>" . date("d-m-Y") . "</strong></p>";

// Variables demo
echo "<hr>";
echo "<h3>PHP Variables Demo</h3>";
$x = 10;
$y = 20;
echo "x + y = " . ($x + $y) . "<br>";
echo "x - y = " . ($x - $y) . "<br>";
echo "x * y = " . ($x * $y) . "<br>";
echo "x / y = " . ($x / $y) . "<br>";

// String functions
echo "<hr>";
echo "<h3>String Functions</h3>";
$text = "  Hello World  ";
echo "Original: '$text'<br>";
echo "Trimmed: '" . trim($text) . "'<br>";
echo "Length: " . strlen($text) . "<br>";
echo "Uppercase: " . strtoupper($text) . "<br>";
echo "Lowercase: " . strtolower($text) . "<br>";
echo "Word Count: " . str_word_count($text) . "<br>";
echo "Replace: " . str_replace("World", "PHP", $text) . "<br>";
?>
<!DOCTYPE html>
<html>
<head><title>PHP Demo - Day 7</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1>PHP Basics Demo</h1>
    <p>PHP runs on the server and outputs HTML to the browser.</p>
</div>
</body>
</html>

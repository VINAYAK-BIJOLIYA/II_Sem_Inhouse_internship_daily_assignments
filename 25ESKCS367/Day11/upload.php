<?php
session_start();
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentId = intval($_POST['student_id'] ?? 0);
    
    if ($studentId == 0) {
        $_SESSION['error'] = "Please select a student";
        header("Location: index.php");
        exit;
    }

    // Check if file was uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['photo'];
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            $_SESSION['error'] = "Only JPG, PNG, and GIF images are allowed";
            header("Location: index.php");
            exit;
        }
        
        // Validate file size (2MB max)
        if ($file['size'] > 2 * 1024 * 1024) {
            $_SESSION['error'] = "File size must be less than 2MB";
            header("Location: index.php");
            exit;
        }
        
        // Create uploads directory
        $uploadDir = __DIR__ . '/uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Generate unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = "student_" . $studentId . "_" . time() . "." . $ext;
        $filePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Update database with photo path
            $photoPath = "uploads/" . $fileName;
            $sql = "UPDATE students SET photo = '$photoPath' WHERE id = $studentId";
            mysqli_query($conn, $sql);
            
            $_SESSION['success'] = "Photo uploaded successfully!";
        } else {
            $_SESSION['error'] = "Failed to upload photo";
        }
    } else {
        $_SESSION['error'] = "Please select a file to upload";
    }
    
    header("Location: index.php");
    exit;
}

header("Location: index.php");
exit;
?>

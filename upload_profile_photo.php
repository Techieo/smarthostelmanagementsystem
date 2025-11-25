<?php
session_start();
include("db_connect.php");

// Step 3a: Make sure the user is logged in
if (!isset($_SESSION['student_id'])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit();
}

$userId = $_SESSION['student_id'];

// Step 3b: Check if file is uploaded
if (isset($_FILES['profile_photo'])) {
    $file = $_FILES['profile_photo'];
    $allowed = ['jpg','jpeg','png','gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        echo json_encode(["success" => false, "error" => "Invalid file type"]);
        exit();
    }

    // Step 3c: Create folder if it doesn't exist
    $uploadDir = "uploads/profile_photos/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    // Step 3d: Save file with unique name per student
    $filename = "student_" . $userId . "." . $ext;
    $filepath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        // Step 3e: Update the database
        $stmt = $conn->prepare("UPDATE students SET profile_photo=? WHERE student_id=?");
        $stmt->bind_param("si", $filepath, $userId);
        $stmt->execute();

        echo json_encode(["success" => true, "filepath" => $filepath]);
    } else {
        echo json_encode(["success" => false, "error" => "Upload failed"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No file uploaded"]);
}
?>
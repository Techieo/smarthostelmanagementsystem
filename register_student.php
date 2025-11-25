<?php
header('Content-Type: application/json');
include 'db_connect.php'; // your DB connection

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists in students table
    $stmt = $conn->prepare("SELECT id FROM students WHERE personal_email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0){
        echo json_encode(['success'=>false, 'message'=>'Email already exists']);
        exit;
    }
    $stmt->close();

    // Insert new student into students table
    $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, personal_email, password, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);

    if($stmt->execute()){
        echo json_encode(['success'=>true]);
    } else {
        echo json_encode(['success'=>false, 'message'=>$stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success'=>false, 'message'=>'Invalid request']);
}
?>

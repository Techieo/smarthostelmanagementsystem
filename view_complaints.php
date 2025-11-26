<?php
session_start();
include 'db_connect.php';

// Get complaint ID from URL
$complaint_id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM complaints WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $complaint_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $complaint = $result->fetch_assoc();
} else {
    echo "<p style='text-align:center; margin-top:50px;'>Complaint not found!</p>";
    echo "<p style='text-align:center;'><a href='admin_complaints.php'>Back to Complaints</a></p>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Complaint | Smart Hostel Management</title>
<link rel="stylesheet" href="CASCADINGSTYLES/resetpassword.css"> <!-- reuse existing styles if you want -->
<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f7fb;
    padding: 30px;
}
.view-container {
    max-width: 700px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.view-container h2 {
    text-align: center;
    color: #003366;
    margin-bottom: 20px;
}
.detail-label {
    font-weight: 600;
    color: #003366;
}
.detail-value {
    margin-bottom: 15px;
    color: #000;
}
.back-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #ccc;
    color: #000;
    text-decoration: none;
    border-radius: 6px;
    transition: 0.3s;
}
.back-btn:hover {
    background-color: #999;
    color: #fff;
}
</style>
</head>
<body>

<div class="view-container">
    <h2>Complaint Details</h2>

    <p><span class="detail-label">Student Name:</span> <span class="detail-value"><?php echo htmlspecialchars($complaint['full_name']); ?></span></p>
    <p><span class="detail-label">Room Number:</span> <span class="detail-value"><?php echo htmlspecialchars($complaint['room_no']); ?></span></p>
    <p><span class="detail-label">Date Submitted:</span> <span class="detail-value"><?php echo date('Y-m-d', strtotime($complaint['submitted_at'])); ?></span></p>
    <p><span class="detail-label">Complaint Type:</span> <span class="detail-value"><?php echo htmlspecialchars($complaint['category']); ?></span></p>
    <p><span class="detail-label">Description:</span> <span class="detail-value"><?php echo htmlspecialchars($complaint['description']); ?></span></p>
    <p><span class="detail-label">Status:</span> <span class="detail-value"><?php echo ucfirst($complaint['status']); ?></span></p>
    <p><span class="detail-label">Priority:</span> <span class="detail-value"><?php echo ucfirst($complaint['priority']); ?></span></p>

    <a href="admin_complaints.php" class="back-btn">Back to Complaints</a>
</div>

</body>
</html>

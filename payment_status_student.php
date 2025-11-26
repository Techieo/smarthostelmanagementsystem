<?php
session_start();
include 'db_connect.php';

// Assuming student_id is stored in session after login
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

// Fetch student info
$student_query = $conn->prepare("SELECT first_name, last_name FROM students WHERE student_id = ?");
$student_query->bind_param("i", $student_id);
$student_query->execute();
$student_result = $student_query->get_result();
$student = $student_result->fetch_assoc();
$student_query->close();

// Fetch booking info for this student
$booking_query = $conn->prepare("SELECT b.booking_id, r.room_number, r.room_type, r.price 
                                 FROM bookings b 
                                 JOIN rooms r ON b.room_id = r.room_id 
                                 WHERE b.user_id = ?");
$booking_query->bind_param("i", $student_id);
$booking_query->execute();
$booking_result = $booking_query->get_result();
$booking = $booking_result->fetch_assoc();
$booking_query->close();

// Initialize totals
$total_paid = 0;
$total_due = 0;
$balance_remaining = 0;
$payment_status = "No booking";

// Fetch payments only if booking exists
$payments = [];
if ($booking) {
    $total_due = $booking['price'];

    $payments_query = $conn->prepare("SELECT * FROM payments WHERE booking_id = ?");
    $payments_query->bind_param("i", $booking['booking_id']);
    $payments_query->execute();
    $payments_result = $payments_query->get_result();

    while ($row = $payments_result->fetch_assoc()) {
        $payments[] = $row;
        if ($row['status'] === 'paid') {
            $total_paid += $row['amount'];
        }
    }

    $balance_remaining = $total_due - $total_paid;
    $payment_status = ($balance_remaining > 0) ? "Pending" : "Paid";

    $payments_query->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CASCADINGSTYLES/payment.css">
    <script src="JAVASCRIPT_SHMS/payment_status_student.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">  
    <link rel="icon" href="Img/favicon.jpg">
    <title>Payment Status | Smart Hostel Management System</title>
</head>
<body>

    <header>
  <nav>
    <div class="logo">
      <img src="Img/favicon.jpg" alt="SHMS Logo">
    </div>

    <ul class="nav-links">
      <li><a href="home_student.php">Home</a></li>
      <li><a href="dashboard_student.php">Dashboard</a></li>
      <li><a href="book_room.php">Rooms</a></li>
      <li><a href="view_room_status_student.php">View room status</a></li>
      <li><a href="submit_complaint_student.php">Submit Complaint</a></li>
      <li><a href="payment_status_student.php">Payment Status</a></li>
      <li class="dropdown">
        <a href="#">More <i class="fa-solid fa-caret-down"></i></a>
        <div class="dropdown-content">
          <a href="help_FAQs.php">FAQ</a>
          <a href="rules_regulations.php">Rules & Regulations</a>
          <a href="profile.php">Profile</a>
          <a href="logout.php">Log out</a>
        </div>
      </li>
    </ul>

    <div class="icons">
      <div class="hamburger" id="hamburger">
        <span></span><span></span><span></span>
      </div>
      <i class="fa-regular fa-bell"></i>
    </div>
  </nav>
</header>

<!-- =========== MOBILE MENU =========== -->
<div class="mobile-menu" id="mobileMenu">
  <ul>
    <li><a href="home_student.php">Home</a></li>
    <li><a href="dashboard_student.php">Dashboard</a></li>
    <li><a href="book_room.php">Rooms</a></li>
    <li><a href="view_room_status_student.php">View room status</a></li>
    <li><a href="submit_complaint_student.php">Submit Complaint</a></li>
    <li><a href="payment_status_student.php">Payment Status</a></li>
    <li><a href="help_FAQs.php">FAQs</a></li>
    <li><a href="rules_regulations.php">Rules & Regulations</a></li>
    <li><a href="profile_student.php">Profile</a></li>
    <li><a href="logout.php">Log out</a></li>
  </ul>
</div>

    <section id="payment-status-overview">
    <h2>Payment Status Overview</h2>
    <p>Track your hostel payments, check your current balance, and view your transaction history below.</p>

    <div class="dashboard-grid">
        <!-- Payment Summary -->
        <section id="payment-summary">
            <h3>Current Payment Summary</h3>
            <div class="summary-card">
                <p><strong>Student Name:</strong> <?= htmlspecialchars($student['first_name'] . " " . $student['last_name']) ?></p>
                <?php if ($booking): ?>
                    <p><strong>Hostel Room Number:</strong> <?= htmlspecialchars($booking['room_number']) ?></p>
                    <p><strong>Total Amount Due:</strong> KSh <?= number_format($total_due, 2) ?></p>
                    <p><strong>Total Paid:</strong> KSh <?= number_format($total_paid, 2) ?></p>
                    <p><strong>Balance Remaining:</strong> KSh <?= number_format($balance_remaining, 2) ?></p>
                    <p><strong>Payment Status:</strong> <?= $payment_status ?></p>
                <?php else: ?>
                    <p>No booking found yet.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Payment History -->
        <section id="payment-history">
            <h3>Payment History</h3>
            <?php if (!empty($payments)): ?>
                <div class="history-card">
                    <?php foreach ($payments as $p): ?>
                        <article class="transaction-record">
                            <h4>Payment #<?= $p['payment_id'] ?></h4>
                            <p><strong>Date:</strong> <?= $p['payment_date'] ?></p>
                            <p><strong>Amount Paid:</strong> KSh <?= number_format($p['amount'], 2) ?></p>
                            <p><strong>Status:</strong> <?= ucfirst($p['status']) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No payments made yet.</p>
            <?php endif; ?>
        </section>
    </div>

    <!-- Quick Actions -->
    <section id="payment-actions">
        <h3>Quick Actions</h3>
        <div class="action-buttons">
            <?php if ($booking && $balance_remaining > 0): ?>
                <a href="make_payment.php" class="btn-primary">Make Payment Now</a>
            <?php endif; ?>
            <button class="btn-secondary">Download Payment Receipt</button>
        </div>
    </section>
</section>
</main>

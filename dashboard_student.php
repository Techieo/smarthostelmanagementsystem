<?php
include 'db_connect.php';
include 'session_check.php'; // this protects the page

$lastName = $_SESSION['last_name'] ?? 'Student';

// Assume student_id is stored in session after login
$student_id = $_SESSION['student_id'] ?? 0;

// ROOM STATUS
$room_status = $conn->query("
    SELECT r.room_number, r.room_type 
    FROM bookings b
    JOIN rooms r ON b.room_id = r.room_id
    WHERE b.user_id = $student_id AND b.status='confirmed'
")->fetch_assoc(); // here b.user_id = student_id in your case

// COMPLAINTS
$complaints_total = $conn->query("SELECT COUNT(*) as total FROM complaints WHERE reg_no=(SELECT reg_no FROM students WHERE student_id=$student_id)")->fetch_assoc()['total'];
$complaints_pending = $conn->query("SELECT COUNT(*) as pending FROM complaints WHERE reg_no=(SELECT reg_no FROM students WHERE student_id=$student_id) AND status='pending'")->fetch_assoc()['pending'];

// NOTIFICATIONS
$notifications_unread = $conn->query("SELECT COUNT(*) as unread FROM notifications WHERE user_id=$student_id AND is_read=0")->fetch_assoc()['unread'];
$latest_notification = $conn->query("SELECT title, message FROM notifications WHERE user_id=$student_id ORDER BY created_at DESC LIMIT 1")->fetch_assoc();
?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard | Smart Hostel MS</title>
<link rel="stylesheet" href="CASCADINGSTYLES/dashboard_student.css">
<link rel="icon" href="Img/favicon.jpg">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="JAVASCRIPT_SHMS/dashboard_student.js" defer></script>
</head>
<body>

<!-- ================= NAVBAR ================= -->
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
    <li><a href="profile.php">Profile</a></li>
    <li><a href="logout.php">Log out</a></li>
  </ul>
</div>

<!-- ================= MAIN DASHBOARD ================= -->
<main class="dashboard-main">

  <section class="welcome-box card">
    <h2 style="font: size 90px;">Welcome Back, <?php echo htmlspecialchars($lastName); ?> 👋</h2>
    <p>Here is your personalized Smart Hostel dashboard overview.</p>
  </section>

  <section class="summary-grid">
    <div class="summary-card card">
      <i class="fa-solid fa-bed icon"></i>
      <h3>Room Status</h3>
      <?php if($room_status): ?>
        <p><strong>Booked:</strong> 1 Room</p>
        <p><strong>Room:</strong> <?= htmlspecialchars($room_status['room_number']) ?> (<?= htmlspecialchars($room_status['room_type']) ?>)</p>
      <?php else: ?>
        <p>You have not booked any room yet.</p>
      <?php endif; ?>
    </div>

    <div class="summary-card card">
      <i class="fa-solid fa-comments icon"></i>
      <h3>Complaints</h3>
      <p><strong>Total:</strong> <?= $complaints_total ?></p>
      <p><strong>Pending:</strong> <?= $complaints_pending ?></p>
    </div>

    <div class="summary-card card">
      <i class="fa-solid fa-bell icon"></i>
      <h3>Notifications</h3>
      <p><strong>Unread:</strong> <?= $notifications_unread ?></p>
      <?php if($latest_notification): ?>
        <p>Latest: <?= htmlspecialchars($latest_notification['title']) ?></p>
      <?php else: ?>
        <p>No notifications yet.</p>
      <?php endif; ?>
    </div>
</section>

<section class="notifications card">
    <h2>Recent Notifications</h2>
    <ul>
      <?php
      $recent = $conn->query("SELECT title, message FROM notifications WHERE user_id=$student_id ORDER BY created_at DESC LIMIT 5");
      if($recent->num_rows > 0){
          while($row = $recent->fetch_assoc()){
              echo "<li><strong>".htmlspecialchars($row['title']).":</strong> ".htmlspecialchars($row['message'])."</li>";
          }
      } else {
          echo "<li>No recent notifications.</li>";
      }
      ?>
    </ul>
</section>

</main>

<footer class="shms-footer">
    <!-- Container for the four main columns -->
    <div class="shms-footer-columns">
        <!-- Column 1: About -->
        <div class="shms-footer-about">
            <h3>About SHMS</h3>
            <p>SHMS modernizes university hostel operations by providing students with seamless online booking, payment, and communication services, aiming to create a more efficient living and learning environment.</p>
        </div>

        <!-- Column 2: Quick Links -->
        <nav class="shms-footer-quicklinks" aria-label="Quick Navigation Links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="dashboard_student.php">Dashboard</a></li>
                <li><a href="book_room.php">Rooms</a></li>
                <li><a href="rules_regulations.php">Rules & Regulations</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="submit_complaint_student.php">Submit Complaint</a></li>
            </ul>
        </nav>

        <!-- Column 3: Popular Services -->
        <div class="shms-footer-services">
            <h3>Popular Services</h3>
            <ul>
                <li>Wifi</li>
                <li>Laundry</li>
                <li>Meals/Cafeteria</li>
                <li>Housekeeping</li>
            </ul>
        </div>

        <!-- Column 4: Socials -->
        <nav class="shms-footer-socials" aria-label="SHMS Social Media">
            <h3>Socials</h3>
            <ul>
                <li><a href="https://www.facebook.com/profile.php?id=61583166006604" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                <li><a href="https://www.instagram.com/smarthostelmanagementsystem/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                <li><a href="https://www.tiktok.com/@smart.hostel.mana?_r=1&_t=ZM-91btgFDD16u" target="_blank"><i class="fab fa-tiktok"></i> TikTok</a></li>
            </ul>
        </nav>
    </div>

    <!-- Legal Links -->
    <div class="shms-footer-legal">
        <nav>
            <a href="privacy.php">Privacy Policy</a>
            <a href="terms.php">Terms & Conditions</a>
            <a href="about.php">About</a>
        </nav>
    </div>

    <!-- Copyright -->
    <div class="shms-footer-copy">
        <p>© 2025 Smart Hostel Management System. All rights reserved.</p>
    </div>
</footer>
</body>
</html>

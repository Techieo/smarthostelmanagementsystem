<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="JAVASCRIPT_SHMS/test.js" defer></script>
    <link rel="stylesheet" href="CASCADINGSTYLES/test.css">
    <link rel="icon" href="Img/favicon.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Test | Smart Hostel Management System</title>
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
    <li><a href="profile.php">Profile</a></li>
    <li><a href="logout.php">Log out</a></li>
  </ul>
</div>
</body>
</html>
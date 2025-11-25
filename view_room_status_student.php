<?php
include 'session_check.php'; // Ensure only logged-in students can access
include 'db_connect.php';    // Your DB connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CASCADINGSTYLES/viewroomstatus.css">
    <script src="JAVASCRIPT_SHMS/view_room_status_student.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="Img/favicon.jpg">
    <title>View Room Status | Smart Hostel Management System</title>
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

<main>
    <!-- Search and Filter Form -->
    <section id="room-search-filters">
        <h2>Find a Room</h2>
        <form id="search-form">
            <label for="room_number">Room Number:</label>
            <input type="text" id="room_number" name="room_number" placeholder="E.g., B203">
            
            <label for="room_type">Room Type:</label>
            <select id="room_type" name="room_type">
                <option value="">-- All Types --</option>
                <option value="Twin">Twin</option>
                <option value="Quad">Quad</option>
                <option value="Hex">Hex</option>
            </select>
            
            <label for="status_filter">Status:</label>
            <select id="status_filter" name="status_filter">
                <option value="">-- All Statuses --</option>
                <option value="available">Available</option>
                <option value="occupied">Occupied</option>
                <option value="maintenance">Maintenance</option>
            </select>
            
            <button type="submit">Search</button>
        </form>
    </section>

    <!-- Room Status Display Table -->
    <section id="room-availability-table">
        <h2>Current Room Status</h2>
        <table id="room-status-data" width="100%">
    <thead>
        <tr>
            <th>Room No</th>
            <th>Type</th>
            <th>Room Type</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="room-table-body">
        <!-- AJAX populates rows here -->
    </tbody>
</table>


        <legend>
            <p><strong>Status Meanings:</strong></p>
            <ul>
                <li><strong>Available:</strong> Ready for booking.</li>
                <li><strong>Occupied:</strong> Fully booked.</li>
                <li><strong>Maintenance:</strong> Temporarily unavailable for booking/occupancy due to repairs.</li>
            </ul>
        </legend>
        <p id="last-updated">Last Updated: <?php echo date('F d, Y H:i:s'); ?></p>
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    function fetchRooms() {
        let room_number = $('#room_number').val();
        let room_type = $('#room_type').val();
        let status_filter = $('#status_filter').val();

        $.ajax({
            url: 'fetch_rooms.php',
            method: 'GET',
            data: { room_number, room_type, status_filter },
            success: function(data) {
                $('#room-table-body').html(data);
            }
        });
    }

    // Initial fetch
    fetchRooms();

    // Fetch on form submit
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        fetchRooms();
    });

    // Fetch on filter change or typing
    $('#room_type, #status_filter, #room_number').on('change keyup', fetchRooms);
});
</script>
</body>
</html>

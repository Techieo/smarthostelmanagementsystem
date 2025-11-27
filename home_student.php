<?php
include 'db_connect.php';

$query = "SELECT * FROM hostel_images ORDER BY id ASC";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {
    $images[] = $row; // store image_path and room_type
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="JAVASCRIPT_SHMS/home_student.js" defer></script>
    <link rel="stylesheet" href="CASCADINGSTYLES/home.css">
    <link rel="icon" href="Img/favicon.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Home | Smart Hostel Management System</title>
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
          <a href="profile.php">ProfileONE</a>
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


    <br>
    <section id="hero-introduction">
      <h2>Welcome to Smart Hostel <b style="color:yellow">Management</b> System</h2>
      <p>
        SHMS provides a seamless, digital experience for managing your student accommodation.
        From booking rooms to tracking payments and filing complaints, everything is centralized for your convenience.
      </p>
      <div>
        <a href="dashboard_student.php" id="cta-login-btn">Go to Dashboard</a>
        <a href="about.php" id="cta-learn-more-btn">Learn More</a>
      </div>
    </section>
    <br>
    <section id="hostel-slider">
    <div id="hostel-slider">
    <?php foreach($images as $img): ?>
        <div class="slide">
            <img src="<?php echo $img['image_path']; ?>" alt="<?php echo $img['room_type']; ?>">
            <p class="caption"><?php echo $img['room_type']; ?></p>
        </div>
    <?php endforeach; ?>
</div>
</section>


    <section id="features-showcase">
    <h2>Key Features</h2>

    <div class="feature-cards">

        <!-- ORIGINAL 5 -->
        <article id="feature-booking">
            <i class="fas fa-door-open"></i>
            <h3>Easy Room Booking</h3>
            <p>View real-time availability and reserve your preferred room slot quickly through a streamlined online process.</p>
        </article>

        <article id="feature-payment">
            <i class="fas fa-credit-card"></i>
            <h3>Online Payment Tracking</h3>
            <p>Monitor your payment status, view outstanding fees, and access receipts securely from your personal dashboard.</p>
        </article>

        <article id="feature-alerts">
            <i class="fas fa-bell"></i>
            <h3>Notifications & Alerts</h3>
            <p>Receive immediate alerts for important announcements, maintenance schedules, and curfew updates.</p>
        </article>

        <article id="feature-complaint">
            <i class="fas fa-tools"></i>
            <h3>Complaint Management</h3>
            <p>Submit and track maintenance requests or general complaints efficiently, ensuring fast resolution.</p>
        </article>

        <article id="feature-rules">
            <i class="fas fa-book"></i>
            <h3>Rules & FAQs Access</h3>
            <p>Quickly look up all necessary hostel rules, regulations, and frequently asked questions in one place.</p>
        </article>

        <!-- NEW 3 CARDS ADDED -->
        <article id="feature-security">
            <i class="fas fa-shield-alt"></i>
            <h3>Enhanced Security</h3>
            <p>Stay protected with secure access control, monitored entry points, and safe living spaces.</p>
        </article>

        <article id="feature-support">
            <i class="fas fa-headset"></i>
            <h3>24/7 Student Support</h3>
            <p>Reach the warden or support team anytime for emergencies or assistance.</p>
        </article>

        <article id="feature-laundry">
            <i class="fas fa-tshirt"></i>
            <h3>Laundry Services</h3>
            <p>Access laundry schedules and service updates conveniently on your dashboard.</p>
        </article>

    </div>
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


  <style>
/* Full-width slider container */
#hostel-slider {
    width: 100vw; 
    margin-left: calc(50% - 50vw); /* forces true edge-to-edge */
    height: 250px; 
    overflow: hidden;
    position: relative;
    margin-top: 0;
    padding: 0;
}

/* Wrap slides */
#hostel-slider .slide {
    width: 100%;
    height: 100%;
    display: none; /* hidden by default */
    position: absolute;
    top: 0;
    left: 0;
}

/* Images inside slides */
#hostel-slider .slide img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* make images uniform */
}

/* Caption text */
#hostel-slider .slide .caption {
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translateX(-50%); /* centers it */
    padding: 6px 15px;
    color: #fff;
    background: rgba(0,0,0,0.55);
    border-radius: 6px;
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    white-space: nowrap;
}

</style>


<script>
let currentSlide = 0;
const slides = document.querySelectorAll("#hostel-slider .slide");

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.style.display = i === index ? "block" : "none";
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
}

// Initial display
showSlide(currentSlide);

// Change every 3 seconds
setInterval(nextSlide, 3000);
</script>

</body>
</html>

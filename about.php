<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CASCADINGSTYLES/about.css">
    <link rel="icon" href="Img/favicon.jpg">    
    <script src="JAVASCRIPT_SHMS/about.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
    <title>About | Smart Hostel Management System</title>
</head>
<body>
    <header class="nav-header">
        <nav class="navbar">
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
                        <a href="help_FAQs.php" style="color:black;">FAQ</a>
                        <a href="rules_regulations.php" style="color:black;">Rules & Regulations</a>
                        <a href="profile.php" style="color:black;">Profile</a>
                        <a href="logout.php" style="color:black;">Log out</a>
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

    <!-- ===== MOBILE MENU ===== -->
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

   <main class="about-main">

        <!-- Page Title -->
        <section class="about-section about-header-section">
            <h1 class="about-title">About the Smart Hostel Management System (SHMS)</h1>
            <p class="about-tagline">Empowering the University Hostel Experience through Technology.</p>
        </section>

        <!-- Mission and Vision -->
        <section class="about-section about-mission-vision">
            <h2 class="about-section-title">Our Mission and Vision</h2>

            <h3 class="about-subtitle">Mission</h3>
            <p class="about-text">To provide a streamlined, transparent, and efficient digital platform for managing all administrative, residential, and operational aspects of university hostels, fostering a comfortable and secure living environment for all students.</p>

            <h3 class="about-subtitle">Vision</h3>
            <p class="about-text">To be the leading standard for integrated university accommodation management, utilizing smart technology to enhance security, resource allocation, and student welfare.</p>
        </section>

        <!-- What We Do -->
        <section class="about-section about-what-we-do">
            <h2 class="about-section-title">What SHMS Does</h2>
            <p class="about-text">The Smart Hostel Management System is a comprehensive platform designed to connect students, hostel administration, and maintenance teams in one central location. Our primary functions include:</p>
            <ul class="about-list">
                <li><strong>Room Allocation & Booking:</strong> Managing the complex process of assigning rooms based on student criteria and availability.</li>
                <li><strong>Fee Management:</strong> Tracking and processing accommodation and utility payments securely and accurately.</li>
                <li><strong>Maintenance Reporting:</strong> Allowing students to log non-emergency and emergency maintenance issues directly, ensuring prompt service delivery.</li>
                <li><strong>Communication Hub:</strong> Serving as the official channel for the Administration to communicate notices, event schedules, and policy updates to residents.</li>
                <li><strong>Check-in/Check-out Automation:</strong> Streamlining the process of student move-in and move-out.</li>
            </ul>
        </section>

        <!-- Key Features for Students -->
        <section class="about-section about-features">
            <h2 class="about-section-title">Key Features for Students</h2>
            <p class="about-text">We believe in giving students control and easy access to services. Through SHMS, students can:</p>
            <ol class="about-ol">
                <li>View their current room and block details.</li>
                <li>Access a transparent record of all financial transactions related to hostel fees.</li>
                <li>Submit and track the status of maintenance requests in real-time.</li>
                <li>Receive personalized alerts and campus announcements.</li>
            </ol>
        </section>

        <!-- Our Technology -->
        <section class="about-section about-technology">
            <h2 class="about-section-title">Our Technology</h2>
            <p class="about-text">SHMS is built on a robust, scalable architecture to handle the data needs of a large academic institution. We prioritize data security and privacy, ensuring that all student information is encrypted and managed in compliance with university data protection policies.</p>
        </section>

        <!-- Contact for More Information -->
        <section class="about-section about-contact">
            <h2 class="about-section-title">Connect With Us</h2>
            <p class="about-text">The SHMS is managed by the University Housing and IT Departments.</p>
            <p class="about-text"><strong>General Inquiries:</strong> itssupport.smart@gmail.com</p>
            <p class="about-text"><strong>Technical Support:</strong> itssupport.smart@gmail.com</p>
        </section>

        <section class="about-section about-footer-note">
            <p><small>A product of the University Administration's commitment to modernization and student welfare.</small></p>
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
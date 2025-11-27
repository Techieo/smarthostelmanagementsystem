<?php
session_start();
include("db_connect.php");

// Redirect to login page if NOT logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['student_id']; // get logged-in student's ID

// Fetch student info
$stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
if (!$student) {
    $student = []; // ensure it's an array
}

// Initialize messages
$personalSuccess = '';
$academicSuccess = '';
$contactSuccess = '';
$emergencySuccess = '';
$passwordMessage = '';

// ---------- Personal Details ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_update_personal'])) {
    $programme = $_POST['programme'] ?? '';
    $nat_id = $_POST['nat_id'] ?? '';
    $dob = $_POST['date_of_birth'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $nationality = $_POST['nationality'] ?? '';
    $medical_info = $_POST['medical_info'] ?? '';

    $stmtUpdate = $conn->prepare("UPDATE students SET programme=?, nat_id=?, date_of_birth=?, gender=?, nationality=?, medical_info=? WHERE student_id=?");
    $stmtUpdate->bind_param("ssssssi", $programme, $nat_id, $dob, $gender, $nationality, $medical_info, $userId);
    $stmtUpdate->execute();

    $personalSuccess = "Personal Details updated successfully!";
    $student = $conn->query("SELECT * FROM students WHERE student_id = $userId")->fetch_assoc();
}

// ---------- Academic Details ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_update_academic'])) {
    $kcse_year = $_POST['kcse_year'] ?? '';
    $kcse_index = $_POST['kcse_index'] ?? '';

    $stmtUpdate = $conn->prepare("UPDATE students SET kcse_year=?, kcse_index=? WHERE student_id=?");
    $stmtUpdate->bind_param("isi", $kcse_year, $kcse_index, $userId);
    $stmtUpdate->execute();

    $academicSuccess = "Academic Details updated successfully!";
    $student = $conn->query("SELECT * FROM students WHERE student_id = $userId")->fetch_assoc();
}

// ---------- Contact Details ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_update_contact'])) {
    $personal_phone = $_POST['personal_phone'] ?? '';
    $home_address = $_POST['home_address'] ?? '';

    $stmtUpdate = $conn->prepare("UPDATE students SET personal_phone=?, home_address=? WHERE student_id=?");
    $stmtUpdate->bind_param("ssi", $personal_phone, $home_address, $userId);
    $stmtUpdate->execute();

    $contactSuccess = "Contact Details updated successfully!";
    $student = $conn->query("SELECT * FROM students WHERE student_id = $userId")->fetch_assoc();
}

// ---------- Emergency Contact ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_update_emergency'])) {
    $ec_name = $_POST['ec_name'] ?? '';
    $ec_relationship = $_POST['ec_relationship'] ?? '';
    $ec_phone = $_POST['ec_phone'] ?? '';

    $stmtUpdate = $conn->prepare("UPDATE students SET ec_name=?, ec_relationship=?, ec_phone=? WHERE student_id=?");
    $stmtUpdate->bind_param("sssi", $ec_name, $ec_relationship, $ec_phone, $userId);
    $stmtUpdate->execute();

    $emergencySuccess = "Emergency Contact updated successfully!";
    $student = $conn->query("SELECT * FROM students WHERE student_id = $userId")->fetch_assoc();
}

// ---------- Change Password ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_change_password'])) {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    $stmtPwd = $conn->prepare("SELECT password FROM students WHERE student_id=?");
    $stmtPwd->bind_param("i", $userId);
    $stmtPwd->execute();
    $userPwd = $stmtPwd->get_result()->fetch_assoc();

    if (!$userPwd || !password_verify($current_password, $userPwd['password'])) {
        $passwordMessage = "Current password is incorrect!";
    } elseif ($new_password !== $confirm_password) {
        $passwordMessage = "New passwords do not match!";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmtUpdatePwd = $conn->prepare("UPDATE students SET password=? WHERE student_id=?");
        $stmtUpdatePwd->bind_param("si", $hashed_password, $userId);
        $stmtUpdatePwd->execute();
        $passwordMessage = "Password changed successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="JAVASCRIPT_SHMS/test.js" defer></script>
    <link rel="stylesheet" href="CASCADINGSTYLES/profile.css">
    <link rel="icon" href="Img/favicon.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Profile | Smart Hostel Management System</title>
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
<style>
    .whatsapp-float {
    position: fixed;
    bottom: 20px;
    left: 20px;
    z-index: 100;
    background-color: #25D366; /* WhatsApp green */
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    transition: transform 0.2s;
    font-size: 28px;
}

.whatsapp-float:hover {
    transform: scale(1.1);
    background-color: #128C7E; /* darker green on hover */
}

</style>

    <br>
    <!-- WhatsApp Floating Button using Font Awesome -->
    <!-- WhatsApp Floating Button using Font Awesome -->
    <a href="https://wa.me/254737074160" target="_blank" class="whatsapp-float" title="Chat with us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
<!-- MAIN -->
 <main>
    <section id="profile-dashboard">
        <h2 class="profile-title">Profile Settings</h2>

        <!-- Top Profile Photo -->
        <div id="profile-photo-wrapper">
            <figure id="photo-box">
                <!-- Form for upload -->
                <form id="profile-photo-form" enctype="multipart/form-data" style="display:inline;">
                    <img id="profile-photo" src="<?php echo htmlspecialchars($student['profile_photo'] ?? 'placeholder.jpg'); ?>" alt="Profile Photo">
                    <!-- Hidden file input -->
                    <input type="file" id="upload-input" name="profile_photo" accept="image/*" style="display:none;">
                    <!-- Upload button -->
                    <button type="button" id="upload-btn"><i class="fas fa-upload"></i></button>
                </form>
                <p id="upload-message" style="color:green; margin-top:5px;"></p>
                
            </figure>
        </div>

        <!-- Right Column (Form Area) -->
        <section id="profile-form-area">

            <!-- Personal Details Form -->
            <form id="update-personal-details-form" action="#personal-details" method="POST">
                <fieldset id="personal-details">
                    <legend><h3>Personal Details</h3></legend>

                    <label for="email">Email Address:</label>
                    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($student['personal_email'] ?? ''); ?>" readonly>

                    <label for="full-name">Full Name:</label>
                    <input type="text" id="full-name" name="full_name" value="<?php echo htmlspecialchars(($student['first_name'] ?? '') . ' ' . ($student['last_name'] ?? '')); ?>" readonly>

                    <label for="programme">Programme / Course:</label>
                    <input type="text" id="programme" name="programme" value="<?php echo htmlspecialchars($student['programme'] ?? ''); ?>" <?php if(!empty($student['programme'])) echo 'readonly'; ?>>

                    <label for="nat-id">National ID:</label>
                    <input type="text" id="nat-id" name="nat_id" value="<?php echo htmlspecialchars($student['nat_id'] ?? ''); ?>" <?php if(!empty($student['nat_id'])) echo 'readonly'; ?>>

                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="date_of_birth" value="<?php echo htmlspecialchars($student['date_of_birth'] ?? ''); ?>" <?php if(!empty($student['date_of_birth'])) echo 'readonly'; ?>>

                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" <?php if(!empty($student['gender'])) echo 'disabled'; ?>>
                        <option value="male" <?php if (($student['gender'] ?? '')=='male') echo 'selected'; ?>>Male</option>
                        <option value="female" <?php if (($student['gender'] ?? '')=='female') echo 'selected'; ?>>Female</option>
                        <option value="other" <?php if (($student['gender'] ?? '')=='other') echo 'selected'; ?>>Other</option>
                    </select>

                    <label for="nationality">Nationality:</label>
                    <select id="nationality" name="nationality">
                        <option value="kenyan" <?php if (($student['nationality'] ?? '')=='kenyan') echo 'selected'; ?>>Kenyan</option>
                        <option value="tanzanian" <?php if (($student['nationality'] ?? '')=='tanzanian') echo 'selected'; ?>>Tanzanian</option>
                        <option value="ugandan" <?php if (($student['nationality'] ?? '')=='ugandan') echo 'selected'; ?>>Ugandan</option>
                        <option value="other" <?php if (($student['nationality'] ?? '')=='other') echo 'selected'; ?>>Other</option>
                    </select>

                    <label for="medical-info">Medical Information / Allergies:</label>
                    <textarea id="medical-info" name="medical_info" rows="3"><?php echo htmlspecialchars($student['medical_info'] ?? ''); ?></textarea>

                    <button type="submit" name="submit_update_personal">Update Personal Details</button>
                    <?php if($personalSuccess) echo "<p style='color:green;'>{$personalSuccess}</p>"; ?>
                </fieldset>
            </form>

            <!-- Academic Details Form -->
            <form id="update-academic-form" action="#academic-details" method="POST">
                <fieldset id="academic-details">
                    <legend><h3>Academic Details</h3></legend>

                    <label for="kcse-year">KCSE Year:</label>
                    <input type="number" id="kcse-year" name="kcse_year" value="<?php echo htmlspecialchars($student['kcse_year'] ?? ''); ?>" <?php if(!empty($student['kcse_year'])) echo 'readonly'; ?>>

                    <label for="kcse-index">KCSE Index Number:</label>
                    <input type="text" id="kcse-index" name="kcse_index" value="<?php echo htmlspecialchars($student['kcse_index'] ?? ''); ?>" <?php if(!empty($student['kcse_index'])) echo 'readonly'; ?>>

                    <button type="submit" name="submit_update_academic">Update Academic Details</button>
                    <?php if($academicSuccess) echo "<p style='color:green;'>{$academicSuccess}</p>"; ?>
                </fieldset>
            </form>

            <!-- Contact Details Form -->
            <form id="update-contact-form" action="#contact-details" method="POST">
                <fieldset id="contact-details">
                    <legend><h3>Contact Details</h3></legend>

                    <label for="personal-email">Personal Email:</label>
                    <input type="email" id="personal-email" name="personal_email" value="<?php echo htmlspecialchars($student['personal_email'] ?? ''); ?>" readonly>

                    <label for="phone">Personal Phone:</label>
                    <input type="tel" id="phone" name="personal_phone" value="<?php echo htmlspecialchars($student['personal_phone'] ?? ''); ?>">

                    <label for="address">Home Address:</label>
                    <textarea id="address" name="home_address" rows="3"><?php echo htmlspecialchars($student['home_address'] ?? ''); ?></textarea>

                    <button type="submit" name="submit_update_contact">Update Contact Details</button>
                    <?php if($contactSuccess) echo "<p style='color:green;'>{$contactSuccess}</p>"; ?>
                </fieldset>
            </form>

            <!-- Emergency Contact Form -->
            <form id="update-emergency-form" action="#emergency-contact" method="POST">
                <fieldset id="emergency-contact">
                    <legend><h3>Emergency Contact</h3></legend>

                    <label for="ec-name">Contact Person Full Name:</label>
                    <input type="text" id="ec-name" name="ec_name" value="<?php echo htmlspecialchars($student['ec_name'] ?? ''); ?>" placeholder="Enter full name">

                    <label for="ec-relationship">Relationship:</label>
                    <input type="text" id="ec-relationship" name="ec_relationship" value="<?php echo htmlspecialchars($student['ec_relationship'] ?? ''); ?>" placeholder="e.g., Parent, Sibling">

                    <label for="ec-phone">Contact Phone:</label>
                    <input type="tel" id="ec-phone" name="ec_phone" value="<?php echo htmlspecialchars($student['ec_phone'] ?? ''); ?>" placeholder="Enter phone number">

                    <button type="submit" name="submit_update_emergency">Update Emergency Details</button>
                    <?php if($emergencySuccess) echo "<p style='color:green;'>{$emergencySuccess}</p>"; ?>
                </fieldset>
            </form>

            <!-- Change Password Form -->
            <form method="POST" action="#change-password">
                <fieldset id="change-password">
                    <legend>Change Password</legend>
                    Current Password: <input type="password" name="current_password"><br>
                    New Password: <input type="password" name="new_password"><br>
                    Confirm Password: <input type="password" name="confirm_password"><br>
                    <button type="submit" name="submit_change_password">Change Password</button>
                    <?php if($passwordMessage) echo "<p style='color:green;'>$passwordMessage</p>"; ?>
                </fieldset>
            </form>

        </section>
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

<?php
session_start();
include 'db_connect.php';

$student_id = $_SESSION['user_id'] ?? null;

$first_name = '';
$last_name  = '';
$email      = '';
$phone      = '';
$room_no    = '';
$status_msg = '';

// =========================
// FETCH STUDENT INFORMATION
// =========================
if ($student_id) {
    // Fetch student info
    $stmt = $conn->prepare("
        SELECT first_name, last_name, personal_email, personal_phone 
        FROM students 
        WHERE id = ?
    ");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->bind_result($first_name, $last_name, $email, $phone);
    $stmt->fetch();
    $stmt->close();

    // Fetch latest booked room
    $stmt_room = $conn->prepare("
        SELECT r.room_number 
        FROM bookings b 
        JOIN rooms r ON b.room_id = r.room_id 
        WHERE b.user_id = ? 
        ORDER BY b.booking_date DESC 
        LIMIT 1
    ");
    $stmt_room->bind_param("i", $student_id);
    $stmt_room->execute();
    $stmt_room->bind_result($room_no);
    $stmt_room->fetch();
    $stmt_room->close();
}

// =========================
// HANDLE FORM SUBMISSION
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Honeypot spam check
    if (!empty($_POST['website'])) die("Spam detected!");

    // -------------------------
    // UPDATE PHONE NUMBER
    // -------------------------
    if (isset($_POST['update_phone'])) {
        $phone_update = trim($_POST['phone'] ?? '');

        if ($phone_update && $student_id) {
            $stmt_update = $conn->prepare("
                UPDATE students 
                SET personal_phone = ? 
                WHERE id = ?
            ");
            $stmt_update->bind_param("si", $phone_update, $student_id);

            if ($stmt_update->execute()) {
                $status_msg = "✅ Phone number updated successfully!";
                $phone = $phone_update;
            } else {
                $status_msg = "Error updating phone: " . $stmt_update->error;
            }
            $stmt_update->close();

        } else {
            $status_msg = "Please enter a phone number.";
        }
    }

    // -------------------------
    // SUBMIT COMPLAINT
    // -------------------------
    if (isset($_POST['submit_complaint'])) {
        $category      = $_POST['category'] ?? '';
        $priority      = $_POST['priority'] ?? '';
        $incident_date = $_POST['incident_date'] ?? '';
        $title         = $_POST['title'] ?? '';
        $description   = $_POST['description'] ?? '';
        $is_anonymous  = isset($_POST['anonymous']) ? 1 : 0;

        // Handle attachments
        $uploaded_files = [];

        if (!empty($_FILES['attachments']['name'][0])) {
            $files = $_FILES['attachments'];

            for ($i = 0; $i < count($files['name']); $i++) {
                $filename    = basename($files['name'][$i]);
                $target_dir  = "uploads/complaints/";

                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $target_file = $target_dir . time() . "_" . $filename;

                if (move_uploaded_file($files['tmp_name'][$i], $target_file)) {
                    $uploaded_files[] = $target_file;
                }
            }
        }

        $attachments_json = json_encode($uploaded_files);

        // Insert complaint
        $stmt_insert = $conn->prepare("
            INSERT INTO complaints 
            (full_name, reg_no, email, phone, room_no, category, priority, incident_date, 
            title, description, attachments, is_anonymous)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $full_name_safe  = htmlspecialchars($first_name . ' ' . $last_name);
        $email_safe      = htmlspecialchars($email);
        $phone_safe      = htmlspecialchars($phone);
        $room_safe       = htmlspecialchars($room_no);
        $title_safe      = htmlspecialchars($title);
        $description_safe = htmlspecialchars($description);
        $category_safe   = htmlspecialchars($category);
        $priority_safe   = htmlspecialchars($priority);
        $reg_no          = ""; // optional

        $stmt_insert->bind_param(
            "sssssssssssi",
            $full_name_safe,
            $reg_no,
            $email_safe,
            $phone_safe,
            $room_safe,
            $category_safe,
            $priority_safe,
            $incident_date,
            $title_safe,
            $description_safe,
            $attachments_json,
            $is_anonymous
        );

        if ($stmt_insert->execute()) {
            $status_msg = "Complaint submitted successfully!";
        } else {
            $status_msg = "Error submitting complaint: " . $stmt_insert->error;
        }

        $stmt_insert->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CASCADINGSTYLES/complaint.css">
    <link rel="icon" href="Img/favicon.jpg">
    <script src="JAVASCRIPT_SHMS/submit_complaint_student.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint | Smart Hostel Management System</title>
</head>

<body>

<!-- NAVBAR -->
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

<!-- MOBILE MENU -->
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

<!-- WHATSAPP BUTTON -->
<style>
    .whatsapp-float {
        position: fixed;
        bottom: 20px;
        left: 20px;
        z-index: 100;
        background-color: #25D366;
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
        background-color: #128C7E;
    }
</style>

<a href="https://wa.me/254737074160" target="_blank" class="whatsapp-float">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- MAIN CONTENT -->
<main>
    <section id="complaint-submission">

        <h2>Submit a Complaint / Maintenance Request</h2>
        <p>Please use this form to report any issues.</p>

        <p><strong>Attachment Note:</strong> JPG, PNG, GIF, PDF. Max 5MB each.</p>

        <form id="complaint-form" action="" method="POST" enctype="multipart/form-data">

            <input type="text" name="website" style="display:none;" autocomplete="off">

            <!-- PERSONAL DETAILS -->
            <fieldset>
                <legend>Your Details</legend>

                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" value="<?php echo htmlspecialchars($first_name . ' ' . $last_name); ?>" readonly>

                <label for="email">Email:</label>
                <input type="email" id="email" value="<?php echo htmlspecialchars($email); ?>" readonly>

                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">

                <label for="room_no">Room No:</label>
                <input type="text" id="room_no" value="<?php echo htmlspecialchars($room_no); ?>" readonly>
            </fieldset>

            <button type="submit" name="update_phone" class="update-btn">Update Phone</button>

            <!-- COMPLAINT DETAILS -->
            <fieldset>
                <legend>Complaint Details</legend>

                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="">-- Select --</option>
                    <option value="accommodation">Accommodation</option>
                    <option value="payments">Payments</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="security">Security</option>
                    <option value="conduct">Student Conduct</option>
                    <option value="other">Other</option>
                </select>

                <label>Priority:</label>
                <div>
                    <input type="radio" id="low" name="priority" value="low" required>
                    <label for="low">Low</label>

                    <input type="radio" id="medium" name="priority" value="medium">
                    <label for="medium">Medium</label>

                    <input type="radio" id="high" name="priority" value="high">
                    <label for="high">High</label>
                </div>

                <label for="incident_date">Date of Incident:</label>
                <input type="date" id="incident_date" name="incident_date" required>

                <label for="title">Title:</label>
                <input type="text" id="title" name="title" maxlength="100" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="6" minlength="20" required></textarea>

                <label for="attachments">Attachments:</label>
                <input type="file" name="attachments[]" multiple accept=".jpg,.jpeg,.png,.gif,.pdf">

                <label>
                    <input type="checkbox" name="anonymous"> Submit Anonymously
                </label>
            </fieldset>

            <button type="submit" name="submit_complaint" class="submit-btn">
                Submit Complaint
            </button>
        </form>

        <?php if(!empty($status_msg)): ?>
            <div class="status-msg"><?php echo htmlspecialchars($status_msg); ?></div>
        <?php endif; ?>

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
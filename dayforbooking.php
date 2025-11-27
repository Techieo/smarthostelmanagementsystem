<?php
session_start();
include 'db_connect.php';

// Ensure student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch student info
$student_sql = "SELECT first_name, last_name, personal_email, personal_phone 
                FROM students 
                WHERE student_id = $student_id LIMIT 1";
$student_result = $conn->query($student_sql);

if (!$student_result || $student_result->num_rows == 0) {
    echo "User not found.";
    exit();
}

$student = $student_result->fetch_assoc();
$fullname = $student['first_name'] . ' ' . $student['last_name'];
$email    = $student['personal_email'];
$phone    = $student['personal_phone'];

// Ensure room_id is provided
if (!isset($_GET['room_id'])) {
    header("Location: book_room.php");
    exit();
}

$room_id    = $_GET['room_id'];
$room_image = $_GET['room_image'] ?? "images/rooms/default.jpg";

// Fetch room details
$sql    = "SELECT * FROM rooms WHERE room_id = '$room_id' LIMIT 1";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo "Room not found.";
    exit();
}

$room = $result->fetch_assoc();

// Fetch the latest booking due dates
$due_result = $conn->query("SELECT * FROM booking_due_dates ORDER BY id DESC LIMIT 1");
$due_info   = $due_result ? $due_result->fetch_assoc() : null;

// Calculate cancellation date (2 days after booking open date)
$cancel_before = $due_info ? date('F d, Y', strtotime($due_info['open_date'] . ' +2 days')) : 'N/A';

$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullname_post  = trim($_POST['fullname'] ?? '');
    $phone_post     = trim($_POST['phone'] ?? $phone);
    $country_post   = trim($_POST['country'] ?? '');
    $payment_phone  = trim($_POST['payment_phone'] ?? '');
    $booking_date   = trim($_POST['booking_date'] ?? '');
    $amount         = $room['price']; // Room price for payment

    // Validation
    if (empty($fullname_post)) $errors['fullname'] = "The full name field is required.";
    if (empty($phone_post)) $errors['phone'] = "The phone number field is required.";
    if (empty($country_post)) $errors['country'] = "The country field is required.";
    if (empty($payment_phone)) $errors['payment_phone'] = "The payment phone field is required.";
    if (empty($booking_date)) $errors['booking_date'] = "Please select a booking date.";

    if (!empty($phone_post) && !preg_match("/^\+?[0-9]{6,15}$/", $phone_post))
        $errors['phone'] = "Invalid phone number format.";
    if (!empty($payment_phone) && !preg_match("/^\+?[0-9]{6,15}$/", $payment_phone))
        $errors['payment_phone'] = "Invalid phone number format.";

    if ($due_info && !empty($booking_date)) {
        if ($booking_date < $due_info['open_date'] || $booking_date > $due_info['close_date']) {
            $errors['booking_date'] = "Selected date is outside the allowed booking period.";
        }
    }

    if (empty($errors)) {
        // ✅ Insert into pending_bookings
        $checkoutRequestID = uniqid(); // Unique identifier for STK push

        $stmt = $conn->prepare("INSERT INTO pending_bookings 
            (student_id, room_id, fullname, phone, country, payment_phone, booking_date, amount, checkout_request_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "iissssdss",
            $student_id,
            $room_id,
            $fullname_post,
            $phone_post,
            $country_post,
            $payment_phone,
            $booking_date,
            $amount,
            $checkoutRequestID
        );
        $stmt->execute();

        // Store checkout_request_id in session for callback matching
        $_SESSION['checkout_request_id'] = $checkoutRequestID;

        // Redirect to M-Pesa STK push handler
        header("Location: mpesa_stk_push.php?checkout_request_id=$checkoutRequestID");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Room Booking | Smart Hostel Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="Img/favicon.jpg"/> 
    <link rel="stylesheet" href="CASCADINGSTYLES/dayforbooking.css"/>
    <script src="JAVASCRIPT_SHMS/daysforbooking.js" defer></script>  
</head>
<body>
<header>
  <nav>
    <div class="logo"><img src="Img/favicon.jpg" alt="SHMS Logo"></div>
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
      <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
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
    <li><a href="profile.php">Profile</a></li>
    <li><a href="logout.php">Log out</a></li>
  </ul>
</div>

<div class="booking-container">
  <div class="left">
    <img src="<?php echo $room_image; ?>" alt="Room Image">
    <h2>Room <?php echo $room['room_number']; ?></h2>
    <p><strong>Type:</strong> <?php echo $room['room_type']; ?></p>
    <p><strong>Capacity:</strong> <?php echo $room['capacity']; ?> People</p>
    <p><strong>Price:</strong> KSh <?php echo number_format($room['price']); ?> / month</p>
  </div>

  <div class="right">
    <h3>Student Information</h3>
    <?php if (!empty($errors['general'])) echo "<div class='error-message'>{$errors['general']}</div>"; ?>
    <form method="POST">
      <input type="text" name="fullname" placeholder="Full Name" value="<?php echo htmlspecialchars($_POST['fullname'] ?? $fullname); ?>">
      <?php if (!empty($errors['fullname'])) echo "<div class='error-message'>{$errors['fullname']}</div>"; ?>

      <input type="email" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($email); ?>" readonly>

      <select name="country">
        <option value="">Select Country</option>
        <option value="Kenya" <?php if(($_POST['country'] ?? '') == 'Kenya') echo 'selected'; ?>>Kenya</option>
        <option value="Uganda" <?php if(($_POST['country'] ?? '') == 'Uganda') echo 'selected'; ?>>Uganda</option>
        <option value="Tanzania" <?php if(($_POST['country'] ?? '') == 'Tanzania') echo 'selected'; ?>>Tanzania</option>
      </select>
      <?php if (!empty($errors['country'])) echo "<div class='error-message'>{$errors['country']}</div>"; ?>

      <?php if($due_info): ?>
        <h3>Booking Schedule</h3>
        <div class="booking-due">
            <strong>Booking Opened:</strong> <?php echo date('F d, Y', strtotime($due_info['open_date'])) . ' at ' . date('h:i A', strtotime($due_info['open_time'])); ?><br>
            <strong>Booking Closes:</strong> <?php echo date('F d, Y', strtotime($due_info['close_date'])) . ' at ' . date('h:i A', strtotime($due_info['close_time'])); ?>
        </div>
      <?php endif; ?>

      <br>
      <label for="booking_date">Booking Date:</label>
      <input type="date" name="booking_date" 
             value="<?php echo htmlspecialchars($_POST['booking_date'] ?? ''); ?>" 
             <?php if($due_info): ?>
               min="<?php echo $due_info['open_date']; ?>" 
               max="<?php echo $due_info['close_date']; ?>"
             <?php endif; ?>
             required>
      <?php if (!empty($errors['booking_date'])) echo "<div class='error-message'>{$errors['booking_date']}</div>"; ?>

      <h3>Payment Information</h3>
      <input type="text" name="payment_phone" placeholder="Enter your Safaricom number" value="<?php echo htmlspecialchars($_POST['payment_phone'] ?? ''); ?>" required>
      <?php if (!empty($errors['payment_phone'])) echo "<div class='error-message'>{$errors['payment_phone']}</div>"; ?>

      <input type="hidden" name="payment_method" value="M-Pesa">
      <p>Payment Method: <strong>Safaricom M-Pesa</strong></p>

      <div class="cancellation-policy">
        <strong>Cancellation Policy:</strong>
        <p>You may cancel for no charge before <strong><?php echo $cancel_before; ?></strong>. After this time, your prepayment is non-refundable.</p>
      </div>

      <button type="submit">Book Now</button>
    </form>
  </div>
</div>
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
</div>
</body>
</html>



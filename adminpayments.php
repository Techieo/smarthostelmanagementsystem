<?php
include("db_connect.php"); // include the correct DB connection

// Fetch payments with student names and room numbers
$sql = "SELECT p.payment_id, p.amount, p.status, p.payment_date, 
               b.room_id, 
               s.first_name, s.last_name
        FROM payments p
        JOIN bookings b ON p.booking_id = b.booking_id
        JOIN students s ON b.user_id = s.student_id
        ORDER BY p.payment_date DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="CASCADINGSTYLES/adminpayments.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<link rel="icon" href="Img/favicon.jpg">
<title>Payments Management | Smart Hostel Management System</title>
</head>
<body>

<header>
  <nav>
    <div class="icons-left">
      <div class="hamburger" id="hamburgerAdmin">
        <span></span><span></span><span></span>
      </div>
    </div>

    <div class="logo">
      <img src="Img/favicon.jpg" alt="SHMS Logo">
    </div>

    

    <ul class="nav-links">
      <li><a href="dashboardadmin.php">Dashboard</a></li>
      <li><a href="adminmanagerooms.php">Manage Rooms</a></li>
      <li><a href="adminmanagestudents.php">Manage Students</a></li>
      <li><a href="adminpayments.php">Payments</a></li>
      <li><a href="admin_complaints.php">Complaints</a></li>
      <li><a href="logout.php">Log out</a></li>
    </ul>
    <div class="icons-right">
      <i class="fa-regular fa-bell"></i>
    </div>
  </nav>
</header>

<div class="mobile-menu" id="mobileMenuAdmin">
  <ul>
    <li><a href="dashboardadmin.php">Dashboard</a></li>
    <li><a href="adminmanagerooms.php">Manage Rooms</a></li>
    <li><a href="adminmanagestudents.php">Manage Students</a></li>
    <li><a href="adminpayments.php">Payments</a></li>
    <li><a href="admin_complaints.php">Complaints</a></li>
    <li><a href="logout.php">Log out</a></li>
  </ul>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.getElementById("hamburgerAdmin");
  const mobileMenu = document.getElementById("mobileMenuAdmin");

  hamburger.addEventListener("click", (event) => {
    event.stopPropagation();
    mobileMenu.classList.toggle("active");
  });

  // Close mobile menu when clicking outside
  document.addEventListener("click", (event) => {
    if (!mobileMenu.contains(event.target) && !hamburger.contains(event.target)) {
      mobileMenu.classList.remove("active");
    }
  });

  // Close menu when clicking a link
  mobileMenu.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", () => {
      mobileMenu.classList.remove("active");
    });
  });
});

</script>

<main style="padding:20px;">
<h2>Payments Management</h2>
<br>

<table class="admin-payments-table" border="1" cellspacing="0" cellpadding="5">
<thead>
<tr>
    <th>Transaction ID</th>
    <th>Student Name</th>
    <th>Room Number</th>
    <th>Amount Paid (KES)</th>
    <th>Payment Date</th>
    <th>Payment Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $transactionID = "TRX-" . $row['payment_id'];
        $studentName = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
        $roomNumber = htmlspecialchars($row['room_id']);
        $amount = number_format($row['amount'], 2);
        $status = ucfirst($row['status']);
        $paymentDate = $row['payment_date'];

        echo "<tr>
                <td>{$transactionID}</td>
                <td>{$studentName}</td>
                <td>{$roomNumber}</td>
                <td>{$amount}</td>
                <td>{$paymentDate}</td>
                <td data-status='{$status}'>" . ($status=='Paid' ? '<i class=\"fas fa-check-circle\"></i>' : '<i class=\"fas fa-hourglass-half\"></i>') . " {$status}</td>
                <td><a href='payment_view.php?id={$row['payment_id']}' class='admin-payment-action'><i class='fas fa-eye'></i> View</a></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='7'>No payments found.</td></tr>";
}
$conn->close();
?>
</tbody>
</table>
</main>

</body>
</html>

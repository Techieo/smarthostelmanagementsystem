<?php
include 'db_connect.php';

// Total rooms
$totalRooms = $conn->query("SELECT COUNT(*) AS total_rooms FROM rooms")->fetch_assoc()['total_rooms'];

// Occupied rooms (status 'booked')
$occupiedRooms = $conn->query("SELECT COUNT(*) AS occupied_rooms FROM rooms WHERE status='booked'")->fetch_assoc()['occupied_rooms'];

// Vacant rooms (status 'available')
$vacantRooms = $conn->query("SELECT COUNT(*) AS vacant_rooms FROM rooms WHERE status='available'")->fetch_assoc()['vacant_rooms'];

// Registered students
$registeredStudents = $conn->query("SELECT COUNT(*) AS total_students FROM users")->fetch_assoc()['total_students'];

// Total payments (paid)
$totalPayments = $conn->query("SELECT SUM(amount) AS total_payments FROM payments WHERE status='paid'")->fetch_assoc()['total_payments'] ?? 0;

// Pending payments
$pendingPayments = $conn->query("SELECT SUM(amount) AS pending_payments FROM payments WHERE status='pending'")->fetch_assoc()['pending_payments'] ?? 0;

// Recent Activities (latest 5 payments)
$recentActivitiesResult = $conn->query("
    SELECT 
        p.amount, 
        p.status, 
        r.room_number, 
        u.first_name, 
        u.last_name
    FROM payments p
    JOIN bookings b ON p.booking_id = b.booking_id
    JOIN users u ON b.user_id = u.id
    JOIN rooms r ON b.room_id = r.room_id
    ORDER BY p.payment_date DESC
    LIMIT 5
");

$recentActivities = [];
if($recentActivitiesResult) {
    while($row = $recentActivitiesResult->fetch_assoc()) {
        $recentActivities[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CASCADINGSTYLES/admindashboard.css">
    <script src="JAVASCRIPT_SHMS/admin_dashboard.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="icon" href="Img/favicon.jpg">
    <title>Admin Dashboard | Smart Hostel Management System</title>
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
      <li><a href="admin_payments.php">Payments</a></li>
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
    <li><a href="admin_payments.php">Payments</a></li>
    <li><a href="admin_complaints.php">Complaints</a></li>
    <li><a href="logout.php">Log out</a></li>
  </ul>
</div>

<main class="admin-dashboard">
    <h2 class="admin-dashboard-title">Admin Dashboard Overview</h2>

    <!-- System Summary Section -->
    <section class="admin-summary">
        <h3 class="admin-section-title">System Summary</h3>
        <div class="admin-summary-items">
            <article class="admin-summary-item">
                <i class="fas fa-door-closed fa-2x admin-summary-icon"></i>
                <h4>Total Rooms</h4>
                <p><?= $totalRooms ?></p>
            </article>
            <article class="admin-summary-item">
                <i class="fas fa-bed fa-2x admin-summary-icon"></i>
                <h4>Occupied Rooms</h4>
                <p><?= $occupiedRooms ?></p>
            </article>
            <article class="admin-summary-item">
                <i class="fas fa-door-open fa-2x admin-summary-icon"></i>
                <h4>Vacant Rooms</h4>
                <p><?= $vacantRooms ?></p>
            </article>
            <article class="admin-summary-item">
                <i class="fas fa-user-graduate fa-2x admin-summary-icon"></i>
                <h4>Registered Students</h4>
                <p><?= $registeredStudents ?></p>
            </article>
            <article class="admin-summary-item">
                <i class="fas fa-money-bill-wave fa-2x admin-summary-icon"></i>
                <h4>Total Payments</h4>
                <p>KSh <?= number_format($totalPayments, 2) ?></p>
            </article>
            <article class="admin-summary-item">
                <i class="fas fa-hourglass-half fa-2x admin-summary-icon"></i>
                <h4>Pending Payments</h4>
                <p>KSh <?= number_format($pendingPayments, 2) ?></p>
            </article>
        </div>
    </section>

    <!-- Recent Activities Section -->
    <section class="admin-activities">
        <h3 class="admin-section-title">Recent Activities</h3>
        <ul class="admin-activities-list">
            <?php if (!empty($recentActivities)): ?>
                <?php foreach ($recentActivities as $activity): ?>
                    <li>
                        <i class="fas fa-hand-holding-usd"></i> 
                        Payment of KSh <?= number_format($activity['amount'],2) ?> received from <?= htmlspecialchars($activity['first_name'].' '.$activity['last_name']) ?> for Room <?= $activity['room_number'] ?> (<?= ucfirst($activity['status']) ?>)
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No recent activities yet.</li>
            <?php endif; ?>
        </ul>
    </section>
</main>
</body>
</html>

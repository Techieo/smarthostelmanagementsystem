<?php
include 'db_connect.php';

// -------------------- DELETE ROOM --------------------
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $room_id = intval($_GET['id']);
    $room = $conn->query("SELECT image FROM rooms WHERE room_id=$room_id")->fetch_assoc();

    $conn->query("DELETE FROM rooms WHERE room_id=$room_id");

    if ($room && $room['image'] !== 'default.jpg' && file_exists("images/rooms/".$room['image'])) {
        unlink("images/rooms/".$room['image']);
    }

    header("Location: adminmanagerooms.php");
    exit;
}

// -------------------- BOOKING SCHEDULE --------------------
$due_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['open_date'])) {
    $open_date  = $_POST['open_date'];
    $open_time  = $_POST['open_time'];
    $close_date = $_POST['close_date'];
    $close_time = $_POST['close_time'];

    $open_datetime  = "$open_date $open_time";
    $close_datetime = "$close_date $close_time";

    if (strtotime($close_datetime) <= strtotime($open_datetime)) {
        $due_message = "<div class='flash-error'>Error: Closing date/time must be AFTER opening date/time.</div>";
    } else {
        $check = $conn->query("SELECT id FROM booking_due_dates LIMIT 1");
        if ($check->num_rows > 0) {
            $row = $check->fetch_assoc();
            $id = $row['id'];

            $stmt = $conn->prepare("UPDATE booking_due_dates SET open_date=?, open_time=?, close_date=?, close_time=? WHERE id=?");
            $stmt->bind_param("ssssi", $open_date, $open_time, $close_date, $close_time, $id);
            $stmt->execute();
            $stmt->close();

            $due_message = "<div class='flash-success'>Booking schedule updated successfully.</div>";
        } else {
            $stmt = $conn->prepare("INSERT INTO booking_due_dates (open_date, open_time, close_date, close_time) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $open_date, $open_time, $close_date, $close_time);
            $stmt->execute();
            $stmt->close();

            $due_message = "<div class='flash-success'>Booking schedule created successfully.</div>";
        }
    }
}

// -------------------- FETCH ROOMS --------------------
$rooms = $conn->query("SELECT * FROM rooms ORDER BY room_id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="CASCADINGSTYLES/managerooms.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<link rel="icon" href="Img/favicon.jpg">
<title>Manage Rooms - Smart Hostel Management System (SHMS)</title>
<style>
/* Modal Styles */
.modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background: rgba(0,0,0,0.6);}
.modal-content { background-color: #fff; margin: 15% auto; padding: 20px; border-radius: 10px; max-width: 400px; text-align: center;}
.modal-content button { margin: 10px; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;}
.btn-cancel { background: #ccc; color: #000; }
.btn-confirm { background: #d9534f; color: #fff; }

/* Flash messages */
.flash-success { background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border-radius: 5px; }
.flash-error { background: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border-radius: 5px; }
</style>
</head>
<body>
<header>
<nav>
    <div class="logo"><img src="Img/favicon.jpg" alt="SHMS Logo"></div>
    <ul class="nav-links">
      <li><a href="dashboardadmin.php">Dashboard</a></li>
      <li><a href="adminmanagerooms.php">Manage Rooms</a></li>
      <li><a href="adminmanagestudents.php">Manage Students</a></li>
      <li><a href="adminpayments.php">Payments</a></li>
      <li><a href="admin_complaints.php">Complaints</a></li>
      <li><a href="logout.php">Log out</a></li>
    </ul>
    <div class="icons-left">
      <div class="hamburger" id="hamburgerAdmin"><span></span><span></span><span></span></div>
    </div>
    <div class="icons-right"><i class="fa-regular fa-bell"></i></div>
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
  hamburger.addEventListener("click", (event) => { event.stopPropagation(); mobileMenu.classList.toggle("active"); });
  document.addEventListener("click", (event) => {
    if (!mobileMenu.contains(event.target) && !hamburger.contains(event.target)) { mobileMenu.classList.remove("active"); }
  });
  mobileMenu.querySelectorAll("a").forEach(link => { link.addEventListener("click", () => { mobileMenu.classList.remove("active"); }); });
});
</script>

<main class="admin-rooms">
    <h2 class="admin-rooms-title">Manage Hostel Rooms</h2>

    <section class="admin-room-actions">
        <a href="add_room.php" class="admin-add-room-btn"><i class="fas fa-plus-circle"></i> Add New Room</a>
    </section>

    <section class="admin-room-list">
        <h3 class="admin-section-title">List of Hostel Rooms</h3>
        <table class="admin-rooms-table">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Capacity</th>
                    <th>Category</th>
                    <th>Price (KSh)</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($room = $rooms->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($room['room_number']) ?></td>
                    <td><?= htmlspecialchars($room['room_type']) ?></td>
                    <td><?= htmlspecialchars($room['capacity']) ?></td>
                    <td><?= htmlspecialchars($room['type']) ?></td>
                    <td><?= number_format($room['price'], 2) ?></td>
                    <td><?= ucfirst($room['status']) ?></td>
                    <td><img src="images/rooms/<?= $room['image'] ?>" alt="<?= $room['room_number'] ?>" width="50"></td>
                    <td>
                        <a href="add_room.php?id=<?= $room['room_id'] ?>" class="admin-room-action"><i class="fas fa-edit"></i> Edit</a>
                        |
                        <button class="admin-room-action delete" data-id="<?= $room['room_id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</main>

<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to delete this room?</p>
        <button class="btn-cancel">Cancel</button>
        <button class="btn-confirm">Delete</button>
    </div>
</div>

<script>
const modal = document.getElementById('deleteModal');
let deleteId = null;
document.querySelectorAll('.admin-room-action.delete').forEach(btn => {
    btn.addEventListener('click', () => { deleteId = btn.getAttribute('data-id'); modal.style.display = 'block'; });
});
modal.querySelector('.btn-cancel').addEventListener('click', () => { modal.style.display = 'none'; deleteId = null; });
modal.querySelector('.btn-confirm').addEventListener('click', () => { if(deleteId){ window.location.href = `adminmanagerooms.php?action=delete&id=${deleteId}`; }});
window.addEventListener('click', (e) => { if(e.target == modal){ modal.style.display = 'none'; deleteId = null; } });
</script>

<!-- Booking Schedule Form -->
<section class="shms-due-dates-container">
    <h3 class="shms-due-dates-title">Set Hostel Booking Schedule</h3>

    <form method="POST" class="shms-due-dates-form">
        <div class="shms-due-group">
            <h4>Booking Opens</h4>
            <label>Open Date:</label>
            <input type="date" name="open_date" required>
            <label>Open Time:</label>
            <input type="time" name="open_time" required>
        </div>

        <div class="shms-due-group">
            <h4>Booking Closes</h4>
            <label>Close Date:</label>
            <input type="date" name="close_date" required>
            <label>Close Time:</label>
            <input type="time" name="close_time" required>
        </div>

        <!-- Display message here -->
        <?= $due_message ?>

        <button type="submit" class="shms-due-btn">Save Booking Schedule</button>
    </form>
</section>

</body>
</html>

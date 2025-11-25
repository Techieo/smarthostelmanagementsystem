<?php
include 'db_connect.php';
$errors = [];
$success = '';
$room_number = $room_type = $capacity = $type = $price = $status = '';
$image = 'default.jpg';

// Check if editing
if (isset($_GET['id'])) {
    $room_id = intval($_GET['id']);
    $room = $conn->query("SELECT * FROM rooms WHERE room_id=$room_id")->fetch_assoc();
    if ($room) {
        $room_number = $room['room_number'];
        $room_type   = $room['room_type'];
        $capacity    = $room['capacity'];
        $type        = $room['type'];
        $price       = $room['price'];
        $status      = $room['status'];
        $image       = $room['image'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = $_POST['room_number'];
    $room_type   = $_POST['room_type'];
    $capacity    = $_POST['capacity'];
    $type        = $_POST['type'];
    $price       = $_POST['price'];
    $status      = $_POST['status'];

    // Image upload
    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = "images/rooms/" . $image;
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $errors[] = "Failed to upload image.";
        }
    }

    if (empty($errors)) {
        if (isset($_POST['room_id'])) {
            // Update existing room
            $room_id = intval($_POST['room_id']);
            $stmt = $conn->prepare("UPDATE rooms SET room_number=?, room_type=?, capacity=?, type=?, price=?, status=?, image=? WHERE room_id=?");
            $stmt->bind_param("ssissssi", $room_number, $room_type, $capacity, $type, $price, $status, $image, $room_id);
            if ($stmt->execute()) {
                $success = "Room updated successfully!";
            } else {
                $errors[] = "Database error: " . $stmt->error;
            }
        } else {
            // Add new room
            $stmt = $conn->prepare("INSERT INTO rooms (room_number, room_type, capacity, type, price, status, date_added, image) VALUES (?, ?, ?, ?, ?, ?, CURDATE(), ?)");
            $stmt->bind_param("ssissss", $room_number, $room_type, $capacity, $type, $price, $status, $image);
            if ($stmt->execute()) {
                $success = "Room added successfully!";
            } else {
                $errors[] = "Database error: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CASCADINGSTYLES/managerooms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="icon" href="Img/favicon.jpg">
    <title><?= isset($room_id) ? 'Edit Room' : 'Add New Room' ?></title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, sans-serif;
            background: #f0f4ff;
            margin: 0;
            padding: 0;
            color: #02203c;
        }

        main.admin-rooms {
            width: 90%;
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h2.admin-rooms-title {
            text-align: center;
            margin-bottom: 25px;
            color: #003366;
        }

        form.admin-add-room-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        form.admin-add-room-form label {
            font-weight: bold;
        }

        form.admin-add-room-form input,
        form.admin-add-room-form select,
        form.admin-add-room-form button {
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
            width: 100%;
            box-sizing: border-box;
        }

        form.admin-add-room-form button {
            background-color: #003366;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        form.admin-add-room-form button:hover {
            background-color: #0055a5;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        img.room-preview {
            display: block;
            max-width: 150px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
  <nav>
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

    <div class="icons-left">
      <div class="hamburger" id="hamburgerAdmin">
        <span></span><span></span><span></span>
      </div>
    </div>

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
<main class="admin-rooms">
    <h2 class="admin-rooms-title"><?= isset($room_id) ? 'Edit Room' : 'Add New Room' ?></h2>

    <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>
    <?php if (!empty($errors)) foreach ($errors as $error) echo "<p class='error'>$error</p>"; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="admin-add-room-form">
        <?php if(isset($room_id)): ?>
            <input type="hidden" name="room_id" value="<?= $room_id ?>">
        <?php endif; ?>

        <label>Room Number:</label>
        <input type="text" name="room_number" value="<?= htmlspecialchars($room_number) ?>" required>

        <label>Room Type:</label>
        <input type="text" name="room_type" value="<?= htmlspecialchars($room_type) ?>" required>

        <label>Capacity:</label>
        <input type="number" name="capacity" min="1" value="<?= htmlspecialchars($capacity) ?>" required>

        <label>Category (Single/Double/Executive):</label>
        <input type="text" name="type" value="<?= htmlspecialchars($type) ?>" required>

        <label>Price per Month (KSh):</label>
        <input type="number" name="price" value="<?= htmlspecialchars($price) ?>" required>

        <label>Status:</label>
        <select name="status">
            <option value="available" <?= $status === 'available' ? 'selected' : '' ?>>Available</option>
            <option value="booked" <?= $status === 'booked' ? 'selected' : '' ?>>Booked</option>
        </select>

        <label>Room Image:</label>
        <input type="file" name="image" accept="image/*">
        <?php if($image && $image !== 'default.jpg'): ?>
            <img src="images/rooms/<?= $image ?>" alt="Room Image" class="room-preview">
        <?php endif; ?>

        <button type="submit"><?= isset($room_id) ? 'Update Room' : 'Add Room' ?></button>
    </form>
</main>
</body>
</html>

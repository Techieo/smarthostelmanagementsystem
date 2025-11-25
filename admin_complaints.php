<?php
include 'db_connect.php'; // your DB connection

// Handle marking a complaint as resolved
if (isset($_GET['resolve_id'])) {
    $id = intval($_GET['resolve_id']);
    $stmt = $conn->prepare("UPDATE complaints SET status='resolved' WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin_complaints.php");
    exit;
}

// Fetch complaints
$sql = "SELECT * FROM complaints ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CASCADINGSTYLES/admincomplaints.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="icon" href="Img/favicon.jpg">
    <title>Manage Complaints - Smart Hostel Management System (SHMS)</title>
</head>
<body>
    
    <!-- 1. Header Section: System Name, Welcome Message, and Logout -->
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

<main class="complaints-main">
    <h2 class="complaints-title">Manage Complaints</h2>
    <p class="complaints-desc">Below is a list of all student complaints submitted through the system. Use the filters to sort and manage issues.</p>

    <!-- Filter/Search Section -->
    <section class="complaint-filters-section">
        <h3 class="filters-title">Filter and Search</h3>
        <form class="complaint-filters-form" method="GET">
            <div class="filter-group">
                <label for="search-input" class="filter-label">Search (Name/Room):</label>
                <input type="text" id="search-input" name="search" class="filter-input" placeholder="Enter student name or room no." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </div>
            <div class="filter-group">
                <label for="status-filter" class="filter-label">Filter by Status:</label>
                <select id="status-filter" name="status" class="filter-select">
                    <option value="all" <?php if(isset($_GET['status']) && $_GET['status']=='all') echo 'selected'; ?>>All</option>
                    <option value="pending" <?php if(isset($_GET['status']) && $_GET['status']=='pending') echo 'selected'; ?>>Pending</option>
                    <option value="resolved" <?php if(isset($_GET['status']) && $_GET['status']=='resolved') echo 'selected'; ?>>Resolved</option>
                </select>
            </div>
            <button type="submit" class="filter-btn">Apply Filters</button>
        </form>
    </section>

    <!-- Complaints Table -->
    <section class="complaints-table-section">
        <h3 class="table-title">Submitted Complaints</h3>
        <table class="complaints-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Room Number</th>
                    <th>Date Submitted</th>
                    <th>Complaint Type</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {

                    // Apply filters if any
                    if(isset($_GET['search']) && $_GET['search'] != '') {
                        $search = strtolower($_GET['search']);
                        if(strpos(strtolower($row['full_name']), $search) === false && strpos(strtolower($row['room_no']), $search) === false) {
                            continue;
                        }
                    }
                    if(isset($_GET['status']) && $_GET['status'] != 'all' && $_GET['status'] != $row['status']) {
                        continue;
                    }

                    // Define row classes based on status and priority
                    $row_class = $row['status'] . ' ' . $row['priority'];
            ?>
                <tr class="complaint-row <?php echo $row_class; ?>">
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['room_no']); ?></td>
                    <td><?php echo date('Y-m-d', strtotime($row['submitted_at'])); ?></td>
                    <td><?php echo htmlspecialchars($row['category']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td>
                        <span class="priority-badge <?php echo $row['priority']; ?>">
                            <?php echo ucfirst($row['priority']); ?>
                        </span>
                    </td>
                    <td>
                        <?php if($row['status']=='pending'): ?>
                            <a href="admin_complaints.php?resolve_id=<?php echo $row['id']; ?>" class="complaint-action-btn">Mark as Resolved</a>
                        <?php else: ?>
                            <a href="view_complaints.php?id=<?php echo $row['id']; ?>" class="complaint-action-btn">View Details</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='8'>No complaints found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </section>
</main>
<style>
  .priority-badge {
    padding: 4px 8px;
    border-radius: 5px;
    color: #fff;
    font-weight: 600;
    font-size: 0.85rem;
}

.priority-badge.low {
    background-color: #5cb85c; /* green */
}

.priority-badge.medium {
    background-color: #f0ad4e; /* orange */
}

.priority-badge.high {
    background-color: #d9534f; /* red */
}

/* Optional: row background color based on priority */
.complaint-row.low { background-color: #e6f7ff; }
.complaint-row.medium { background-color: #fff4e6; }
.complaint-row.high { background-color: #ffe6e6; }

</style>
</body>
</html>
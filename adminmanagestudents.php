<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "smart_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all students, alias personal_email as email
$sql = "SELECT *, personal_email AS email FROM students ORDER BY student_id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CASCADINGSTYLES/managestudents.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="icon" href="Img/favicon.jpg">    
    <title>Manage Students | Smart Hostel Management System</title>
</head>
<body>

<!-- HEADER -->
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
      <div class="hamburger" id="hamburgerAdmin"><span></span><span></span><span></span></div>
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

  hamburger.addEventListener("click", e => {
    e.stopPropagation();
    mobileMenu.classList.toggle("active");
  });

  document.addEventListener("click", e => {
    if (!mobileMenu.contains(e.target) && !hamburger.contains(e.target)) {
      mobileMenu.classList.remove("active");
    }
  });

  mobileMenu.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", () => mobileMenu.classList.remove("active"));
  });
});
</script>

<main class="admin-students">
    <h2 class="admin-students-title">Manage Students</h2>
    <p class="admin-students-desc">View, register, and manage all student records within the hostel system.</p>
    <br>

    <!-- REGISTER BUTTON -->
    <section style="margin-bottom:20px;">
        <button id="openModalBtn" style="display:inline-flex; align-items:center; gap:8px; background-color:#003366; color:#fff; padding:12px 20px; border-radius:8px; border:none; cursor:pointer; font-weight:600;">
            <i class="fas fa-user-plus"></i> Register New Student
        </button>
    </section>

    <!-- MODAL -->
    <div id="registerModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:#fff; padding:20px; border-radius:10px; width:600px; max-width:90%; position:relative;">
            <span id="closeModal" style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:18px;">&times;</span>
            <h2 style="margin-bottom:15px;">Register New Student</h2>
            <form id="registerStudentForm">
                <label style="font-weight:600;">First Name:</label><br>
                <input type="text" name="first_name" required style="width:100%; margin-bottom:10px; padding:8px; border-radius:5px; border:1px solid #ccc;"><br>
                
                <label style="font-weight:600;">Last Name:</label><br>
                <input type="text" name="last_name" required style="width:100%; margin-bottom:10px; padding:8px; border-radius:5px; border:1px solid #ccc;"><br>
                
                <label style="font-weight:600;">Email:</label><br>
                <input type="email" name="email" required style="width:100%; margin-bottom:10px; padding:8px; border-radius:5px; border:1px solid #ccc;"><br>
                
                <label style="font-weight:600;">Password:</label><br>
                <input type="password" name="password" required style="width:100%; margin-bottom:10px; padding:8px; border-radius:5px; border:1px solid #ccc;"><br>
                
                <button type="submit" style="background:#003366; color:white; padding:10px 20px; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
                    Register
                </button>

                <div id="registerMessage" style="margin-top:10px; font-weight:600;"></div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('registerModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModal');
        const messageDiv = document.getElementById('registerMessage');

        openBtn.onclick = () => modal.style.display = 'flex';
        closeBtn.onclick = () => modal.style.display = 'none';
        window.onclick = e => { if(e.target == modal) modal.style.display = 'none'; }

        document.getElementById('registerStudentForm').onsubmit = function(e){
            e.preventDefault();
            const formData = new FormData(this);

            fetch('register_student.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    messageDiv.style.color = 'green';
                    messageDiv.textContent = 'Student registered successfully!';
                    this.reset();
                } else {
                    messageDiv.style.color = 'red';
                    messageDiv.textContent = 'Error: ' + data.message;
                }
            })
            .catch(err => {
                messageDiv.style.color = 'red';
                messageDiv.textContent = 'AJAX error: ' + err;
            });
        }
    </script>

    <!-- STUDENTS TABLE -->
    <section class="admin-student-list">
        <h3 class="admin-section-title">List of Registered Students</h3>
        <div style="overflow-x:auto;">
            <table class="admin-students-table" border="1" cellspacing="0" cellpadding="5">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Programme</th>
                        <th>National ID</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>Medical Info</th>
                        <th>KCSE Year</th>
                        <th>KCSE Index</th>
                        <th>Phone</th>
                        <th>Home Address</th>
                        <th>Emergency Name</th>
                        <th>Emergency Relation</th>
                        <th>Emergency Phone</th>
                        <th>Profile Photo</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $fullName = htmlspecialchars($row['first_name'].' '.$row['last_name']);
                        $email = htmlspecialchars($row['email']);
                        $profilePhoto = !empty($row['profile_photo']) ? $row['profile_photo'] : 'Img/placeholder.jpg';

                        echo "<tr>
                                <td>{$fullName}</td>
                                <td>{$email}</td>
                                <td>{$row['programme']}</td>
                                <td>{$row['nat_id']}</td>
                                <td>{$row['date_of_birth']}</td>
                                <td>{$row['gender']}</td>
                                <td>{$row['nationality']}</td>
                                <td>{$row['medical_info']}</td>
                                <td>{$row['kcse_year']}</td>
                                <td>{$row['kcse_index']}</td>
                                <td>{$row['personal_phone']}</td>
                                <td>{$row['home_address']}</td>
                                <td>{$row['ec_name']}</td>
                                <td>{$row['ec_relationship']}</td>
                                <td>{$row['ec_phone']}</td>
                                <td><img src='{$profilePhoto}' alt='Profile' width='50'></td>
                                <td>{$row['created_at']}</td>
                                <td>{$row['updated_at']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='18'>No students found.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php $conn->close(); ?>
</body>
</html>

<?php
session_start();
include("db_connect.php");

// Redirect if already logged in
if (isset($_SESSION['student_id'])) {
    header("Location: dashboard_student.php");
    exit();
} elseif (isset($_SESSION['admin_id'])) {
    header("Location: dashboardadmin.php");
    exit();
}

$email = $password = "";
$emailErr = $passwordErr = "";

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($email)) $emailErr = "Email is required";
    if (empty($password)) $passwordErr = "Password is required";

    if (empty($emailErr) && empty($passwordErr)) {

        $user = null;
        $role = null;

        // 1️⃣ Check if user is a student
        $stmt = $conn->prepare("SELECT * FROM students WHERE personal_email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $studentResult = $stmt->get_result();
        $stmt->close();

        if ($studentResult && $studentResult->num_rows === 1) {
            $user = $studentResult->fetch_assoc();
            $role = "student";
        } else {
            // 2️⃣ Check if user is an admin
            $stmt = $conn->prepare("SELECT admin_id, email, password FROM admins WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $adminResult = $stmt->get_result();
            $stmt->close();

            if ($adminResult && $adminResult->num_rows === 1) {
                $user = $adminResult->fetch_assoc();
                $role = "admin";
            } else {
                $emailErr = "Email not found";
            }
        }

        // 3️⃣ Verify password if user exists
        if (!empty($user)) {
            if (password_verify($password, $user['password'])) {

                // SESSION SETUP FOR STUDENTS / ADMINS
                if ($role === "student") {
                    $_SESSION['student_id'] = $user['student_id'];
                    $_SESSION['role'] = 'student';
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];

                    header("Location: dashboard_student.php");
                    exit();

                } elseif ($role === "admin") {
                    $_SESSION['admin_id'] = $user['admin_id'];
                    $_SESSION['role'] = 'admin';

                    header("Location: dashboardadmin.php");
                    exit();
                }

            } else {
                $passwordErr = "Incorrect password";
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
<title>Login | SHMS</title>
<link rel="icon" href="Img/favicon.jpg">
<link rel="stylesheet" href="CASCADINGSTYLES/login_student.css">
</head>
<body>
<div class="login-container">
    <div class="login-image">
        <img src="Img/UI.jpg" alt="Login Interface">
    </div>

    <div class="login-form">
        <header>
            <h1>Welcome Back!</h1>
            <p>Enter your details to log in.</p>
        </header>

        <form action="" method="POST">
            <div>
                <label for="username">Email</label>
                <input type="text" id="username" name="username" placeholder="Enter Email" 
                    value="<?php echo htmlspecialchars($email); ?>" />
                <?php if(!empty($emailErr)) echo '<span class="error">'.$emailErr.'</span>'; ?>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" />
                <?php if(!empty($passwordErr)) echo '<span class="error">'.$passwordErr.'</span>'; ?>
            </div>

            <button type="submit">Login</button>
        </form>

        <footer>
            <p>Don't have an account? <a href="signup.php" class="forgotpassword_link">Sign Up</a></p>
            <p><a href="forgotpassword.php" class="forgotpassword_link">Forgot Password?</a></p>
        </footer>
    </div>
</div>

<style>
/* ===== ERROR MESSAGE ===== */
.error {
    color: #d90000;
    font-size: 0.9rem;
    margin-top: 5px;
    display: block;
}
</style>
</body>
</html>

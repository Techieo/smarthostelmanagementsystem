<?php
session_start();
include("db_connect.php");

$error = '';
$redirect = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = "Please enter your email address.";
    } else {
        $stmt = $conn->prepare("SELECT student_id FROM students WHERE personal_email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $student = $result->fetch_assoc();

            // Store student_id in session for reset page
            $_SESSION['reset_student_id'] = $student['student_id'];

            // Trigger redirect message
            $redirect = true;
        } else {
            $error = "No account found with that email address.";
        }

        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="icon" type="image/png" href="Img/SHMSlogo.png"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link rel="stylesheet" href="CASCADINGSTYLES/forgotpassword.css"/>
<title>Forgot Password | SHMS</title>
<style>
.error-msg { color: red; margin-bottom: 10px; font-size: 0.95rem; }
.success-msg { color: green; margin-bottom: 10px; font-size: 0.95rem; }
</style>
<?php if($redirect): ?>
<meta http-equiv="refresh" content="3;url=resetpassword.php">
<?php endif; ?>
</head>
<body>
<div class="forgot-container">
    <div class="forgot-image">
        <img src="Img/UI.jpg" alt="Interface Image">
    </div>

    <div class="forgot-form">
        <form action="" method="POST" autocomplete="off">
            <header>
                <h1>Forgot Password</h1>
            </header>

            <p class="instruction">
                Enter your email address to reset your password.
            </p>

            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email address"
                    required
                    value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                />
            </div>
            <br><br>
            <?php if (!empty($error)): ?>
                <p class="error-msg"><?php echo $error; ?></p>
            <?php elseif ($redirect): ?>
                <p class="success-msg">Email found! Redirecting to reset password page...</p>
            <?php endif; ?>

            <?php if (!$redirect): ?>

            <button type="submit">Submit</button>
            <?php endif; ?>

            <footer>
                <p><a href="index.php">Back to Login</a></p>
            </footer>
        </form>
    </div>
</div>
</body>
</html>

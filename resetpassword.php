<?php
session_start();
include("db_connect.php");

// Get student_id from previous page
$student_id = $_SESSION['reset_student_id'] ?? null;

$error = '';
$success = '';

if (!$student_id) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if (!$newPassword || !$confirmPassword) {
        $error = "Both password fields are required.";
    } elseif (strlen($newPassword) < 6) {
        $error = "Password must be at least 6 characters long.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE students SET password = ? WHERE student_id = ?");
        $update->bind_param("si", $hashedPassword, $student_id);
        $update->execute();

        $success = "Password changed successfully. Redirecting to login...";
        unset($_SESSION['reset_student_id']);
        header("refresh:3;url=login.php");
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password | SHMS</title>
<link rel="stylesheet" href="CASCADINGSTYLES/resetpassword.css">
</head>
<body>

<div class="reset-container">
    <!-- Left Image -->
    <div class="reset-image">
        <img src="Img/UI.jpg" alt="Reset Password Image">
    </div>

    <!-- Right Form -->
    <div class="reset-form">
        <main>
            <form method="POST">
                <header>
                    <h1>Reset Password</h1>
                    <p>Enter your new password below and confirm it.</p>
                </header>

                <?php if ($error): ?>
                    <p class="error-msg"><?php echo $error; ?></p>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <p class="success-msg"><?php echo $success; ?></p>
                <?php endif; ?>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" required minlength="6">
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" required minlength="6">
                </div>

                <div class="form-buttons">
                    <button type="submit" class="save-btn">Save Changes</button>
                    <a href="login.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </main>
    </div>
</div>

</body>
</html>
<?php
session_start();
include("db_connect.php");

// Get student_id from previous page
$student_id = $_SESSION['reset_student_id'] ?? null;

$error = '';
$success = '';

if (!$student_id) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if (!$newPassword || !$confirmPassword) {
        $error = "Both password fields are required.";
    } elseif (strlen($newPassword) < 6) {
        $error = "Password must be at least 6 characters long.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE students SET password = ? WHERE student_id = ?");
        $update->bind_param("si", $hashedPassword, $student_id);
        $update->execute();

        $success = "Password changed successfully. Redirecting to login...";
        unset($_SESSION['reset_student_id']);
        header("refresh:3;url=login.php");
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password | SHMS</title>
<link rel="icon" href="Img/favicon.jpg" />
<link rel="stylesheet" href="CASCADINGSTYLES/resetpassword.css">
</head>
<body>

<div class="reset-container">
    <!-- Left Image -->
    <div class="reset-image">
        <img src="Img/UI.jpg" alt="Reset Password Image">
    </div>

    <!-- Right Form -->
    <div class="reset-form">
        <main>
            <form method="POST">
                <header>
                    <h1>Reset Password</h1>
                    <p>Enter your new password below and confirm it.</p>
                </header>

                <?php if ($error): ?>
                    <p class="error-msg"><?php echo $error; ?></p>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <p class="success-msg"><?php echo $success; ?></p>
                <?php endif; ?>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" required minlength="6">
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" required minlength="6">
                </div>

                <div class="form-buttons">
                    <button type="submit" class="save-btn">Save Changes</button>
                    <a href="login.php" class="save-btn">Cancel</a>
                </div>
            </form>
        </main>
    </div>
</div>

</body>
</html>

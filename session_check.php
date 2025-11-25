<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check role required for the page
// $require_role should be set at the top of each page: 'student' or 'admin'

if (!isset($require_role)) {
    // Default: allow anyone logged in
    $require_role = null;
}

// If student page
if ($require_role === 'student') {
    if (!isset($_SESSION['student_id'])) {
        header("Location: login.php");
        exit();
    }
}

// If admin page
if ($require_role === 'admin') {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit();
    }
}
?>

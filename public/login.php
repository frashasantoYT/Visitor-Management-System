<?php
// public/login.php
session_start();
include_once '../config/database.php';
include_once '../src/UserController.php';

$username = $_POST['username'];
$password = $_POST['password'];

$userController = new UserController($conn);
$user = $userController->authenticate($username, $password);

if ($user) {
    if ($user['is_active'] == 0) {
        // User is inactive, redirect with an error message
        header("Location: ../public/index.php?error=Your account is not active");
        exit();
    }

    $_SESSION['user'] = $user;

    if ($user['role'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else if ($user['role'] === 'guard') {
        header("Location: guard_dashboard.php");
    }
    exit();
} else {
    // Redirect back to login with an error message
    header("Location: ../public/index.php?error=Invalid credentials");
    exit();
}
?>

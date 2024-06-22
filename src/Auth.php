<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['user']['role'] === 'admin';
}

function isGuard() {
    return isLoggedIn() && $_SESSION['user']['role'] === 'guard';
}

function login($user) {
    $_SESSION['user'] = $user;
}

function logout() {
    session_unset();
    session_destroy();
}
?>

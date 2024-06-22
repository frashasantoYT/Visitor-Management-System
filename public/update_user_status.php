<?php
include_once '../config/database.php';
include_once '../src/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $is_active = $_POST['status'];

    $userController = new UserController($conn);
    $userController->updateUserStatus($id, $is_active);
    echo 'success';
}
?>

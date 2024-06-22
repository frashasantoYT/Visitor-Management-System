<?php
include_once '../config/database.php';
include_once '../src/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $userController = new UserController($conn);
    $userController->deleteUser($id);
    echo 'success';
}
?>

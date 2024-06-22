<?php
include_once '../config/database.php';
include_once '../src/VisitorController.php';

$visitorController = new VisitorController($conn);

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$visit_date = $_POST['visit_date'];
$purpose = $_POST['purpose'];
$remarks = $_POST['remarks'];

$result = $visitorController->updateVisitor($id, $name, $email, $phone, $visit_date, $purpose, $remarks);

if ($result) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update visitor']);
} else {
    
    echo json_encode(['status' => 'success', 'message' => 'Visitor updated successfully']);
}
?>

<?php
include_once '../config/database.php';
include_once '../src/VisitorController.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $visitorId = $_GET['id'];

    $visitorController = new VisitorController($conn);
    $visitor = $visitorController->getVisitorById($visitorId);

    echo json_encode($visitor);
} else {
    // Invalid request
    http_response_code(400);
    echo "Invalid request";
}
?>

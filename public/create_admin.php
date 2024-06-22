<?php
include_once '../config/database.php';

$username = 'admin';
$password = 'admin123';
$role = 'admin';

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $hashedPassword, $role);

if ($stmt->execute()) {
    echo "Admin user created successfully.";
} else {
    echo "Error creating admin user: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

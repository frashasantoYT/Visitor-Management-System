<?php
class PermissionController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function hasPermission($role, $permission) {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) as count 
            FROM role_permissions 
            JOIN permissions ON role_permissions.permission_id = permissions.id 
            WHERE role_permissions.role = ? AND permissions.permission_name = ?"
        );
        $stmt->bind_param("ss", $role, $permission);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row['count'] > 0;
    }
}
?>

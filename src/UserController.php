<?php
class UserController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createUser($username, $password, $role) {
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param("sss", $username, $hashedPassword, $role);
        $stmt->execute();
        $stmt->close();
    }

    public function authenticate($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        
        return false;
    }

    public function getTotalGuards() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total_guards FROM users WHERE role = 'guard'");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['total_guards'];
    }

    public function getGuards() {
        $stmt = $this->conn->prepare("SELECT id, username FROM users WHERE role = 'guard'");
        $stmt->execute();
        $result = $stmt->get_result();
        $guards = [];
        while ($row = $result->fetch_assoc()) {
            $guards[] = $row;
        }
        $stmt->close();
        return $guards;
    }

    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT id, username, role, is_active FROM users");
        $stmt->execute();
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $stmt->close();
        return $users;
    }

    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    public function updateUserStatus($id, $is_active) {
        $stmt = $this->conn->prepare("UPDATE users SET is_active = ? WHERE id = ?");
        $stmt->bind_param("ii", $is_active, $id);
        $stmt->execute();
        $stmt->close();
    }
}
?>

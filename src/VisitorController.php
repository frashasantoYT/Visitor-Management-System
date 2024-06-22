<?php
class VisitorController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addVisitor($name, $email, $phone, $visit_date, $purpose, $remarks) {
        $stmt = $this->conn->prepare("INSERT INTO visitors (name, email, phone, visit_date, purpose) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $visit_date, $purpose);
        $stmt->execute();
        $stmt->close();
    }

    public function getVisitorsByDateRange($start_date, $end_date) {
        $stmt = $this->conn->prepare("SELECT * FROM visitors WHERE visit_date BETWEEN ? AND ?");
        $stmt->bind_param("ss", $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();
        $visitors = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $visitors;
    }

    public function getVisitorById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM visitors WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $visitor = $result->fetch_assoc();
        $stmt->close();
        return $visitor;
    }

    public function getAllVisitors() {
        $stmt = $this->conn->prepare("SELECT * FROM visitors ORDER BY created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        $visitors = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $visitors;
    }

    public function getTotalVisitors() {
        $query = "SELECT COUNT(*) as total FROM visitors";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close();
        return $total;
    }

    
    public function updateVisitor($id, $name, $email, $phone, $visit_date, $purpose, $remarks) {
        $stmt = $this->conn->prepare("UPDATE visitors SET name=?, email=?, phone=?, visit_date=?, purpose=?, remarks=? WHERE id=?");
        $stmt->bind_param("ssssssi", $name, $email, $phone, $visit_date, $purpose, $remarks, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function getRecentActivities() {
        $query = "SELECT time, message FROM activity_log ORDER BY time DESC LIMIT 20";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>

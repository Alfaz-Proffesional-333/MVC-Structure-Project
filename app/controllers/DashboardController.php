<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/User.php';

class DashboardController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $db = new Database();
        $conn = $db->conn;
        $user_id = $_SESSION['user_id'];

        $unreadCount = $conn->query("SELECT COUNT(*) as total FROM notifications WHERE user_id='$user_id' AND is_read=0")->fetch_assoc()['total'];

        // Stats
        $empCount = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='Employee'")->fetch_assoc()['total'];
        $manCount = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='Manager'")->fetch_assoc()['total'];
        $admCount = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='Admin'")->fetch_assoc()['total'];
        $taskCount = $conn->query("SELECT COUNT(*) as total FROM tasks")->fetch_assoc()['total'];
        $taskpending = $conn->query("SELECT COUNT(*) as total FROM tasks WHERE status='Pending'")->fetch_assoc()['total'];
        $taskprogress = $conn->query("SELECT COUNT(*) as total FROM tasks WHERE status='In Progress'")->fetch_assoc()['total'];
        $taskcomplete = $conn->query("SELECT COUNT(*) as total FROM tasks WHERE status='Completed'")->fetch_assoc()['total'];
        $taskcancel = $conn->query("SELECT COUNT(*) as total FROM tasks WHERE status='Cancelled'")->fetch_assoc()['total'];

        include __DIR__ . '/../views/dashboard/index.php';
    }
}

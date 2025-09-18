<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/user.php';

class AuthController {
    public function login() {
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            try {
                $userModel = new User();
                $result = $userModel->getUsers($email, 'email');

                if ($result) {
                    $row = $result;
                    if (password_verify($password, $row['hash_password'])) {
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['fullname'] = $row['fullname'];
                        $_SESSION['role'] = $row['role'];

                        if ($_SESSION['role'] == 'Admin') {
                            header("Location: /dashboard");
                            exit();
                        }elseif ($_SESSION['role'] == 'Manager') {
                            header("Location: /employee");
                            exit();
                        }else {
                            header("Location: /tasks/assigned");
                            exit();
                        }
                    } else {
                        $error = "Invalid password!";
                    }
                } else {
                    $error = "No users found with this email.";
                }
            } catch (Exception $e) {
                error_log($e->getMessage(), 3, __DIR__ . '/../../logs/error.log');
                $error = "Something went wrong during login.";
            }
        }
        
        include __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit();
    }
}

class DashboardController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        try{
            $db = new Database();
            $conn = $db->conn;
            $user_id = $_SESSION['user_id'];

            $empCount = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='Employee'")->fetch_assoc()['total'];
            $manCount = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='Manager'")->fetch_assoc()['total'];
            $admCount = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='Admin'")->fetch_assoc()['total'];
            $taskCount = $conn->query("SELECT COUNT(*) as total FROM tasks")->fetch_assoc()['total'];
            $taskpending = $conn->query("SELECT COUNT(*) as total FROM tasks WHERE status='Pending'")->fetch_assoc()['total'];
            $taskprogress = $conn->query("SELECT COUNT(*) as total FROM tasks WHERE status='In Progress'")->fetch_assoc()['total'];
            $taskcomplete = $conn->query("SELECT COUNT(*) as total FROM tasks WHERE status='Completed'")->fetch_assoc()['total'];
            $taskcancel = $conn->query("SELECT COUNT(*) as total FROM tasks WHERE status='Cancelled'")->fetch_assoc()['total'];

            include __DIR__ . '/../views/layouts/header.php';
            include __DIR__ . '/../views/dashboard/index.php';
            include __DIR__ . '/../views/layouts/footer.php';
        }catch (Exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/../../logs/error.log');
            echo "Error loading dashboard.";
        }
    }
}
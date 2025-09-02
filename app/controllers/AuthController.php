<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function login() {
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User();
            $result = $userModel->findByEmail($email);

            if ($result) {
                $row = $result;
                if ($password == $row['plain_password']) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['fullname'] = $row['fullname'];
                    $_SESSION['role'] = $row['role'];
                    header("Location: /dashboard");
                    exit();
                } else {
                    $error = "Invalid password!";
                }
            } else {
                $error = "No users found with this email.";
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

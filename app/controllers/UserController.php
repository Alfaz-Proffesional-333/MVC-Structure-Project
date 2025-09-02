<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // All users list
    public function index() {
        $users = $this->userModel->getAllUsers();
        $pageTitle = "User List";
        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/users/list.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // Manager list
    public function managers() {
        $users = $this->userModel->getUsersByRole('Manager');
        $pageTitle = "Manager List";
        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/users/list.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // Employee list
    public function employees() {
        $users = $this->userModel->getUsersByRole('Employee');
        $pageTitle = "Employee List";
        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/users/list.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // Add form
    public function create() {
        $pageTitle = "Add User";
        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/users/add.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // Store new user
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $plain_password = $_POST['password'];
            $hash_password = password_hash($plain_password, PASSWORD_DEFAULT);
            $department = $_POST['department'];
            $job_title = $_POST['job'];
            $role = $_POST['role'];

            $this->userModel->createUser($fullname, $email, $plain_password, $hash_password, $department, $job_title, $role);

            // Prepare email
            $subject = "Your Account Details";
            $message = "Hello $fullname,\n\n".
                    "Your account has been created successfully.\n\n".
                    "Login Details:\n".
                    "User ID: $email\n".
                    "Password: $plain_password\n\n".
                    "Please keep your credentials safe.";

            // Include sendmail function
            require_once __DIR__ . '/../../sendmail.php';
            sendEmail($email, $subject, $message);
            
            header("Location: /users");
            exit;
        }
    }

    // Edit form
    public function edit($id) {
        $user = $this->userModel->getUserById($id);
        $pageTitle = "Edit User";
        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/users/edit.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // Update user
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $department = $_POST['department'];
            $job_title = $_POST['job'];
            $role = $_POST['role'];

            $this->userModel->updateUser($id, $fullname, $email, $department, $job_title, $role);

            header("Location: /users");
            exit;
        }
    }

    // Delete user
    public function delete($id) {
        $this->userModel->deleteUser($id);
        header("Location: /users");
        exit;
    }
}

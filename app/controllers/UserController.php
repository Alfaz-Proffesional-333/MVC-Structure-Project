<?php
require_once __DIR__ . '/../models/user.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // All users list
    public function index() {
        try {
            $users = $this->userModel->getUsers('','');
            $pageTitle = "User List";
            include __DIR__ . '/../views/layouts/header.php';
            include __DIR__ . '/../views/users/list.php';
            include __DIR__ . '/../views/layouts/footer.php';
        } catch (Exception $e) {
            $error = error_log("usercontroller index error: " . $e->getMessage());
            include __DIR__ . '/../views/errors/500.php';
        }
    }

    // Manager list
    public function managers() {
        try{
            $users = $this->userModel->getUsers('Manager', 'role');
            $pageTitle = "Manager List";
            include __DIR__ . '/../views/layouts/header.php';
            include __DIR__ . '/../views/users/list.php';
            include __DIR__ . '/../views/layouts/footer.php';
        } catch (Exception $e) {
            error_log("usercontroller managers error: " . $e->getMessage());
            include __DIR__ . '/../views/errors/500.php';
        }
    }

    // Employee list
    public function employees() {
        try{
            $users = $this->userModel->getUsers('Employee', 'role');
            $pageTitle = "Employee List";
            include __DIR__ . '/../views/layouts/header.php';
            include __DIR__ . '/../views/users/list.php';
            include __DIR__ . '/../views/layouts/footer.php';
        } catch (Exception $e) {
            error_log("usercontroller employees error: " . $e->getMessage());
            include __DIR__ . '/../views/errors/500.php';
        }
    }

    // Add form
    public function create() {
        try{
            $pageTitle = "Add User";
            include __DIR__ . '/../views/layouts/header.php';
            include __DIR__ . '/../views/users/add.php';
            include __DIR__ . '/../views/layouts/footer.php';
        } catch (Exception $e) {
            error_log("usercontroller add page error: " . $e->getMessage());
            include __DIR__ . '/../views/errors/500.php';
        }
    }

    // Store new user
    public function store() {
        try{
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $fullname = $_POST['fullname'];
                $email = $_POST['email'];
                $plain_password = $_POST['password'];
                $hash_password = password_hash($plain_password, PASSWORD_DEFAULT);
                $department = $_POST['department'];
                $job_title = $_POST['job'];
                $role = $_POST['role'];

                $this->userModel->createUser($fullname, $email, $hash_password, $department, $job_title, $role);

                // Prepare email
                $admin_mail = "arifbhaikhokhar629@gmail.com";
                $admin_sub = "New User Added";
                $admin_msg = "New User Details\n\n"."User ID: $email\n"."Password: $plain_password\n\n"."Role: $role";

                $subject = "Your Account Details";
                $message = "Hello $fullname,\n\n".
                        "Your account has been created successfully.\n\n".
                        "Login Details:\n".
                        "User ID: $email\n".
                        "Password: $plain_password\n\n".
                        "Please keep your credentials safe.";

                // Include sendmail function
                require_once __DIR__ . '/../../services/sendmail.php';
                sendEmail($email, $subject, $message);
                sendEmail($admin_mail, $admin_sub, $admin_msg);
                
                header("Location: /users");
                exit;
            }
       } catch (Exception $e) {
                error_log("create user error: " . $e->getMessage());
                return [];
        }
    }

    // Edit form
    public function edit($id) {
        try{
            $user = $this->userModel->getUsers($id, 'id');
            $pageTitle = "Edit Details";
            include __DIR__ . '/../views/layouts/header.php';
            include __DIR__ . '/../views/users/edit.php';
            include __DIR__ . '/../views/layouts/footer.php';
        } catch (Exception $e) {
            error_log("usercontroller edit page error: " . $e->getMessage());
            include __DIR__ . '/../views/errors/500.php';
        }
    }

    // Update user
    public function update() {
        try{
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'];
                $fullname = $_POST['fullname'];
                $email = $_POST['email'];
                $hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $department = $_POST['department'];
                $job_title = $_POST['job'];
                $role = $_POST['role'];

                $this->userModel->updateUser($id, $fullname, $email, $hash_password, $department, $job_title, $role);

                header("Location: /users");
                exit;
            }
        } catch (Exception $e) {
                error_log("update details error: " . $e->getMessage());
                return [];
        }
    }

    // Delete user
    public function delete($id) {
        try{
            $this->userModel->deleteUser($id);
            header("Location: /users");
            exit;
        } catch (Exception $e) {
                error_log("delete user error: " . $e->getMessage());
                return [];
        }
    }
}
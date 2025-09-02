<?php
require_once __DIR__ . '/../../config/db.php';

class User {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
    }

    // Get all users
    public function getAllUsers() {
        $result = $this->db->query("SELECT * FROM users ORDER BY id ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get users by role
    public function getUsersByRole($role) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = ?");
        $stmt->bind_param('s', $role);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Get single user by ID
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Create user
    public function createUser($fullname, $email, $plain_password, $hash_password, $department, $job_title, $role) {
        $stmt = $this->db->prepare("INSERT INTO users (fullname, email, plain_password, hash_password, department, job_title, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $fullname, $email, $plain_password, $hash_password, $department, $job_title, $role);
        return $stmt->execute();
    }

    // Update user
    public function updateUser($id, $fullname, $email, $department, $job_title, $role) {
        $stmt = $this->db->prepare("UPDATE users SET fullname = ?, email = ?, department = ?, job_title = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $fullname, $email, $department, $job_title, $role, $id);
        return $stmt->execute();
    }

    // Delete user
    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Find by email
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc(); // returns associative array or null
    }

    // Stats for dashboard
    public function getStats() {
        return [
            'admins' => $this->db->query("SELECT COUNT(*) as total FROM users WHERE role='Admin'")->fetch_assoc()['total'],
            'managers' => $this->db->query("SELECT COUNT(*) as total FROM users WHERE role='Manager'")->fetch_assoc()['total'],
            'employees' => $this->db->query("SELECT COUNT(*) as total FROM users WHERE role='Employee'")->fetch_assoc()['total'],
        ];
    }
}

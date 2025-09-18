<?php
require_once __DIR__ . '/../../config/db.php';

class User {
    private $db;

    public function __construct() {
        try {
            $database = new Database();
            $this->db = $database->conn;
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/../../logs/error.log');
            throw new Exception("Database connection failed.");
        }
    }

    public function getUsers($value , $categary){
        if ($categary == 'role') {
            try{
            $stmt = $this->db->prepare("SELECT * FROM users WHERE role = ?");
            $stmt->bind_param('s', $value);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            } catch (Exception $e) {
                error_log($e->getMessage(), 3, __DIR__ . '/../../logs/error.log');
                throw new Exception("user updatation process failed.");
            }
        }elseif ($categary == 'id') {
            try{
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param('i', $value);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
            } catch (Exception $e) {
                error_log($e->getMessage(), 3, __DIR__ . '/../../logs/error.log');
                throw new Exception("user updatation process failed.");
            }
        }elseif ($categary == 'email') {
            try{
            $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `email` = ?");
            $stmt->bind_param("s", $value);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
            } catch (Exception $e) {
                error_log($e->getMessage(), 3, __DIR__ . '/../../logs/error.log');
                throw new Exception("user updatation process failed.");
            }
        }
        else {
            try{
                $result = $this->db->query("SELECT * FROM users ORDER BY id ASC");
                return $result->fetch_all(MYSQLI_ASSOC);
            } catch (Exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/../../logs/error.log');
            throw new Exception("user updatation process failed.");
            }
        }
    }

    // Create user
    public function createUser($fullname, $email, $hash_password, $department, $job_title, $role) {
        try{
            $stmt = $this->db->prepare("INSERT INTO users (fullname, email, hash_password, department, job_title, role) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $fullname, $email, $hash_password, $department, $job_title, $role);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/../../logs/error.log');
            throw new Exception("user adding process failed.");
        }
    }

    // Update user
    public function updateUser($id, $fullname, $email, $hash_password, $department, $job_title, $role) {
        try{
            $stmt = $this->db->prepare("UPDATE users SET fullname = ?, email = ?, hash_password = ?, department = ?, job_title = ?, role = ? WHERE id = ?");
            $stmt->bind_param("ssssssi", $fullname, $email, $hash_password, $department, $job_title, $role, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/../../logs/error.log');
            throw new Exception("user updatation process failed.");
        }
    }

    // Delete user
    public function deleteUser($id) {
        try{
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/../../logs/error.log');
            throw new Exception("user delete process failed.");
        }
    }
}

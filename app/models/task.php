<?php
require_once __DIR__ . '/../../config/db.php';

class Task {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
    }

    public function getAllTasks() {
        $sql = "SELECT t.*, u.fullname AS assigned_by 
                FROM tasks t
                JOIN users u ON t.assigned_by = u.id
                ORDER BY t.id ASC";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function addTask($data) {
        $title = $this->db->real_escape_string($data['title']);
        $description = $this->db->real_escape_string($data['description']);
        $start_date = $this->db->real_escape_string($data['start_date']);
        $due_date = $this->db->real_escape_string($data['due_date']);
        $status = $this->db->real_escape_string($data['status']);
        $assigned_by = intval($data['assigned_by']);

        $sql = "INSERT INTO tasks (title, description, start_date, due_date, status, assigned_by)
                VALUES ('$title', '$description', '$start_date', '$due_date', '$status', $assigned_by)";
        return $this->db->query($sql);
    }

    public function getTaskById($id) {
        $id = intval($id);
        return $this->db->query("SELECT * FROM tasks WHERE id = $id")->fetch_assoc();
    }

    public function updateTask($id, $data) {
        $id = intval($id);
        $title = $this->db->real_escape_string($data['title']);
        $description = $this->db->real_escape_string($data['description']);
        $start_date = $this->db->real_escape_string($data['start_date']);
        $due_date = $this->db->real_escape_string($data['due_date']);
        $status = $this->db->real_escape_string($data['status']);

        $sql = "UPDATE tasks 
                SET title='$title', description='$description', start_date='$start_date', due_date='$due_date', status='$status'
                WHERE id=$id";
        return $this->db->query($sql);
    }

    public function deleteTask($id) {
        return $this->db->query("DELETE FROM tasks WHERE id=" . intval($id));
    }

    public function getEmployees() {
        $sql = "SELECT id, fullname FROM users WHERE role = 'Employee'";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getEmployeeById($id) {
        $id = intval($id);
        $sql = "SELECT fullname, email FROM users WHERE role = 'Employee' AND id=$id";
        return $this->db->query($sql)->fetch_assoc();  // fetch single row, not fetch_all
    }

    public function assignTask($task_id, $employee_ids) {
        foreach ($employee_ids as $emp_id) {
            $task_id = intval($task_id);
            $emp_id = intval($emp_id);
            $check = $this->db->query("SELECT * FROM task_assignments WHERE task_id=$task_id AND employee_id=$emp_id");
            if ($check->num_rows == 0) {
                $this->db->query("INSERT INTO task_assignments (task_id, employee_id) VALUES ($task_id, $emp_id)");
            }
        }
    }

    public function getAssignments() {
        $sql = "SELECT ta.id, t.title AS task_title, u.fullname AS employee_name
                FROM task_assignments ta
                JOIN tasks t ON ta.task_id = t.id
                JOIN users u ON ta.employee_id = u.id
                ORDER BY ta.id ASC";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getEmployeeTasks($employee_id) {
        $employee_id = intval($employee_id);
        $sql = "SELECT t.*, ta.task_id
                FROM task_assignments ta
                JOIN tasks t ON ta.task_id = t.id
                WHERE ta.employee_id = $employee_id";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function updateTaskStatus($task_id, $status) {
        $task_id = intval($task_id);
        $status = $this->db->real_escape_string($status);
        return $this->db->query("UPDATE tasks SET status='$status' WHERE id=$task_id");
    }
}

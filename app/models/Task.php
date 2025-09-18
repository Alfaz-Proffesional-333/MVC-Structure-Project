<?php
require_once __DIR__ . '/../../config/db.php';

class Task{
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
    }
    
    public function getTasksandemp($value, $cat){
        if ($cat == 'id') {
            $id = intval($value);
            return $this->db->query("SELECT * FROM tasks WHERE id = $id")->fetch_assoc();
        } elseif ($cat == 'emp') {
            if ($value) {
                $id = intval($value);
                $sql = "SELECT fullname, email FROM users WHERE role = 'Employee' AND id=$id";
                return $this->db->query($sql)->fetch_assoc();
            } else {
                $sql = "SELECT id, fullname FROM users WHERE role = 'Employee'";
                return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
            }
        }else {
            $sql = "SELECT t.*, u.fullname AS assigned_by 
                FROM tasks t
                JOIN users u ON t.assigned_by = u.id
                ORDER BY t.id ASC";
            return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function addTask($data) {
        try{
            $title = $this->db->real_escape_string($data['title']);
            $description = $this->db->real_escape_string($data['description']);
            $start_date = $this->db->real_escape_string($data['start_date']);
            $due_date = $this->db->real_escape_string($data['due_date']);
            $status = $this->db->real_escape_string($data['status']);
            $assigned_by = intval($data['assigned_by']);

            $sql = "INSERT INTO tasks (title, description, start_date, due_date, status, assigned_by)
                    VALUES ('$title', '$description', '$start_date', '$due_date', '$status', $assigned_by)";
            return $this->db->query($sql);
        } catch (Exception $e) {
                error_log("add task error: " . $e->getMessage());
                return [];
        }
    }

    public function updateTask($id, $data, $status) {
        if ($status == 'stat') {
            try{
                $task_id = intval($id);
                $data = $this->db->real_escape_string($data);
                return $this->db->query("UPDATE tasks SET status='$data' WHERE id=$task_id");
            } catch (Exception $e) {
                    error_log("index error: " . $e->getMessage());
                    return [];
            }
        } else {
            try{
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
            } catch (Exception $e) {
                    error_log("update task error: " . $e->getMessage());
                    return [];
            }
        }
    }

    public function deleteTask($id) {
        try{
            return $this->db->query("DELETE FROM tasks WHERE id=" . intval($id));
        } catch (Exception $e) {
                error_log("index error: " . $e->getMessage());
                return [];
        }
    }

    public function assignTask($task_id, $employee_ids) {
        try{
            foreach ($employee_ids as $emp_id) {
                $task_id = intval($task_id);
                $emp_id = intval($emp_id);
                $check = $this->db->query("SELECT * FROM task_assignments WHERE task_id=$task_id AND employee_id=$emp_id");
                if ($check->num_rows == 0) {
                    $this->db->query("INSERT INTO task_assignments (task_id, employee_id) VALUES ($task_id, $emp_id)");
                }
            }
        } catch (Exception $e) {
                error_log("index error: " . $e->getMessage());
                return [];
        }
    }

    public function getAssignments() {
        try{
            $sql = "SELECT ta.id, t.title AS task_title, u.fullname AS employee_name
                    FROM task_assignments ta
                    JOIN tasks t ON ta.task_id = t.id
                    JOIN users u ON ta.employee_id = u.id
                    ORDER BY ta.id ASC";
            return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
        }catch (Exception $e) {
                error_log("get assignments error: " . $e->getMessage());
                return [];
        }
    }

    public function getEmployeeTasks($employee_id) {
        try{
            $employee_id = intval($employee_id);
            $sql = "SELECT t.*, ta.task_id
                    FROM task_assignments ta
                    JOIN tasks t ON ta.task_id = t.id
                    WHERE ta.employee_id = $employee_id";
            return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
        }catch (Exception $e) {
                error_log("get employee yask error: " . $e->getMessage());
                return [];
        }
    }
}

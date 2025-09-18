<?php
require_once __DIR__ . '/../models/task.php';

class TaskController {
    private $taskModel;

    public function __construct() {
        $this->taskModel = new Task();
    }

    public function index() {
        try {
            $tasks = $this->taskModel->getTasksandemp('','');
            $pageTitle = "Task List";
            include __DIR__ . '/../views/layouts/header.php';
            include __DIR__ . '/../views/tasks/list.php';
            include __DIR__ . '/../views/layouts/footer.php';
        } catch (Exception $e) {
            error_log("TaskController index error: " . $e->getMessage());
            include __DIR__ . '/../views/errors/500.php';
        }
    }

    public function add() {
        try{
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'start_date' => $_POST['start_date'],
                    'due_date' => $_POST['due_date'],
                    'status' => 'Pending',
                    'assigned_by' => $_SESSION['user_id']
                ];
                $this->taskModel->addTask($data);
                header('Location: /tasks');
                exit;
            }
            $pageTitle = "Add Task";
            include __DIR__ . '/../views/tasks/add.php';
        } catch (Exception $e) {
            error_log("TaskController add error: " . $e->getMessage());
            include __DIR__ . '/../views/errors/500.php';
        }
    }

    public function edit($id) {
        try{
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'start_date' => $_POST['start_date'],
                    'due_date' => $_POST['due_date'],
                    'status' => $_POST['status']
                ];
                $this->taskModel->updateTask($id, $data, '');
                header('Location: /tasks');
                exit;
            }
            $task = $this->taskModel->getTasksandemp($id, 'id');
            $pageTitle = "Edit Task";
            include __DIR__ . '/../views/layouts/header.php';
            include __DIR__ . '/../views/tasks/edit.php';
            include __DIR__ . '/../views/layouts/footer.php';
        } catch (Exception $e) {
            error_log("TaskController edit error: " . $e->getMessage());
            include __DIR__ . '/../views/errors/500.php';
        }
    }

    public function delete($id) {
        try{
            $this->taskModel->deleteTask($id);
            header('Location: /tasks');
            exit;
        } catch (Exception $e) {
            error_log("TaskController delete error: " . $e->getMessage());
            include __DIR__ . '/../views/errors/500.php';
        }
    }

    public function assign() {
        try{
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $taskId = $_POST['task_id'];
                $employeeIds = $_POST['employee_ids'];

                $this->taskModel->assignTask($taskId, $employeeIds);

                $taskDetails = $this->taskModel->getTasksandemp($taskId, 'id');

                // Include email function
                require_once __DIR__ . '/../../services/sendmail.php';

                // Loop through employees and send email
                foreach ($employeeIds as $empId) {
                    $employee = $this->taskModel->getTasksandemp($empId, 'emp');

                    if ($employee && $taskDetails) {
                        $recipientEmail = $employee['email'];
                        $subject = "New Task Assigned: " . $taskDetails['title'];
                        $message = "Hello " . $employee['fullname'] . ",\n\n" .
                                "You have been assigned a new task.\n\n" .
                                "Task Details:\n" .
                                "Title: " . $taskDetails['title'] . "\n" .
                                "Start Date: " . $taskDetails['start_date'] . "\n" .
                                "Due Date: " . $taskDetails['due_date'] . "\n\n" .
                                "Please log in to the system for more details.";

                        // Send email
                        sendEmail($recipientEmail, $subject, $message);
                    }
                }

                // Redirect to assigned tasks page
                header('Location: /tasks/assigned');
                exit;
            }

            // For GET request, load assign form
            $tasks = $this->taskModel->getTasksandemp('','');
            $employees = $this->taskModel->getTasksandemp('','emp');
            $pageTitle = "Assign Task";
            include __DIR__ . '/../views/tasks/assign.php';
        } catch (Exception $e) {
            error_log("TaskController assign error: " . $e->getMessage());
            include __DIR__ . '/../views/errors/500.php';
        }
    }

    public function assigned() {
        try{
            if (isset($_POST['update_status'])) {
                $this->taskModel->updateTask($_POST['task_id'], $_POST['status'], 'stat');
            }

            if ($_SESSION['role'] == 'Employee') {
                $assignments = $this->taskModel->getEmployeeTasks($_SESSION['user_id']);
            } else {
                $assignments = $this->taskModel->getAssignments();
            }

            $pageTitle = "Assigned Tasks";
            include __DIR__ . '/../views/layouts/header.php';
            include __DIR__ . '/../views/tasks/emp-task.php';
            include __DIR__ . '/../views/layouts/footer.php';
        } catch (Exception $e) {
            error_log("TaskController assigned error: " . $e->getMessage());
            include __DIR__ . '/../views/errors/500.php';
        }
    }
}
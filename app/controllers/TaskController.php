<?php
require_once __DIR__ . '/../models/Task.php';

class TaskController {
    private $taskModel;

    public function __construct() {
        $this->taskModel = new Task();
    }

    public function index() {
        $tasks = $this->taskModel->getAllTasks();
        $pageTitle = "Task List";
        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/tasks/list.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    public function add() {
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
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'start_date' => $_POST['start_date'],
                'due_date' => $_POST['due_date'],
                'status' => $_POST['status']
            ];
            $this->taskModel->updateTask($id, $data);
            header('Location: /tasks');
            exit;
        }
        $task = $this->taskModel->getTaskById($id);
        $pageTitle = "Edit Task";
        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/tasks/edit.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    public function delete($id) {
        $this->taskModel->deleteTask($id);
        header('Location: /tasks');
        exit;
    }

    public function assign() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = $_POST['task_id'];
            $employeeIds = $_POST['employee_ids'];

            $this->taskModel->assignTask($taskId, $employeeIds);

            $taskDetails = $this->taskModel->getTaskById($taskId);

            // Include email function
            require_once __DIR__ . '/../../sendmail.php';

            // Loop through employees and send email
            foreach ($employeeIds as $empId) {
                $employee = $this->taskModel->getEmployeeById($empId);

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
        $tasks = $this->taskModel->getAllTasks();
        $employees = $this->taskModel->getEmployees();
        $pageTitle = "Assign Task";
        include __DIR__ . '/../views/tasks/assign.php';
    }

    public function assigned() {
        if (isset($_POST['update_status'])) {
            $this->taskModel->updateTaskStatus($_POST['task_id'], $_POST['status']);
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
    }
}
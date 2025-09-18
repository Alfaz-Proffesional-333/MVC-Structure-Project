<?php
require_once __DIR__ . '/../app/controllers/MainController.php';
require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/controllers/TaskController.php';
require_once __DIR__ . '/../app/core/ErrorHandler.php';
ErrorHandler::register();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
    case '/login':
        $controller = new AuthController();
        $controller->login();
        break;

    case '/dashboard':
        $controller = new DashboardController();
        $controller->index();
        break;

    case '/logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case '/users':
        $controller = new UserController();
        $controller->index();
        break;

    case '/manager':
        $controller = new UserController();
        $controller->managers();
        break;

    case '/employee':
        $controller = new UserController();
        $controller->employees();
        break;

    case '/users/add':
        $controller = new UserController();
        $controller->create();
        break;

    case '/users/store':
        $controller = new UserController();
        $controller->store();
        break;

    case '/users/update':
        $controller = new UserController();
        $controller->update();
        break;

     case '/managers':
        $controller = new UserController();
        $controller->managers();
        break;

    case '/employees':
        $controller = new TaskController();
        $controller->create();
        break;

    case '/tasks':
        $controller = new TaskController();
        $controller->index();
        break;
        
    case '/tasks/add':
        $controller = new TaskController();
        $controller->add();
        break;

    case '/tasks/edit':
        $controller = new TaskController();
        $controller->edit();
        break;

    case '/tasks/delete':
        $controller = new TaskController();
        $controller->delete();
        break;

    case '/tasks/assign':
        $controller = new TaskController();
        $controller->assign();
        break;

    case '/tasks/assigned':
        $controller = new TaskController();
        $controller->assigned();
        break;
    default:
        // Dynamic routes for edit/delete
        if (preg_match('#^/tasks/edit/(\d+)$#', $uri, $matches)) {
            (new TaskController())->edit($matches[1]);
        } elseif (preg_match('#^/tasks/delete/(\d+)$#', $uri, $matches)) {
            (new TaskController())->delete($matches[1]);
        } elseif (preg_match('#^/users/edit/(\d+)$#', $uri, $matches)) {
            $controller = new UserController();
            $controller->edit($matches[1]);
        } elseif (preg_match('#^/users/delete/(\d+)$#', $uri, $matches)) {
            $controller = new UserController();
            $controller->delete($matches[1]);
        } else {
            http_response_code(404);
            include __DIR__ . '/../app/views/errors/404.php';
        }
}

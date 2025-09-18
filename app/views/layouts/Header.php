<!DOCTYPE html>
<html>
<head>
    <title>Employee Management System</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="sidebar">
    <div class="sidebar-header">
        <?php $id = $_SESSION['user_id'];?>
        <a href="/users/edit/<?= $id ?>">
            <img src="/assets/logo.png" alt="Logo" class="sidebar-logo">
        </a>
        <div class="sidebar-username"><?php echo $_SESSION['fullname']; ?></div>
        <small>(<?php echo $_SESSION['role']; ?>)</small>
    </div>
    <div class="sidebar-menu">
        <ul>
            <?php if ($_SESSION['role'] == 'Admin') { ?>
                <li><a href="/dashboard">📊 Dashboard</a></li>
                <li><a href="/users">⚙️ User Management</a></li>
                <li><a href="/manager">👨‍💼 Managers</a></li>
                <li><a href="/employee">👨‍💻 Employees</a></li>
                <li><a href="/tasks">📝 Tasks List</a></li>
                <li><a href="/tasks/assigned">📝 Assigned Tasks</a></li>
            <?php } elseif ($_SESSION['role'] == 'Manager') { ?>
                <li><a href="/employee">👨‍💻 Employees</a></li>
                <li><a href="/tasks">📝 Tasks List</a></li>
                <li><a href="/tasks/assigned">📝 Assigned Tasks</a></li>
            <?php } elseif ($_SESSION['role'] == 'Employee') { ?>
                <li><a href="/tasks/assigned">📝 My Tasks</a></li>
            <?php } ?>
            <li><a href="/logout">🚪 Logout</a></li>
        </ul>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <div class="topbar-left"><h2>Employee Management System</h2></div>
        <div class="topbar-right">
            <a href="/logout"><button class="btn btn-danger">Logout</button></a>
        </div>
    </div>
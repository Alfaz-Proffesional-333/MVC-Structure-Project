<main class="container">
<?php if ($_SESSION['role'] == 'Employee') { ?>
    <div class="employee">
        <h1>My Task List</h1>
    </div>
    <table class="entity-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assignments as $i => $row) { ?>
            <tr>
                <td><?= $i+1; ?></td>
                <td><?= $row['title']; ?></td>
                <td><?= $row['description']; ?></td>
                <td><?= $row['start_date']; ?></td>
                <td><?= $row['due_date']; ?></td>
                <td>
                    <form method="POST" action="/tasks/assigned" style="display:flex; gap:5px;">
                        <input type="hidden" name="task_id" value="<?= $row['task_id']; ?>">
                        <select name="status">
                            <option value="Pending" <?= $row['status']=="Pending"?'selected':''; ?>>Pending</option>
                            <option value="In Progress" <?= $row['status']=="In Progress"?'selected':''; ?>>In Progress</option>
                            <option value="Completed" <?= $row['status']=="Completed"?'selected':''; ?>>Completed</option>
                        </select>
                </td>
                <td>
                        <button type="submit" class="btn btn-success" name="update_status">Update</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>

<?php if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Manager') { ?>
    <div class="admin">
        <h1>Task Assignments</h1>
    </div>
    <table class="entity-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Task</th>
                <th>Employee</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assignments as $i => $row) { ?>
            <tr>
                <td><?= $i+1; ?></td>
                <td><?= htmlspecialchars($row['task_title']); ?></td>
                <td><?= htmlspecialchars($row['employee_name']); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
</main>

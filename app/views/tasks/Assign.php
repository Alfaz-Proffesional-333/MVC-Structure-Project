<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="container mt-5">
    <div class="card shadow p-4 rounded">
        <h2 class="text-center mb-4">Assign Task to Employee</h2>
        <form method="POST" action="/tasks/assign">
            <div class="mb-3">
                <label class="form-label">Select Task:</label>
                <select name="task_id" class="form-control" required>
                    <?php foreach ($tasks as $task): ?>
                        <option value="<?= $task['id']; ?>"><?= htmlspecialchars($task['title']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Select Employees:</label>
                <select name="employee_ids[]" class="form-control" multiple required>
                    <?php foreach ($employees as $emp): ?>
                        <option value="<?= $emp['id']; ?>"><?= htmlspecialchars($emp['fullname']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Assign Task</button>
            <a href="/tasks" class="btn btn-link mt-2">Back To Task List</a>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

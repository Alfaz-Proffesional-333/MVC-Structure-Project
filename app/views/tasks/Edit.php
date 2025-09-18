<main class="container mt-5">
    <div class="card shadow p-4 rounded">
        <h2 class="text-center mb-4">Update Task</h2>
        <form method="POST" action="/tasks/edit/<?= $task['id']; ?>">
            <!-- Title -->
            <div class="mb-3">
                <label class="form-label">Task Title</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($task['title']); ?>" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($task['description']); ?></textarea>
            </div>

            <!-- Start Date -->
            <div class="mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="<?= $task['start_date']; ?>" required>
            </div>

            <!-- Due Date -->
            <div class="mb-3">
                <label class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control" value="<?= $task['due_date']; ?>" required>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="Pending" <?= $task['status']=="Pending"?'selected':''; ?>>Pending</option>
                    <option value="In Progress" <?= $task['status']=="In Progress"?'selected':''; ?>>In Progress</option>
                    <option value="Completed" <?= $task['status']=="Completed"?'selected':''; ?>>Completed</option>
                </select>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary w-100">Update Task</button><br><br>
            <a href="/tasks">Back To Task List</a>
        </form>
    </div>
</main>
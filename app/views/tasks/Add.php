<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="container mt-5">
    <div class="card shadow p-4 rounded">
        <h2 class="text-center mb-4">Add New Task</h2>
        <form method="POST" action="/tasks/add">
            <!-- Title -->
            <div class="mb-3">
                <label class="form-label">Task Title</label>
                <input type="text" name="title" class="form-control" pattern="^[A-Za-z0-9 ,.()-]{3,100}$" title="Title should be 3-100 characters" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <!-- Start Date -->
            <div class="mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" min="<?= date('Y-m-d'); ?>" required>
            </div>

            <!-- Due Date -->
            <div class="mb-3">
                <label class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control" min="<?= date('Y-m-d'); ?>" required>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="">-- Select Status --</option>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary w-100">Save Task</button><br><br>
            <a href="/tasks">Back To Task List</a>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
    
<main class="container">
    <div class="employee">
      <h1>Task List</h1>
      <div>
        <a href="/tasks/assign"><button class="btn btn-primary">Send Task</button></a>
        <a href="/tasks/add"><button class="btn btn-primary">Add Task</button></a>
      </div>
    </div>
    <table class="entity-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Description</th>
          <th>Start Date</th>
          <th>Due Date</th>
          <th>Status</th>
          <th>assigned by(Id)</th>
          <th>action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tasks as $row): ?>
        <tr>
          <td><?= $row['id'];; ?></td>
          <td><?= $row['title']; ?></td>
          <td><?= $row['description']; ?></td>
          <td><?= $row['start_date']; ?></td>
          <td><?= $row['due_date']; ?></td>
          <td><?= $row['status']; ?></td>
          <td><?= $row['assigned_by']; ?></td>
          <td>
            <a href="/tasks/edit/<?= $row['id'] ?>"><button class="btn btn-success" style="margin-bottom: 5px;">Edit</button></a>
            <a href="/tasks/delete/<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this Task?');"><button class="btn btn-danger">Delete</button></a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>
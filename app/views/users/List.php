<div style="display: flex; justify-content: space-between;">
<h2><?= $pageTitle ?></h2>
<?php if ($_SESSION['role'] === 'Admin'): ?>
<a href="/users/add"><button class="btn btn-primary">Add User</button></a>
<?php endif; ?>

</div>
<table class="entity-table" style="text-align: center">
    <tr>
        <th>Full Name</th><th>Email</th><th>Department</th><th>Job Title</th><th>Role</th>
        <?php if ($_SESSION['role'] === 'Admin'): ?>
        <th>Actions</th>
        <?php endif; ?>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['fullname'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['department'] ?></td>
            <td><?= $user['job_title'] ?></td>
            <td><?= $user['role'] ?></td>
            <?php if ($_SESSION['role'] === 'Admin'): ?>
            <td>
                <a href="/users/edit/<?= $user['id'] ?>"><button class="btn btn-success" style="margin-bottom: 5px;">Edit</button></a>
                <a href="/users/delete/<?= $user['id'] ?>" onclick="return confirm('Are you sure?')"><button class="btn btn-danger">Delete</button></a>
            </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>

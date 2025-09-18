<main class="container mt-5">
  <div class="card shadow p-4 rounded">
    <h2><?php echo $pageTitle; ?></h2>
    <form method="POST" action="/users/update">
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <input type="text" name="fullname" class="form-control" value="<?= $user['fullname'] ?>"
              pattern="^[A-Za-z0-9 ]{6,50}$" 
              title="Full name should only contain letters, numbers and spaces (6-50 characters)" 
              required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email Address</label> 
        <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" 
          pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z.-]+\.[A-Za-z]{2,}$" 
          title="Enter a valid email address (example: user@example.com)" 
          required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label> 
        <input type="password" name="password" class="form-control" value="<?= $user['hash_password'] ?>" 
          pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{6,20}$" 
          title="Password must be 6-20 characters, include uppercase, lowercase, number, and special character" 
          required>
      </div>

      <div class="mb-3">
        <label class="form-label">Department</label> 
        <input type="text" name="department" class="form-control" required value="<?= $user['department'] ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Job Title</label> 
        <input type="text" name="job" class="form-control" required value="<?= $user['job_title'] ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Role</label>
          <select name="role" class="form-control" required>
            <option value="Manager" <?= $user['role'] == 'Manager' ? 'selected' : '' ?>>Manager</option>
            <option value="Employee" <?= $user['role'] == 'Employee' ? 'selected' : '' ?>>Employee</option>
          </select>
    </div>

      <button type="submit" name="submit" class="btn btn-primary w-100">Save User</button><br><br>
    </form>
  </div>
</main>
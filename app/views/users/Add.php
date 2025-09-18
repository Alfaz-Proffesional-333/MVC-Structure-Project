<main class="container mt-5">
  <div class="card shadow p-4 rounded">
    <h2><?php echo $pageTitle; ?></h2>
    <form method="POST" action="/users/store">
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="fullname" class="form-control" 
              
              title="Full name should only contain letters and spaces (6-50 characters)" 
              required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" 
          pattern="^[a-zA-Z._%+-]+@[a-zA-Z.-]+\.[A-Za-z]{2,}$" 
          title="Enter a valid email address (example: user@example.com)" 
          required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" 
          pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{6,20}$" 
          title="Password must be 6-20 characters, include uppercase, lowercase, number, and special character" 
          required>
      </div>

      <div class="mb-3">
        <label class="form-label">Department</label>
        <input type="text" name="department" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Job Title</label>
        <input type="text" name="job" class="form-control" required>
      </div>

      <div class="mb-3">
          <label class="form-label">Role</label>
          <select name="role" class="form-control" required>
              <option value="Manager">Manager</option>
              <option value="Employee">Employee</option>
          </select>
      </div>

      <button type="submit" name="submit" class="btn btn-primary w-100">Save User</button><br><br>
    </form>
  </div>
</main>
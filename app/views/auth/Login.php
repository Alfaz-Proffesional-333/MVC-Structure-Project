<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="/assets/styles.css">
</head>
<body class="login-page">
<div class="login-container">
    <h2>Login</h2>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit" name="submit">Login</button>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </form>
</div>
</body>
</html>

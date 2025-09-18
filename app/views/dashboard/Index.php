<main class="container">
    <h1>Dashboard</h1>
    <div class="stats-grid">
        <div class="stat-block block-leaders">Admins 👑<span class="stat-number"><?php echo $admCount; ?></span></div>
        <div class="stat-block block-managers">Managers 👨‍💼<span class="stat-number"><?php echo $manCount; ?></span></div>
        <div class="stat-block block-employees">Employees 👨‍💻<span class="stat-number"><?php echo $empCount; ?></span></div>
        <div class="stat-block block-projects">Project 📂<span class="stat-number"><?php echo $taskCount; ?></span></div>
    </div>
    <div class="stats-grid">
        <div class="stat-block block-projects">Task Completed ✅<span class="stat-number"><?php echo $taskcomplete; ?></span></div>
        <div class="stat-block block-leaders">Task Pending ⏳<span class="stat-number"><?php echo $taskpending; ?></span></div>
        <div class="stat-block block-managers">Task In Progress 🔄<span class="stat-number"><?php echo $taskprogress; ?></span></div>
        <div class="stat-block block-employees">Task Canceled ❌<span class="stat-number"><?php echo $taskcancel; ?></span></div>
    </div>
</main>

<!DOCTYPE html>
<html>
<head>
    <title>My Goals Progress</title>
    <link rel="stylesheet" href="/fitnesstracker/public/assets/css/style.css">
</head>
<body>
    <?php require_once ROOT . '/app/views/part/header.php'; ?>

    <h2>My Goal Progress</h2>
    
    <a href="?controller=goal&action=create">+ Create New Goal</a><br><br>

    <div id="goals-container">
        <div class="card">
            <h3>Goal Title Here</h3>
            <p>Target: 100 units</p>
            <p>Deadline: 2025-12-31</p>
            <p>Progress: <span class="progress-value">50</span>%</p>
            <progress value="50" max="100"></progress>

            <form method="POST" action="?controller=goal&action=updateProgress" class="update-form">
                <input type="hidden" name="goal_id" value="GOAL_ID_HERE">
                <label>Update Progress (%):</label>
                <input type="number" name="progress" min="0" max="100" required>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>

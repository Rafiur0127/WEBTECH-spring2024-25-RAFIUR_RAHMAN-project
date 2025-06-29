<?php require_once ROOT . '/app/views/part/header.php'; ?>

<style>
    .goals-container {
        max-width: 800px;
        margin: 40px auto;
        font-family: Arial, sans-serif;
    }

    .goals-container h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 30px;
    }

    .goal-card {
        border: 1px solid #ddd;
        border-left: 6px solid #3498db;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .goal-card.completed {
        border-left-color: #2ecc71;
        background: #ecf9f1;
    }

    .goal-card h3 {
        margin: 0 0 10px;
        color: #34495e;
    }

    .goal-card p {
        margin: 6px 0;
        color: #555;
    }

    .goal-card .progress-bar {
        background: #e1e1e1;
        height: 10px;
        border-radius: 5px;
        overflow: hidden;
        margin: 10px 0;
    }

    .goal-card .progress-bar span {
        display: block;
        height: 100%;
        background: #3498db;
    }

    .goal-card.completed .progress-bar span {
        background: #2ecc71;
    }

    form.update-form {
        margin-top: 12px;
    }

    form.update-form input[type="number"] {
        padding: 8px;
        width: 120px;
        margin-right: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    form.update-form button {
        padding: 8px 14px;
        background: #3498db;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
    }

    form.update-form button:hover {
        background: #2980b9;
    }

    .success-message {
        text-align: center;
        color: green;
        margin-bottom: 20px;
    }

    .empty-msg {
        text-align: center;
        font-size: 1.1rem;
        color: #888;
    }

    .empty-msg a {
        color: #3498db;
        text-decoration: none;
        font-weight: bold;
    }

    .empty-msg a:hover {
        text-decoration: underline;
    }

    @media (max-width: 600px) {
        form.update-form input[type="number"] {
            width: 100px;
        }
        form.update-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<div class="goals-container">
    <h2>Your Goals</h2>

    <?php if (!empty($message)): ?>
        <div class="success-message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (empty($goals)): ?>
        <div class="empty-msg">No goals yet. <a href="?controller=goal&action=create">Create one now!</a></div>
    <?php else: ?>
        <?php foreach ($goals as $goal): 
            $progress_percent = ($goal['target_value'] > 0) ? round(($goal['current_value'] / $goal['target_value']) * 100) : 0;
            $is_completed = ($goal['status'] === 'completed');
        ?>
        <div class="goal-card <?= $is_completed ? 'completed' : '' ?>">
            <h3><?= htmlspecialchars($goal['title']) ?> <?= $is_completed ? "" : "" ?></h3>
            <p><?= nl2br(htmlspecialchars($goal['description'])) ?></p>

            <div class="progress-bar">
                <span style="width: <?= $progress_percent ?>%"></span>
            </div>

            <p><strong>Progress:</strong> <?= $goal['current_value'] ?> / <?= $goal['target_value'] ?> <?= htmlspecialchars($goal['unit']) ?> (<?= $progress_percent ?>%)</p>
            <p><strong>Status:</strong> <?= $is_completed ? ' Completed' : 'Ongoing' ?></p>

            <?php if (!$is_completed): ?>
                <form class="update-form" method="POST">
                    <input type="hidden" name="goal_id" value="<?= $goal['id'] ?>">
                    <label for="new_value_<?= $goal['id'] ?>">Update Progress:</label>
                    <input type="number" name="new_value" id="new_value_<?= $goal['id'] ?>" min="<?= $goal['current_value'] ?>" max="<?= $goal['target_value'] ?>" required>
                    <button type="submit">Update</button>
                </form>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

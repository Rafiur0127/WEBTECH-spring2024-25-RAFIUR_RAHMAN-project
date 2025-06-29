<?php require_once(ROOT . '/app/views/part/header.php'); ?>

<style>
    .update-progress-container {
        max-width: 500px;
        margin: 40px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    .update-progress-container h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 25px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
        color: #34495e;
    }

    input[type="number"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1rem;
    }

    .error-messages {
        color: #e74c3c;
        margin-bottom: 15px;
        text-align: center;
    }

    button {
        background-color: #2ecc71;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #27ae60;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        text-decoration: none;
        color: #2980b9;
        font-weight: bold;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 480px) {
        .update-progress-container {
            padding: 20px;
        }

        input, button {
            font-size: 0.95rem;
        }
    }
</style>

<div class="update-progress-container">
    <h2>Update Progress for: <br> <?= htmlspecialchars($goal['title']) ?></h2>

    <?php if (!empty($errors)): ?>
        <div class="error-messages">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="current_value">Current Progress (<?= htmlspecialchars($goal['unit']) ?>)</label>
        <input type="number" name="current_value" id="current_value"
               min="0"
               max="<?= (int)$goal['target_value'] ?>"
               required
               value="<?= (int)$goal['current_value'] ?>">

        <button type="submit">Update Progress</button>
    </form>

    <a class="back-link" href="?controller=goal&action=list">← Back to Goals</a>
</div>

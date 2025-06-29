<?php require_once ROOT . '/app/views/part/header.php'; ?>

<style>
    .goal-form-container {
        max-width: 600px;
        margin: 40px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    .goal-form-container h2 {
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

    input[type="text"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1rem;
    }

    textarea {
        resize: vertical;
        min-height: 80px;
    }

    .error {
        color: #e74c3c;
        margin-bottom: 15px;
        text-align: center;
    }

    button {
        background-color: #3498db;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #2980b9;
    }

    @media (max-width: 480px) {
        .goal-form-container {
            padding: 20px;
        }

        input, textarea, button {
            font-size: 0.95rem;
        }
    }
</style>

<div class="goal-form-container">
    <h2>Set a New Goal</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="?controller=goal&action=store">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" placeholder="Optional notes..."></textarea>

        <label for="target_value">Target Value</label>
        <input type="number" name="target_value" id="target_value" required min="1">

        <label for="unit">Unit (e.g. km, lbs)</label>
        <input type="text" name="unit" id="unit" placeholder="Optional">

        <button type="submit">Create Goal</button>
    </form>
</div>

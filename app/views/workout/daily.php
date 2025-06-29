<?php require_once ROOT . '/app/views/part/header.php'; ?>

<style>
    .today-container {
        max-width: 700px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        font-family: Arial, sans-serif;
    }

    .today-container h1 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .today-container h2 {
        text-align: center;
        color: #3498db;
        margin-bottom: 25px;
    }

    ul.exercise-list {
        list-style: none;
        padding: 0;
    }

    ul.exercise-list li {
        background: #f8f9fa;
        margin: 10px 0;
        padding: 15px;
        border-left: 6px solid #3498db;
        border-radius: 6px;
        font-size: 1rem;
        color: #333;
    }

    .no-workout {
        text-align: center;
        color: #888;
        font-size: 1.1rem;
    }

    @media (max-width: 600px) {
        .today-container {
            padding: 20px;
        }
        ul.exercise-list li {
            font-size: 0.95rem;
        }
    }
</style>

<div class="today-container">
    <h1>Today's Workout</h1>

    <?php if ($workout): ?>
        <h2><?= htmlspecialchars($workout['workout_name']) ?></h2>
        <ul class="exercise-list">
            <?php while ($exercise = $exercises->fetch_assoc()): ?>
                <li>
                    <?= htmlspecialchars($exercise['exercise_name']) ?> — 
                    <strong>Sets:</strong> <?= $exercise['sets'] ?>, 
                    <strong>Reps:</strong> <?= $exercise['reps'] ?>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p class="no-workout">No workout scheduled for today. </p>
    <?php endif; ?>
</div>

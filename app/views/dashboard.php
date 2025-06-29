<?php require_once ROOT . '/app/views/part/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fitness Tracker Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .dashboard-container {
            padding: 20px;
            max-width: 1100px;
            margin: auto;
            font-family: Arial, sans-serif;
        }

        .notification-box {
            background-color: #ecf0f1;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card h4, .card h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .card p, .card ul, .card li {
            margin: 4px 0;
            padding: 0;
            list-style: none;
        }

        .card a {
            text-decoration: none;
            background-color: #2980b9;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 10px;
        }

        .goal-item {
            background: #fdfdfd;
            padding: 12px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.06);
            margin-bottom: 10px;
            text-align: left;
        }

        .goal-item span {
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .dashboard-container {
                padding: 10px;
            }

            .card {
                padding: 12px;
            }

            .card a {
                font-size: 14px;
                padding: 5px 10px;
            }
        }
    </style>
</head>
<body>

<div class="dashboard-container">

    <div class="notification-box">
        <h3>Workout Reminder</h3>
        <?php if (!empty($todayExercises)): ?>
            <ul>
                <?php foreach ($todayExercises as $exercise): ?>
                    <li><?= htmlspecialchars($exercise['exercise_name']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No workouts scheduled today. Enjoy your rest!</p>
        <?php endif; ?>
    </div>

    <div class="summary-cards">

        <div class="card">
            <h4>Today's Macros</h4>
            <p><?= $macros['calories'] ?? 0 ?> kcal</p>
            <p>Carbs: <?= $macros['carbs'] ?? 0 ?>g</p>
            <p>Protein: <?= $macros['protein'] ?? 0 ?>g</p>
            <p>Fat: <?= $macros['fat'] ?? 0 ?>g</p>
            <a href="?controller=nutrition&action=macroDashboard">View Full</a>
        </div>

        <div class="card">
            <h3>Achievements</h3>
            <?php if (!empty($completedGoals)): ?>
                <?php foreach ($completedGoals as $goal): ?>
                    <div>
                         <?= htmlspecialchars($goal['title']) ?> (<?= $goal['target_value'] ?> <?= $goal['unit'] ?>) - Completed!
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No completed goals yet. Keep going! </p>
            <?php endif; ?>
        </div>

        <div class="card">
            <h4>Ongoing Goals</h4>
            <?php if (!empty($activeGoals)): ?>
                <?php foreach ($activeGoals as $goal): ?>
                    <?php
                        $title = htmlspecialchars($goal['title']);
                        $current = (int)$goal['current_value'];
                        $target = (int)$goal['target_value'];
                        $unit = htmlspecialchars($goal['unit']);
                        $progress = $target > 0 ? round(($current / $target) * 100, 1) : 0;
                        $status = $goal['status'] === 'completed' ? 'Completed' : 'Ongoing';
                    ?>
                    <div class="goal-item">
                        <span><?= $title ?></span><br>
                        <?= $current ?>/<?= $target ?> <?= $unit ?> (<?= $progress ?>%)<br>
                        Status: <?= $status ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No active goals. Set one to start your journey!</p>
            <?php endif; ?>
        </div>

    </div>
</div>

</body>
</html>

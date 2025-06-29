<?php require_once ROOT . '/app/views/part/header.php'; ?>
<style>
.macro-container {
    max-width: 600px;
    margin: 30px auto;
    font-family: Arial, sans-serif;
    padding: 15px;
}
h2 {
    text-align: center;
}
.macro-box {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}
.calories-box {
    font-size: 1.1em;
    font-weight: bold;
    text-align: center;
    background: #eaf2ff;
}
h3 {
    margin-top: 0;
    margin-bottom: 10px;
}
.macro-progress {
    background: #ddd;
    border-radius: 20px;
    overflow: hidden;
    height: 24px;
    margin-bottom: 15px;
}
.macro-progress-bar {
    height: 100%;
    border-radius: 20px;
    text-align: right;
    padding-right: 10px;
    color: #fff;
    line-height: 24px;
    font-weight: bold;
    font-size: 0.9em;
}
.carbs { background-color: #ffb347; }
.protein { background-color: #77dd77; }
.fat { background-color: #ff6961; }

.goal-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.goal-form label {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.goal-form input {
    padding: 6px 10px;
    width: 100px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.goal-form button {
    padding: 10px;
    font-weight: bold;
    background: #2c3e50;
    color: white;
    border: none;
    border-radius: 5px;
    margin-top: 10px;
    cursor: pointer;
}
.goal-form button:hover {
    background: #1d2a36;
}

@media (max-width: 500px) {
    .goal-form label {
        flex-direction: column;
        align-items: flex-start;
    }
    .goal-form input {
        width: 100%;
    }
}
</style>


<div class="macro-container">
    <h2> Macro Dashboard</h2>

    <?php if ($macros && $macroGoals): ?>
        <div class="macro-box calories-box">
            <strong>Calories:</strong> <?= $macros['calories'] ?? 0 ?> / <?= $macroGoals['calories'] ?? 0 ?>
        </div>

        <?php
        function percent($value, $goal) {
            if ($goal == 0) return 0;
            $p = round(($value / $goal) * 100);
            return ($p > 100) ? 100 : $p;
        }
        ?>

        <div class="macro-box">
            <h3>Carbohydrates</h3>
            <div class="macro-progress">
                <div class="macro-progress-bar carbs" style="width: <?= percent($macros['carbs'], $macroGoals['carbs']) ?>%;">
                    <?= $macros['carbs'] ?? 0 ?>g / <?= $macroGoals['carbs'] ?? 0 ?>g (<?= percent($macros['carbs'], $macroGoals['carbs']) ?>%)
                </div>
            </div>

            <h3>Protein</h3>
            <div class="macro-progress">
                <div class="macro-progress-bar protein" style="width: <?= percent($macros['protein'], $macroGoals['protein']) ?>%;">
                    <?= $macros['protein'] ?? 0 ?>g / <?= $macroGoals['protein'] ?? 0 ?>g (<?= percent($macros['protein'], $macroGoals['protein']) ?>%)
                </div>
            </div>

            <h3>Fat</h3>
            <div class="macro-progress">
                <div class="macro-progress-bar fat" style="width: <?= percent($macros['fat'], $macroGoals['fat']) ?>%;">
                    <?= $macros['fat'] ?? 0 ?>g / <?= $macroGoals['fat'] ?? 0 ?>g (<?= percent($macros['fat'], $macroGoals['fat']) ?>%)
                </div>
            </div>
        </div>
    <?php else: ?>
        <p>No macro data available today.</p>
    <?php endif; ?>

    <div class="macro-box">
        <h3>Set or Update Your Macro Goals</h3>
            <form method="POST" action="?controller=nutrition&action=saveMacroGoals" class="goal-form">
            <label>Calories:
                <input type="number" name="calories" value="<?= $macroGoals['calories'] ?? 0 ?>" required>
            </label>
            <label>Carbs (g):
                <input type="number" name="carbs" value="<?= $macroGoals['carbs'] ?? 0 ?>" required>
            </label>
            <label>Protein (g):
                <input type="number" name="protein" value="<?= $macroGoals['protein'] ?? 0 ?>" required>
            </label>
            <label>Fat (g):
                <input type="number" name="fat" value="<?= $macroGoals['fat'] ?? 0 ?>" required>
            </label>
            <button type="submit">Save Goals</button>
        </form>
    </div>
</div>


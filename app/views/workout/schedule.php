<?php require_once ROOT . '/app/views/part/header.php'; ?>
<link rel="stylesheet" href="/public/css/schedule-editor.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/public/js/schedule-editor.js" defer></script>

<div class="container">
    <h1>Workout Schedule Editor</h1>

    <div class="workout-pool">
        <h2>Available Workouts</h2>
        <?php while ($workout = $workouts->fetch_assoc()): ?>
            <div class="draggable-workout" draggable="true" data-id="<?= $workout['id'] ?>">
                <?= htmlspecialchars($workout['workout_name']) ?>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="schedule-grid">
        <?php 
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        $schedule_map = [];
        foreach ($schedule as $s) {
            $schedule_map[$s['week_number']][$s['day_of_week']] = $s;
        }

        for ($week = 1; $week <= 12; $week++): ?>
            <div class="week-row">
                <strong>Week <?= $week ?></strong>
                <?php foreach ($days as $day): 
                    $cell = $schedule_map[$week][$day] ?? null;
                    ?>
                    <div class="schedule-cell <?= $cell ? 'filled' : '' ?>" 
                        data-week="<?= $week ?>" data-day="<?= $day ?>"
                        ondragover="event.preventDefault();" 
                        ondrop="dropWorkout(event, this)">
                        <?php if ($cell): ?>
                            <div class="draggable-workout" draggable="true" data-id="<?= $cell['workout_id'] ?>">
                                <?= htmlspecialchars($cell['workout_name']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    </div>

    <button id="saveScheduleBtn"> Save Schedule</button>
    <p id="saveStatus" style="margin-top: 10px;"></p>
</div>

<?php require_once ROOT . '/app/views/part/footer.php'; ?>

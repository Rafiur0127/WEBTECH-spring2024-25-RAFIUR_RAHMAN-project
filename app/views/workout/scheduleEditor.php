<?php require_once ROOT . '/app/views/part/header.php'; ?>
<style>
  body {
    font-family: Arial, sans-serif;
    padding: 20px;
    background: #f7f9fc;
  }
  h1 {
    text-align: center;
    margin-bottom: 10px;
  }
  p {
    text-align: center;
    margin-bottom: 25px;
    color: #555;
  }

  #workoutsPool {
    border: 1px solid #ccc;
    padding: 15px;
    margin-bottom: 20px;
    background: #fff;
    border-radius: 8px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
  }
  #workoutsPool h3 {
    margin-top: 0;
    margin-bottom: 15px;
    color: #333;
  }
  .workout-item {
    padding: 8px 12px;
    margin: 6px 4px;
    border: 1.5px solid #444;
    border-radius: 6px;
    cursor: grab;
    background: #e3e6ee;
    user-select: none;
    transition: background-color 0.3s ease;
  }
  .workout-item:active {
    cursor: grabbing;
    background-color: #c1c6d9;
  }

  .table-wrapper {
    overflow-x: auto;
    margin: 0 auto 30px;
    max-width: 100%;
    background: #fff;
    border-radius: 8px;
    padding: 10px;
    box-shadow: 0 1px 6px rgba(0,0,0,0.1);
  }

  table {
    border-collapse: collapse;
    width: 100%;
    min-width: 600px; 
  }
  thead th {
    background: #2c3e50;
    color: white;
    padding: 10px 8px;
    font-weight: 600;
    text-align: center;
    position: sticky;
    top: 0;
    z-index: 2;
  }
  tbody td {
    background: #f9f9f9;
    vertical-align: top;
    border: 1px solid #ddd;
    min-height: 60px;
    padding: 5px 8px;
  }

  .schedule-cell {
    transition: background-color 0.2s ease;
  }
  .schedule-cell:hover {
    background-color: #e0e7ff;
  }

  .schedule-cell .workout-item {
    background: #8faadc;
    border-color: #536bae;
    color: white;
    cursor: grab;
  }
  .schedule-cell .workout-item:active {
    background: #5b74b1;
  }

  #saveScheduleBtn {
    display: block;
    margin: 10px auto 30px;
    padding: 12px 28px;
    font-size: 16px;
    font-weight: 600;
    background-color: #2980b9;
    border: none;
    border-radius: 6px;
    color: white;
    cursor: pointer;
    box-shadow: 0 3px 8px rgba(41, 128, 185, 0.4);
    transition: background-color 0.3s ease;
  }
  #saveScheduleBtn:hover {
    background-color: #1c5d8b;
  }

  #saveStatus {
    text-align: center;
    font-weight: 600;
    min-height: 1.5em;
  }

  @media (max-width: 650px) {
    #workoutsPool {
      max-width: 100%;
      padding: 12px;
    }
    table {
      min-width: 500px;
    }
    .workout-item {
      font-size: 14px;
      padding: 6px 10px;
    }
    #saveScheduleBtn {
      width: 90%;
      font-size: 14px;
      padding: 10px;
    }
  }
</style>

<h1>Schedule Editor</h1>
<p>Drag workouts onto the schedule below, then click "Save Schedule".</p>

<?php
$workoutList = [];
while ($w = $workouts->fetch_assoc()) {
    $workoutList[] = $w;
}
?>

<div id="workoutsPool">
    <h3>Available Workouts</h3>
    <?php foreach ($workoutList as $workout): ?>
        <div class="workout-item" draggable="true" data-workout-id="<?= $workout['id'] ?>">
            <?= htmlspecialchars($workout['workout_name']) ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="table-wrapper">
<table>
    <thead>
        <tr>
            <th>Week \ Day</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
            <th>Sunday</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $weeksToShow = 4;
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        for ($week = 1; $week <= $weeksToShow; $week++): ?>
        <tr>
            <td>Week <?= $week ?></td>
            <?php foreach ($daysOfWeek as $day): ?>
            <td class="schedule-cell" data-week="<?= $week ?>" data-day="<?= $day ?>" 
                ondragover="event.preventDefault();" 
                ondrop="dropWorkout(event, this)">

                <?php
                $scheduledWorkoutName = '';
                $scheduledWorkoutId = null;

                foreach ($scheduleItems as $item) {
                    if ($item['week_number'] == $week && $item['day_of_week'] == $day) {
                        foreach ($workoutList as $w) {
                            if ($w['id'] == $item['workout_id']) {
                                $scheduledWorkoutName = $w['workout_name'];
                                $scheduledWorkoutId = $w['id'];
                                break 2;
                            }
                        }
                    }
                }

                if (!empty($scheduledWorkoutName)): ?>
                    <div class="workout-item" draggable="true" data-workout-id="<?= $scheduledWorkoutId ?>" 
                        ondragstart="dragWorkout(event)">
                        <?= htmlspecialchars($scheduledWorkoutName) ?>
                    </div>
                <?php endif; ?>
            </td>
            <?php endforeach; ?>
        </tr>
        <?php endfor; ?>
    </tbody>
</table>
</div>

<button id="saveScheduleBtn">Save Schedule</button>
<div id="saveStatus"></div>

<script>
let draggedWorkoutId = null;

function dragWorkout(event) {
    draggedWorkoutId = event.target.getAttribute('data-workout-id');
    event.dataTransfer.setData('text/plain', event.target.textContent);
}

function dropWorkout(event, targetCell) {
    event.preventDefault();
    if (!draggedWorkoutId) return;

    let existingWorkout = targetCell.querySelector('.workout-item');
    if (existingWorkout) existingWorkout.remove();

    let newDiv = document.createElement('div');
    newDiv.className = 'workout-item';
    newDiv.setAttribute('draggable', 'true');
    newDiv.setAttribute('data-workout-id', draggedWorkoutId);
    newDiv.textContent = event.dataTransfer.getData('text/plain') || "Workout";
    newDiv.style.padding = '5px';
    newDiv.style.margin = '5px';
    newDiv.style.border = '1px solid #444';
    newDiv.style.cursor = 'pointer';
    newDiv.addEventListener('dragstart', dragWorkout);

    targetCell.appendChild(newDiv);
    draggedWorkoutId = null;
}

document.querySelectorAll('#workoutsPool .workout-item').forEach(item => {
    item.addEventListener('dragstart', dragWorkout);
});

document.getElementById('saveScheduleBtn').addEventListener('click', () => {
    let scheduleData = [];

    document.querySelectorAll('.schedule-cell').forEach(cell => {
        let week = cell.getAttribute('data-week');
        let day = cell.getAttribute('data-day');
        let workoutDiv = cell.querySelector('.workout-item');
        if (workoutDiv) {
            let workoutId = workoutDiv.getAttribute('data-workout-id');
            scheduleData.push({
                week_number: week,
                day_of_week: day,
                workout_id: workoutId
            });
        }
    });

    fetch('?controller=workout&action=saveSchedule', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'schedule=' + encodeURIComponent(JSON.stringify(scheduleData))
    })
    .then(response => response.text())
    .then(text => {
        const statusDiv = document.getElementById('saveStatus');
        if (text.trim() === 'saved') {
            statusDiv.style.color = 'green';
            statusDiv.textContent = ' Schedule saved successfully!';
        } else {
            statusDiv.style.color = 'red';
            statusDiv.textContent = ' Error saving schedule.';
        }
    })
    .catch(() => {
        const statusDiv = document.getElementById('saveStatus');
        statusDiv.style.color = 'red';
        statusDiv.textContent = 'AJAX request failed.';
    });
});
</script>

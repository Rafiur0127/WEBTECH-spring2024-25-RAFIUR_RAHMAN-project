<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require ROOT . '/config/database.php';

require_once ROOT . '/app/models/WorkoutModel.php';

function catalog() {
    global $conn;
    // List all programs
    $programs = getAllPrograms($conn);
    require ROOT . '/app/views/workout/catalog.php';
}

function viewProgram() {
    global $conn;

    $program_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($program_id <= 0) {
        echo "Invalid program ID.";
        exit;
    }

    $program = getProgramById($conn, $program_id);
    if (!$program) {
        echo "Program not found.";
        exit;
    }

    $workouts = getWorkoutsByProgram($conn, $program_id);

    require ROOT . '/app/views/workout/viewProgram.php';
}

function showDailyWorkout() {
    global $conn;
    $user_id = $_SESSION['user']['id'] ?? 0;

    if (!$user_id) {
        echo "Please login.";
        exit;
    }

    // Get user program info
    $userProgram = getUserProgram($conn, $user_id);
    if (!$userProgram) {
        echo "No program enrolled.";
        exit;
    }

    // Calculate current week number based on start date
    $currentWeek = getCurrentWeek($userProgram['start_date'], $userProgram['duration_weeks']);
    $todayName = date('l'); // e.g. Monday

    // Get scheduled workout for today
    $workout = getScheduledWorkout($conn, $user_id, $currentWeek, $todayName);

    $exercises = [];
    if ($workout) {
        $exercises = getExercisesByWorkout($conn, $workout['id']);
    }

    require ROOT . '/app/views/workout/daily.php';
}

// Helper function for week calculation
function getCurrentWeek($programStartDate, $programDurationWeeks) {
    $today = new DateTime();
    $start = new DateTime($programStartDate);
    $diff = $start->diff($today);
    $daysPassed = $diff->days;
    $weekNumber = floor($daysPassed / 7) + 1;

    if ($weekNumber > $programDurationWeeks) $weekNumber = $programDurationWeeks;
    if ($weekNumber < 1) $weekNumber = 1;

    return $weekNumber;
}

// Show schedule editor UI
function showScheduleEditor() {
    global $conn;
    $user_id = $_SESSION['user']['id'] ?? 0;
    if (!$user_id) {
        echo "Please login.";
        exit;
    }

    $userProgram = getUserProgram($conn, $user_id);
    if (!$userProgram) {
        echo "No program enrolled.";
        exit;
    }

    $program_id = $userProgram['program_id'];
    $workouts = getWorkoutsByProgram($conn, $program_id);

    $stmt = $conn->prepare("SELECT * FROM schedule WHERE user_id = ? ORDER BY week_number, day_of_week");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $scheduleItems = $stmt->get_result();

    require ROOT . '/app/views/workout/scheduleEditor.php';
}


// Save schedule changes (AJAX)
function saveSchedule() {
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    global $conn;
    $user_id = $_SESSION['user']['id'] ?? 0;
    if (!$user_id) {
        echo "Please login.";
        exit;
    }

    if (!isset($_POST['schedule'])) {
        echo "No schedule data received.";
        exit;
    }

    $scheduleData = json_decode($_POST['schedule'], true);
    if (!$scheduleData || !is_array($scheduleData)) {
        echo "Invalid schedule data.";
        exit;
    }

    // Get user's enrolled program_id to use for all schedule entries
    $userProgram = getUserProgram($conn, $user_id);
    if (!$userProgram) {
        echo "No program enrolled.";
        exit;
    }
    $program_id = $userProgram['program_id'];

    $allSaved = true;
    foreach ($scheduleData as $item) {
        // Basic validation
        $week_number = (int) ($item['week_number'] ?? 0);
        $day_of_week = $conn->real_escape_string($item['day_of_week'] ?? '');
        $workout_id = (int) ($item['workout_id'] ?? 0);

        if (!$week_number || !$day_of_week || !$workout_id) {
            $allSaved = false;
            continue;
        }

        // Save or update schedule item
        $saved = saveScheduleItem($conn, $user_id, $program_id, $workout_id, $week_number, $day_of_week);
        if (!$saved) {
            $allSaved = false;
        }
    }

    echo $allSaved ? "saved" : "error";
}

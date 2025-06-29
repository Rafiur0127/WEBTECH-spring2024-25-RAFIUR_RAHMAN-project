<?php
// Get all available programs
function getAllPrograms($conn) {
    $query = "SELECT * FROM programs";
    return $conn->query($query);
}

// Get program by ID
function getProgramById($conn, $program_id) {
    $stmt = $conn->prepare("SELECT * FROM programs WHERE id = ?");
    $stmt->bind_param("i", $program_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Get workouts for a program
function getWorkoutsByProgram($conn, $program_id) {
    $stmt = $conn->prepare("SELECT * FROM workouts WHERE program_id = ?");
    $stmt->bind_param("i", $program_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Get exercises by workout id
function getExercisesByWorkout($conn, $workout_id) {
    $stmt = $conn->prepare("SELECT * FROM exercises WHERE workout_id = ?");
    $stmt->bind_param("i", $workout_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Get user program info (to know start_date, duration)
function getUserProgram($conn, $user_id) {
    $stmt = $conn->prepare("
        SELECT up.*, p.duration_weeks 
        FROM user_programs up
        JOIN programs p ON up.program_id = p.id
        WHERE up.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Get scheduled workout for user by week and day
function getScheduledWorkout($conn, $user_id, $week_number, $day_of_week) {
    $stmt = $conn->prepare("
        SELECT w.* FROM schedule s
        JOIN workouts w ON s.workout_id = w.id
        WHERE s.user_id = ? AND s.week_number = ? AND s.day_of_week = ?");
    $stmt->bind_param("iis", $user_id, $week_number, $day_of_week);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Add or update schedule item
function saveScheduleItem($conn, $user_id, $program_id, $workout_id, $week_number, $day_of_week) {
    // Check if exists
    $stmt = $conn->prepare("SELECT id FROM schedule WHERE user_id = ? AND week_number = ? AND day_of_week = ?");
    $stmt->bind_param("iis", $user_id, $week_number, $day_of_week);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $stmt = $conn->prepare("UPDATE schedule SET workout_id = ?, program_id = ? WHERE id = ?");
        $stmt->bind_param("iii", $workout_id, $program_id, $row['id']);
        return $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO schedule (user_id, program_id, workout_id, week_number, day_of_week) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $user_id, $program_id, $workout_id, $week_number, $day_of_week);
        return $stmt->execute();
    }
}
function getTodayWorkout($conn, $user_id) {
    // Get user's program details
    $stmt = $conn->prepare("
        SELECT up.*, p.duration_weeks 
        FROM user_programs up
        JOIN programs p ON up.program_id = p.id
        WHERE up.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $userProgram = $stmt->get_result()->fetch_assoc();

    if (!$userProgram) return [];

    // Calculate current week number
    $today = new DateTime();
    $start = new DateTime($userProgram['start_date']);
    $diff = $start->diff($today);
    $daysPassed = $diff->days;
    $weekNumber = floor($daysPassed / 7) + 1;

    if ($weekNumber > $userProgram['duration_weeks']) $weekNumber = $userProgram['duration_weeks'];
    if ($weekNumber < 1) $weekNumber = 1;

    $dayOfWeek = date('l');

    // Get scheduled workout for this user, week, and day
    $stmt = $conn->prepare("
        SELECT w.* FROM schedule s
        JOIN workouts w ON s.workout_id = w.id
        WHERE s.user_id = ? AND s.week_number = ? AND s.day_of_week = ?");
    $stmt->bind_param("iis", $user_id, $weekNumber, $dayOfWeek);
    $stmt->execute();
    $workout = $stmt->get_result()->fetch_assoc();

    if (!$workout) return [];

    // Get exercises for the workout
    $stmt = $conn->prepare("SELECT * FROM exercises WHERE workout_id = ?");
    $stmt->bind_param("i", $workout['id']);
    $stmt->execute();
    return $stmt->get_result();
}





<?php
// GoalModel.php
function createGoal($conn, $user_id, $title, $description, $target_value, $unit) {
    $stmt = $conn->prepare("INSERT INTO goals (user_id, title, description, target_value, current_value, unit, status) VALUES (?, ?, ?, ?, 0, ?, 'ongoing')");
    $stmt->bind_param("issis", $user_id, $title, $description, $target_value, $unit);
    return $stmt->execute();
}

function getGoalsByUser($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM goals WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getGoalById($conn, $goal_id) {
    $stmt = $conn->prepare("SELECT * FROM goals WHERE id = ?");
    $stmt->bind_param("i", $goal_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateGoalProgress($conn, $goal_id, $new_value) {
    // Determine new status
    $status = ($new_value >= getGoalTarget($conn, $goal_id)) ? 'completed' : 'ongoing';

    $stmt = $conn->prepare("UPDATE goals SET current_value = ?, status = ? WHERE id = ?");
    $stmt->bind_param("isi", $new_value, $status, $goal_id);
    return $stmt->execute();
}

function getGoalTarget($conn, $goal_id) {
    $stmt = $conn->prepare("SELECT target_value FROM goals WHERE id = ?");
    $stmt->bind_param("i", $goal_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result ? (int)$result['target_value'] : 0;
}

function getActiveGoals($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM goals WHERE user_id = ? AND status = 'ongoing'");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getAchievementCount($conn, $user_id) {
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM achievements WHERE user_id = ? AND unlocked = 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'] ?? 0;
}

function getCompletedGoals($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM goals WHERE user_id = ? AND status = 'completed'");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getGoalsByStatus($conn, $user_id, $status) {
    $stmt = $conn->prepare("SELECT * FROM goals WHERE user_id = ? AND status = ?");
    $stmt->bind_param("is", $user_id, $status);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
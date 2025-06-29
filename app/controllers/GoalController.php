<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once ROOT . '/app/models/GoalModel.php';
require_once ROOT . '/config/database.php';
global $conn; 
function create() {
    if (!isset($_SESSION['user'])) {
        header("Location: ?controller=auth&action=login");
        exit();
    }
    require_once ROOT . '/app/views/goals/create.php';
}

function store() {
    global $conn;
    if (!isset($_SESSION['user'])) {
        header("Location: ?controller=auth&action=login");
        exit();
    }

    $user_id = $_SESSION['user']['id'];
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $target_value = (int)($_POST['target_value'] ?? 0);
    $unit = trim($_POST['unit'] ?? '');

    if ($title === '' || $target_value <= 0) {
        $error = "Please provide a valid title and target value.";
        require ROOT . '/app/views/goals/create.php';
        return;
    }

    if (createGoal($conn, $user_id, $title, $description, $target_value, $unit)) {
        header("Location: ?controller=goal&action=listGoals");
        exit();
    } else {
        $error = "Failed to create goal.";
        require ROOT . '/app/views/goals/create.php';
    }
}

function listGoals() {
    global $conn;
    if (!isset($_SESSION['user'])) {
        header("Location: ?controller=auth&action=login");
        exit();
    }

    $user_id = $_SESSION['user']['id'];
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['goal_id'], $_POST['new_value'])) {
        $goal_id = (int)$_POST['goal_id'];
        $new_value = (int)$_POST['new_value'];
        $goal = getGoalById($conn, $goal_id);
        if ($goal && $goal['user_id'] == $user_id && $new_value >= 0 && $new_value <= $goal['target_value']) {
            updateGoalProgress($conn, $goal_id, $new_value);
            if ($new_value >= $goal['target_value']) {
                $_SESSION['celebration'] = "Congratulations! You achieved the goal '{$goal['title']}' 🏆";
                header("Location: ?controller=goal&action=celebrate");
                exit();
            }
            $message = "Progress updated!";
        } else {
            $message = "Invalid progress update.";
        }
    }

    $goals = getGoalsByUser($conn, $user_id);
    require ROOT . '/app/views/goals/list.php';
}

function celebrate() {
    if (!isset($_SESSION['user'])) {
        header("Location: ?controller=auth&action=login");
        exit();
    }
    if (!isset($_SESSION['celebration'])) {
        header("Location: ?controller=goal&action=listGoals");
        exit();
    }

    $message = $_SESSION['celebration'];
    unset($_SESSION['celebration']);
    require ROOT . '/app/views/goals/celebrate.php';
}

<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(ROOT . '/config/database.php');
require_once(ROOT . '/app/models/UserModel.php');
require_once(ROOT . '/app/models/WorkoutModel.php');
require_once(ROOT . '/app/models/NutritionModel.php');
require_once(ROOT . '/app/models/GoalModel.php');



function register() {
    global $conn;
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        $errors = validateRegisterData($data);

        if (empty($errors)) {
            if (userExists($conn, $data['email'])) {
                $errors['email'] = "Email already registered.";
            } else {
                if (registerUser($conn, $data)) {
                    header("Location: ?controller=auth&action=login");
                    exit();
                } else {
                    $errors['general'] = "Registration failed.";
                }
            }
        }
    }

    require(ROOT . '/app/views/auth/register.php');
}

function login() {
    global $conn;
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email.";
        }

        if (strlen($password) < 6) {
            $errors['password'] = "Password must be at least 6 characters.";
        }

        if (empty($errors)) {
            $user = loginUser($conn, $email, $password);
            if ($user) {
                session_start();
                $_SESSION['user'] = $user;
                $_SESSION['user_id'] = $user['id'];
                header("Location: ?controller=auth&action=dashboard");
                exit();
            } else {
                $errors['general'] = "Invalid email or password.";
            }
        }
    }

    require(ROOT . '/app/views/auth/login.php');
}

function profile() {
    global $conn;

    $userId = $_SESSION['user']['id'];
    $user = getUserById($conn, $userId); 

    $errors = [];
    $success = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;

       
        if (empty($data['first_name'])) $errors['first_name'] = "First name is required";
        if (empty($data['last_name'])) $errors['last_name'] = "Last name is required";
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = "Invalid email";
        if (!empty($data['age']) && (!is_numeric($data['age']) || $data['age'] <= 0)) $errors['age'] = "Invalid age";

        if (empty($errors)) {
            if (updateUserProfile($conn, $userId, $data)) {  
                $success = true;
                $_SESSION['user'] = getUserById($conn, $userId);
                $user = $_SESSION['user'];
            } else {
                $errors['general'] = "Failed to update profile.";
            }
        }
    }

    require(ROOT . '/app/views/user/profile.php'); 
}



function dashboard() {
    global $conn;
    if (!isset($_SESSION['user'])) {
        header("Location: ?controller=auth&action=login");
        exit();
    }

    $user = $_SESSION['user'];
    



    $todayExercises = getTodayWorkout($conn, $user['id']);
    $activeGoals = getGoalsByStatus($conn, $user['id'], 'ongoing');
    $completedGoals = getGoalsByStatus($conn, $user['id'], 'completed');

  

    require(ROOT . '/app/views/dashboard.php');
}


function logout() {
    session_start();
    session_destroy();
    header("Location: ?controller=auth&action=login");
    exit();
}

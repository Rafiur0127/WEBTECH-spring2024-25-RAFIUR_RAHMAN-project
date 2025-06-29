<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require ROOT . '/config/database.php';
require_once ROOT . '/app/models/NutritionModel.php';

function diary() {
    global $conn;
    $user_id = $_SESSION['user']['id'];
    $meals = getMealsByDate($conn, $user_id, date('Y-m-d'));
    require_once ROOT . '/app/views/nutrition/diary.php';
}

function addMeal() {
    global $conn;
    $user_id = $_SESSION['user']['id'];

    addMealEntry($conn, $user_id, $_POST);
    header("Location: ?controller=nutrition&action=diary");
    exit();
}

function deleteMeal() {
    global $conn;
    $id = $_GET['id'];
    deleteMealEntry($conn, $id);
    header("Location: ?controller=nutrition&action=diary");
    exit();
}

function scanner() {
    $scannedFood = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $barcode = $_POST['barcode'];

        // Simulated barcode product list
        $mockDatabase = [
            '123456789012' => [
                'meal' => 'Oats (100g)',
                'calories' => 389,
                'carbs' => 66,
                'protein' => 17,
                'fat' => 7,
            ],
            '987654321098' => [
                'meal' => 'Banana (1 medium)',
                'calories' => 105,
                'carbs' => 27,
                'protein' => 1,
                'fat' => 0,
            ],
        ];

        if (isset($mockDatabase[$barcode])) {
            $scannedFood = $mockDatabase[$barcode];
        } else {
            echo "<p style='color:red'>❌ No product found for this barcode.</p>";
        }
    }

    require ROOT . '/app/views/nutrition/scanner.php';
}

function macroDashboard() {
    global $conn;
    $user_id = $_SESSION['user']['id'] ?? 0;

    $macros = getTodayMacros($conn, $user_id);
    $macroGoals = getMacroGoals($conn, $user_id);

    require ROOT . '/app/views/nutrition/macros.php';
}


function saveMacroGoals() {
    global $conn;

    if (!isset($_SESSION['user']['id'])) {
        header("Location: ?controller=auth&action=login");
        exit();
    }

    $user_id = $_SESSION['user']['id'];

    $calories = isset($_POST['calories']) ? (int)$_POST['calories'] : 0;
    $carbs = isset($_POST['carbs']) ? (int)$_POST['carbs'] : 0;
    $protein = isset($_POST['protein']) ? (int)$_POST['protein'] : 0;
    $fat = isset($_POST['fat']) ? (int)$_POST['fat'] : 0;

    updateMacroGoals($conn, $user_id, $calories, $carbs, $protein, $fat);

    header("Location: ?controller=nutrition&action=macroDashboard&updated=1");
    exit();
}




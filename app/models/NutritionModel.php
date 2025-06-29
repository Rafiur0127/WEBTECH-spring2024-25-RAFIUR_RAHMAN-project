<?php

function addMealEntry($conn, $user_id, $data) {
    $meal = mysqli_real_escape_string($conn, $data['meal']);
    $calories = (int)$data['calories'];
    $carbs = (int)$data['carbs'];
    $protein = (int)$data['protein'];
    $fat = (int)$data['fat'];
    $date = date('Y-m-d');

    $query = "INSERT INTO meals (user_id, meal, calories, carbs, protein, fat, date) 
              VALUES ('$user_id', '$meal', '$calories', '$carbs', '$protein', '$fat', '$date')";
    mysqli_query($conn, $query);
}

function getMealsByDate($conn, $user_id, $date) {
    $query = "SELECT * FROM meals WHERE user_id = '$user_id' AND date = '$date'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function deleteMealEntry($conn, $id) {
    $query = "DELETE FROM meals WHERE id = '$id'";
    mysqli_query($conn, $query);
}

function getTodayMacros($conn, $user_id) {
    $today = date('Y-m-d');
    $query = "SELECT 
                COALESCE(SUM(calories), 0) AS calories,
                COALESCE(SUM(carbs), 0) AS carbs,
                COALESCE(SUM(protein), 0) AS protein,
                COALESCE(SUM(fat), 0) AS fat
              FROM meals 
              WHERE user_id = ? AND date = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $user_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


function getMacroGoals($conn, $user_id) {
    $query = "SELECT calories, carbs, protein, fat FROM macro_goals WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


function updateMacroGoals($conn, $user_id, $calories, $carbs, $protein, $fat) {
    $query = "INSERT INTO macro_goals (user_id, calories, carbs, protein, fat) 
              VALUES (?, ?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE 
                calories = VALUES(calories), 
                carbs = VALUES(carbs), 
                protein = VALUES(protein), 
                fat = VALUES(fat)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiii", $user_id, $calories, $carbs, $protein, $fat);
    $stmt->execute();
    $stmt->close();
}






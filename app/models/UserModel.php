<?php
function validateRegisterData($data) {
    $errors = [];

    $nameRegex = "/^[A-Za-z\s]{2,}$/";
    $phoneRegex = "/^\d{10,15}$/";
    $passwordRegex = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/";

    if (!preg_match($nameRegex, $data['first_name'])) $errors['first_name'] = "Invalid first name.";
    if (!preg_match($nameRegex, $data['last_name'])) $errors['last_name'] = "Invalid last name.";
    if (empty($data['birth_date'])) $errors['birth_date'] = "Birth date required.";
    if (empty($data['gender'])) $errors['gender'] = "Gender required.";
    if (!is_numeric($data['age']) || $data['age'] <= 0 || $data['age'] > 120) $errors['age'] = "Invalid age.";
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = "Invalid email.";
    if (!preg_match($phoneRegex, $data['phone'])) $errors['phone'] = "Invalid phone number.";
    if (!preg_match($passwordRegex, $data['password'])) $errors['password'] = "Weak password.";
    if ($data['password'] !== $data['confirm_password']) $errors['confirm_password'] = "Passwords do not match.";

    return $errors;
}

function userExists($conn, $email) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function registerUser($conn, $data) {
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, birth_date, gender, age, email, phone, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt->bind_param("ssssisss", $data['first_name'], $data['last_name'], $data['birth_date'], $data['gender'], $data['age'], $data['email'], $data['phone'], $hashedPassword);
    return $stmt->execute();
}

function loginUser($conn, $email, $password) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return null;
}


function updateUserProfile($conn, $userId, $data) {
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, birth_date = ?, gender = ?, age = ?, email = ?, phone = ? WHERE id = ?");
    if (!$stmt) return false;

    $stmt->bind_param(
        "ssssissi",
        $data['first_name'],
        $data['last_name'],
        $data['birth_date'],
        $data['gender'],
        $data['age'],
        $data['email'],
        $data['phone'],
        $userId
    );

    return $stmt->execute();
}
function getUserById($conn, $userId) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
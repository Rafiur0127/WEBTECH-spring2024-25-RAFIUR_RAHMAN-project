<?php

function getUserByEmail($conn, $email) {
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        return mysqli_fetch_assoc($result);
    }

    return false;
}

function createUser($conn, $name, $username, $age, $gender, $phone, $email, $password) {
    $query = "INSERT INTO users (name, username, age, gender, phone, email, password) 
              VALUES ('$name', '$username', '$age', '$gender', '$phone', '$email', '$password')";
    
    return mysqli_query($conn, $query);
}

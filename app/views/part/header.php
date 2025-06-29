<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: ?controller=auth&action=login");
    exit();
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Fitness Tracker</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2c3e50;
            padding: 10px 20px;
            color: white;
            flex-wrap: wrap;
        }

        .nav-left h2 {
            margin: 0;
            font-size: 24px;
        }

        .logo-link {
            color: white;
            text-decoration: none;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .nav-right a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .nav-right a:hover {
            background-color: #1a242f;
            text-decoration: none;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        .welcome-user {
            margin-right: 10px;
            font-weight: bold;
            white-space: nowrap;
        }

        @media (max-width: 700px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            .nav-right {
                width: 100%;
                justify-content: flex-start;
                gap: 10px;
            }
            .nav-right a {
                font-size: 14px;
                padding: 6px 10px;
            }
            .welcome-user {
                margin-right: 0;
                margin-bottom: 8px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar" role="navigation" aria-label="Main navigation">
            <div class="nav-left">
                <a href="?controller=auth&action=dashboard" class="logo-link" aria-label="Fitness Tracker Home">
                    <h1> Fitness Tracker</h1>
                </a>
            </div>
            <div class="nav-right">
                <span class="welcome-user">Welcome, <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></span>
                <a href="?controller=goal&action=create">Goals</a>
                <a href="?controller=workout&action=catalog">Workouts</a>
                <a href="?controller=nutrition&action=diary">Diary</a>
                <a href="?controller=auth&action=profile">Profile</a>
                <a href="?controller=auth&action=logout" style="color: #ff6b6b;">Logout</a>
            </div>
        </nav>
    </header>

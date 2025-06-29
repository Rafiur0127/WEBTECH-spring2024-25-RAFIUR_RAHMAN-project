<?php require_once ROOT . '/app/views/part/header.php'; ?>

<style>
    .celebration-container {
        text-align: center;
        padding: 50px 20px;
        background: linear-gradient(to right, #e0f7fa, #e1bee7);
        min-height: 70vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        animation: fadeIn 0.5s ease-in-out;
    }

    .celebration-container h1 {
        font-size: 2.5rem;
        color: #2e7d32;
        margin-bottom: 15px;
    }

    .celebration-container p {
        font-size: 1.2rem;
        margin-bottom: 30px;
        color: #333;
    }

    .celebration-container a {
        background-color: #4CAF50;
        color: white;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .celebration-container a:hover {
        background-color: #388e3c;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 480px) {
        .celebration-container h1 {
            font-size: 2rem;
        }
        .celebration-container p {
            font-size: 1rem;
        }
    }
</style>

<div class="celebration-container">
    <h1>Congratulations! </h1>
    <p><?= htmlspecialchars($message) ?></p>
    <a href="?controller=goal&action=listGoals">← Back to Goals</a>
</div>

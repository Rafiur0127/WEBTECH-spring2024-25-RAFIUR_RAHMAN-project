<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Fitness Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Base Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        form {
            background: #ffffff;
            padding: 30px 25px;
            max-width: 400px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            animation: fadeIn 0.5s ease-in-out;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            color: #34495e;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #3498db;
            outline: none;
        }

        .error {
            color: #e74c3c;
            font-size: 0.9em;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        .submit-btn {
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            width: 100%;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #2980b9;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 480px) {
            form {
                padding: 20px;
            }

            h2 {
                font-size: 1.5rem;
            }

            input, .submit-btn {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>

<form method="POST" action="">
    <h2>User Login</h2>

    <?php if (!empty($errors['general'])): ?>
        <p class="error"><?= $errors['general'] ?></p>
    <?php endif; ?>

    <label>Email</label>
    <input type="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>
    <div class="error"><?= $errors['email'] ?? '' ?></div>

    <label>Password</label>
    <input type="password" name="password" required>
    <div class="error"><?= $errors['password'] ?? '' ?></div>

    <button type="submit" class="submit-btn">Login</button>
</form>

</body>
</html>

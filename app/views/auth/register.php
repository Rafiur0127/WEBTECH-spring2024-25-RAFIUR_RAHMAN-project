<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Fitness Tracker</title>
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
            background: linear-gradient(to right, #f5f7fa, #c3cfe2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        form {
            background: #ffffff;
            padding: 30px 25px;
            max-width: 500px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.4s ease-in-out;
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

        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: border-color 0.3s ease;
            font-size: 1rem;
        }

        input:focus, select:focus {
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

        @media (max-width: 480px) {
            form {
                padding: 20px;
            }

            h2 {
                font-size: 1.5rem;
            }

            input, select, .submit-btn {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>

<form method="POST" action="">
    <h2>User Registration</h2>

    <?php if (!empty($errors['general'])): ?>
        <p class="error"><?= $errors['general'] ?></p>
    <?php endif; ?>

    <label>First Name</label>
    <input type="text" name="first_name" value="<?= $_POST['first_name'] ?? '' ?>" required>
    <div class="error"><?= $errors['first_name'] ?? '' ?></div>

    <label>Last Name</label>
    <input type="text" name="last_name" value="<?= $_POST['last_name'] ?? '' ?>" required>
    <div class="error"><?= $errors['last_name'] ?? '' ?></div>

    <label>Birth Date</label>
    <input type="date" name="birth_date" value="<?= $_POST['birth_date'] ?? '' ?>" required>
    <div class="error"><?= $errors['birth_date'] ?? '' ?></div>

    <label>Gender</label>
    <select name="gender" required>
        <option value="">Select</option>
        <option value="Male" <?= ($_POST['gender'] ?? '') == 'Male' ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= ($_POST['gender'] ?? '') == 'Female' ? 'selected' : '' ?>>Female</option>
        <option value="Other" <?= ($_POST['gender'] ?? '') == 'Other' ? 'selected' : '' ?>>Other</option>
    </select>
    <div class="error"><?= $errors['gender'] ?? '' ?></div>

    <label>Age</label>
    <input type="number" name="age" value="<?= $_POST['age'] ?? '' ?>" min="0" required>
    <div class="error"><?= $errors['age'] ?? '' ?></div>

    <label>Email</label>
    <input type="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>
    <div class="error"><?= $errors['email'] ?? '' ?></div>

    <label>Phone</label>
    <input type="text" name="phone" value="<?= $_POST['phone'] ?? '' ?>" required>
    <div class="error"><?= $errors['phone'] ?? '' ?></div>

    <label>Password</label>
    <input type="password" name="password" required>
    <div class="error"><?= $errors['password'] ?? '' ?></div>

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required>
    <div class="error"><?= $errors['confirm_password'] ?? '' ?></div>

    <button type="submit" class="submit-btn">Register</button>
</form>

</body>
</html>

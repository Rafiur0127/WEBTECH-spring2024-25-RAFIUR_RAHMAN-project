<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
            margin: 0;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            max-width: 500px;
            margin: 0 auto;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 5px;
        }

        .error {
            color: red;
            font-size: 0.9em;
            margin-top: -5px;
            margin-bottom: 10px;
        }

        .success {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }

        button[type="submit"] {
            background-color: #2980b9;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            margin-top: 15px;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #1a598a;
        }

        @media screen and (max-width: 600px) {
            form {
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<h2>Update Profile</h2>

<?php if ($success): ?>
    <p class="success">Profile updated successfully!</p>
<?php endif; ?>

<?php if (!empty($errors['general'])): ?>
    <p class="error"><?= htmlspecialchars($errors['general']) ?></p>
<?php endif; ?>

<form method="POST" action="?controller=auth&action=profile">
    <label>First Name:
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>">
        <span class="error"><?= $errors['first_name'] ?? '' ?></span>
    </label>

    <label>Last Name:
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>">
        <span class="error"><?= $errors['last_name'] ?? '' ?></span>
    </label>

    <label>Birth Date:
        <input type="date" name="birth_date" value="<?= htmlspecialchars($user['birth_date'] ?? '') ?>">
        <span class="error"><?= $errors['birth_date'] ?? '' ?></span>
    </label>

    <label>Gender:
        <select name="gender">
            <option value="">Select</option>
            <option value="Male" <?= (isset($user['gender']) && $user['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= (isset($user['gender']) && $user['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
            <option value="Other" <?= (isset($user['gender']) && $user['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
        </select>
        <span class="error"><?= $errors['gender'] ?? '' ?></span>
    </label>

    <label>Age:
        <input type="number" name="age" value="<?= htmlspecialchars($user['age'] ?? '') ?>">
        <span class="error"><?= $errors['age'] ?? '' ?></span>
    </label>

    <label>Email:
        <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
        <span class="error"><?= $errors['email'] ?? '' ?></span>
    </label>

    <label>Phone:
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
        <span class="error"><?= $errors['phone'] ?? '' ?></span>
    </label>

    <button type="submit">Update Profile</button>
</form>

</body>
</html>

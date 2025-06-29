<?php require_once ROOT . '/app/views/part/header.php'; ?>
<style>
    .container {
    max-width: 900px;
    margin: 20px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.meal-form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
    justify-content: center;
}
.meal-form input,
.meal-form button {
    padding: 10px;
    font-size: 16px;
    border-radius: 4px;
    border: 1px solid #ccc;
}
.meal-form button {
    background-color: #2c3e50;
    color: white;
    border: none;
    cursor: pointer;
}
.meal-form button:hover {
    background-color: #1a242f;
}
.responsive-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}
.responsive-table th, .responsive-table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
}
.responsive-table th {
    background-color: #ecf0f1;
}
.diary-links {
    text-align: center;
    margin-top: 10px;
}
.diary-links a {
    display: inline-block;
    margin: 5px 10px;
    text-decoration: none;
    padding: 8px 12px;
    background-color: #2980b9;
    color: white;
    border-radius: 4px;
}
.diary-links a:hover {
    background-color: #1c5f8e;
}

@media (max-width: 600px) {
    .meal-form {
        flex-direction: column;
        align-items: stretch;
    }
    .responsive-table, thead, tbody, th, td, tr {
        display: block;
    }
    .responsive-table td {
        padding-left: 50%;
        position: relative;
        text-align: left;
    }
    .responsive-table td::before {
        position: absolute;
        left: 10px;
        top: 0;
        width: 45%;
        font-weight: bold;
    }
    .responsive-table td:nth-of-type(1)::before { content: "Meal"; }
    .responsive-table td:nth-of-type(2)::before { content: "Calories"; }
    .responsive-table td:nth-of-type(3)::before { content: "Carbs"; }
    .responsive-table td:nth-of-type(4)::before { content: "Protein"; }
    .responsive-table td:nth-of-type(5)::before { content: "Fat"; }
    .responsive-table td:nth-of-type(6)::before { content: "Action"; }
}

</style>

<div class="container">
    <h2> Food Diary - <?= date('Y-m-d') ?></h2>

    <form method="POST" action="?controller=nutrition&action=addMeal" class="meal-form">
        <input type="text" name="meal" placeholder="Meal Name" required>
        <input type="number" name="calories" placeholder="Calories" required>
        <input type="number" name="carbs" placeholder="Carbs (g)" required>
        <input type="number" name="protein" placeholder="Protein (g)" required>
        <input type="number" name="fat" placeholder="Fat (g)" required>
        <button type="submit">Add Meal</button>
    </form>

    <h3>Today's Meals</h3>

    <?php if (empty($meals)): ?>
        <p style="text-align:center;">No meals logged yet.</p>
    <?php else: ?>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Meal</th><th>Calories</th><th>Carbs</th><th>Protein</th><th>Fat</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($meals as $meal): ?>
                <tr>
                    <td><?= htmlspecialchars($meal['meal']) ?></td>
                    <td><?= $meal['calories'] ?></td>
                    <td><?= $meal['carbs'] ?></td>
                    <td><?= $meal['protein'] ?></td>
                    <td><?= $meal['fat'] ?></td>
                    <td><a href="?controller=nutrition&action=deleteMeal&id=<?= $meal['id'] ?>">Delete</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="diary-links">
        <a href="?controller=nutrition&action=scanner">Scan Food Barcode</a>
        <a href="?controller=nutrition&action=macroDashboard">View Macro Dashboard</a>
    </div>
</div>


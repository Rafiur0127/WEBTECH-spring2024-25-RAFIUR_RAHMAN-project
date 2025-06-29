<?php require_once ROOT . '/app/views/part/header.php'; ?>
<style>
.container {
    max-width: 600px;
    margin: 30px auto;
    padding: 25px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}
.barcode-form, .scanned-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
input[type="text"] {
    padding: 10px;
    font-size: 16px;
    border-radius: 4px;
    border: 1px solid #ccc;
}
button {
    padding: 10px;
    font-size: 16px;
    font-weight: bold;
    background-color: #2c3e50;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    background-color: #1a252f;
}
p {
    margin: 5px 0;
}

@media (max-width: 500px) {
    .container {
        margin: 10px;
        padding: 15px;
    }
    button {
        font-size: 15px;
        padding: 10px;
    }
}
</style>


<div class="container">
    <h2> Scan Food Barcode</h2>

    <form method="POST" action="?controller=nutrition&action=scanner" class="barcode-form">
        <label for="barcode">Enter Barcode:</label>
        <input type="text" id="barcode" name="barcode" required placeholder="e.g., 123456789012">
        <button type="submit"> Scan</button>
    </form>

    <?php if (isset($scannedFood)): ?>
        <hr>
        <h3>Scanned Food:</h3>
        <form method="POST" action="?controller=nutrition&action=addMeal" class="scanned-form">
            <input type="hidden" name="meal" value="<?= htmlspecialchars($scannedFood['meal']) ?>">
            <input type="hidden" name="calories" value="<?= $scannedFood['calories'] ?>">
            <input type="hidden" name="carbs" value="<?= $scannedFood['carbs'] ?>">
            <input type="hidden" name="protein" value="<?= $scannedFood['protein'] ?>">
            <input type="hidden" name="fat" value="<?= $scannedFood['fat'] ?>">

            <p><strong>Meal:</strong> <?= htmlspecialchars($scannedFood['meal']) ?></p>
            <p><strong>Calories:</strong> <?= $scannedFood['calories'] ?> kcal</p>
            <p><strong>Carbs:</strong> <?= $scannedFood['carbs'] ?> g</p>
            <p><strong>Protein:</strong> <?= $scannedFood['protein'] ?> g</p>
            <p><strong>Fat:</strong> <?= $scannedFood['fat'] ?> g</p>

            <button type="submit">Add to Diary</button>
        </form>
    <?php endif; ?>
</div>



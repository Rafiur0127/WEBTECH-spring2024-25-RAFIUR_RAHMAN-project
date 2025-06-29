<?php require_once ROOT . '/app/views/part/header.php'; ?>

<style>
    /* Basic styling */
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f9;
        color: #333;
    }
    h1, h2, h3 {
        color: #2c3e50;
        margin-bottom: 15px;
    }
    p {
        line-height: 1.6;
    }
    ul {
        list-style-type: disc;
        padding-left: 20px;
    }
    ul li {
        margin-bottom: 8px;
    }
    nav {
        margin-top: 30px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }
    nav a {
        background-color: #2c3e50;
        color: #fff;
        padding: 10px 18px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s ease;
        display: inline-block;
    }
    nav a:hover,
    nav a:focus {
        background-color: #1a242f;
    }
    /* Responsive for smaller screens */
    @media (max-width: 600px) {
        nav {
            flex-direction: column;
        }
        nav a {
            width: 100%;
            text-align: center;
            padding: 12px 0;
        }
    }
</style>

<h1>Program Catalog</h1>

<?php if (!empty($program)): ?>
    <h2><?= htmlspecialchars($program['title']) ?></h2>
    <p><?= nl2br(htmlspecialchars($program['description'])) ?></p>

    <h3>Workouts</h3>
    <?php if ($workouts && $workouts->num_rows > 0): ?>
        <ul>
            <?php while ($workout = $workouts->fetch_assoc()): ?>
                <li><?= htmlspecialchars($workout['workout_name']) ?></li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No workouts found for this program.</p>
    <?php endif; ?>

<?php else: ?>
    <p>Program not found.</p>
<?php endif; ?>

<nav>
    <a href="?controller=workout&action=catalog">← Back to Catalog</a>
    <a href="?controller=workout&action=showDailyWorkout">Today’s Workout</a>
    <a href="?controller=workout&action=showScheduleEditor" class="btn">Edit My Schedule</a>
</nav>

<?php require_once ROOT . '/app/views/part/header.php'; ?>

<style>
    .catalog-container {
        max-width: 900px;
        margin: 40px auto;
        font-family: Arial, sans-serif;
    }

    .catalog-container h1 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 30px;
    }

    .program-card {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
        border-left: 5px solid #3498db;
    }

    .program-card:hover {
        transform: translateY(-3px);
    }

    .program-card h3 {
        margin: 0 0 10px;
        color: #34495e;
    }

    .program-card h3 a {
        color: #3498db;
        text-decoration: none;
    }

    .program-card h3 a:hover {
        text-decoration: underline;
    }

    .program-card p {
        color: #555;
        line-height: 1.5;
    }

    .empty-message {
        text-align: center;
        font-size: 1.1rem;
        color: #999;
    }

    @media (max-width: 600px) {
        .program-card {
            padding: 15px;
        }
        .program-card h3 {
            font-size: 1.1rem;
        }
    }
</style>

<div class="catalog-container">
    <h1>📘 Program Catalog</h1>

    <?php if ($programs && mysqli_num_rows($programs) > 0): ?>
        <?php while ($program = mysqli_fetch_assoc($programs)): ?>
            <div class="program-card">
                <h3>
                    <a href="index.php?controller=workout&action=viewProgram&id=<?= $program['id'] ?>">
                        <?= htmlspecialchars($program['title']) ?>
                    </a> (<?= (int)$program['duration_weeks'] ?> weeks)
                </h3>
                <p><?= nl2br(htmlspecialchars($program['description'])) ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="empty-message">No programs available at the moment. Please check back later.</p>
    <?php endif; ?>
</div>

<?php
session_start();
require_once '../config/db.php';

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$id]);
$movie = $stmt->fetch();

if (!$movie) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($movie['title']); ?> | Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">🍿 Cine De Popcorn</a>
            <div class="nav-links"><a href="index.php">Back to Gallery</a></div>
        </div>
    </nav>

    <div class="container" style="display: flex; gap: 40px; margin-top: 50px;">
        <div style="flex: 1; max-width: 400px;">
            <img src="../assets/uploads/<?php echo htmlspecialchars($movie['poster_path']); ?>" style="width:100%; border-radius:12px; border: 1px solid #333;">
        </div>
        
        <div style="flex: 2;">
            <h1 style="font-size: 3rem; margin-bottom: 10px;"><?php echo htmlspecialchars($movie['title']); ?></h1>
            <p style="color: var(--accent); font-size: 1.2rem; margin-bottom: 20px;">
                ⭐ <?php echo $movie['rating']; ?> | <?php echo htmlspecialchars($movie['release_year'] ?? '2024'); ?> | <?php echo htmlspecialchars($movie['genre']); ?>
            </p>
            
            <h3 style="border-bottom: 1px solid #333; padding-bottom: 10px; color: #888;">Description</h3>
            <p style="line-height: 1.6; font-size: 1.1rem; margin-bottom: 30px;">
                <?php echo nl2br(htmlspecialchars($movie['description'])); ?>
            </p>

            <h3 style="border-bottom: 1px solid #333; padding-bottom: 10px; color: #888;">Casting</h3>
            <p style="font-size: 1.1rem; color: #ccc;">
                <?php echo htmlspecialchars($movie['casting'] ?? 'Cast information not available.'); ?>
            </p>
        </div>
    </div>
</body>
</html>
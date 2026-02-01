<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $rating = $_POST['rating'];
    $year = $_POST['release_year'];
    $desc = trim($_POST['description']);
    $casting = trim($_POST['casting']);
    
    $poster = $_FILES['poster']['name'];
    $target = "../assets/uploads/" . basename($poster);

    if (move_uploaded_file($_FILES['poster']['tmp_name'], $target)) {
        // Updated query to include release_year and casting
        $sql = "INSERT INTO movies (title, genre, rating, release_year, description, casting, poster_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$title, $genre, $rating, $year, $desc, $casting, $poster]);
            $message = "Movie added successfully!";
        } catch (PDOException $e) {
            $message = "Database Error: " . $e->getMessage();
        }
    } else {
        $message = "Failed to upload poster.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Movie | Cine De Popcorn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">🍿 Cine De Popcorn</a>
            <div class="nav-links"><a href="index.php">Back to Home</a></div>
        </div>
    </nav>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Add New Movie</h2>
            <?php if($message): ?>
                <div class="error-banner"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Movie Title</label>
                    <input type="text" name="title" required>
                </div>
                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 2;">
                        <label>Genre</label>
                        <input type="text" name="genre" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Year</label>
                        <input type="number" name="release_year" placeholder="2024" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Rating (0.0 - 10.0)</label>
                    <input type="number" step="0.1" name="rating" required>
                </div>
                <div class="form-group">
                    <label>Casting</label>
                    <input type="text" name="casting" placeholder="Actors names...">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Poster</label>
                    <input type="file" name="poster" required>
                </div>
                <button type="submit" class="auth-btn">Save Movie</button>
            </form>
        </div>
    </div>
</body>
</html>
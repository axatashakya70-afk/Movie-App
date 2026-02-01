<?php
session_start();
require_once '../config/db.php';

// Access Control: Only admins can edit
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: index.php"); exit(); }

// Fetch existing movie data
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$id]);
$movie = $stmt->fetch();

if (!$movie) { header("Location: index.php"); exit(); }

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $rating = $_POST['rating'];
    
    // Update logic
    $sql = "UPDATE movies SET title = ?, genre = ?, rating = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$title, $genre, $rating, $id])) {
        $message = "Movie updated successfully!";
        // Refresh data for the form
        $movie['title'] = $title;
        $movie['genre'] = $genre;
        $movie['rating'] = $rating;
    } else {
        $message = "Error updating record.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Movie | Cine De Popcorn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">🍿 Cine De Popcorn</a>
            <div class="nav-links">
                <a href="index.php">Back to Home</a>
            </div>
        </div>
    </nav>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Edit Movie</h2>

            <?php if($message): ?>
                <div style="background: rgba(245, 197, 24, 0.1); color: var(--imdb-yellow); padding: 10px; border-radius: 4px; text-align: center; margin-bottom: 20px; border: 1px solid var(--imdb-yellow);">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="vertical-form">
                <div class="form-group">
                    <label>Movie Title</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($movie['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Genre</label>
                    <input type="text" name="genre" value="<?php echo htmlspecialchars($movie['genre']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Rating (0.0 - 10.0)</label>
                    <input type="number" name="rating" step="0.1" min="0" max="10" value="<?php echo $movie['rating']; ?>" required>
                </div>

                <button type="submit" class="auth-btn">Update Movie Details</button>
            </form>
            
            <div class="auth-footer">
                <a href="index.php" style="color: #888; text-decoration: none; font-size: 0.9rem;">Cancel and return</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
session_start();
require_once '../config/db.php';

$search = $_GET['search'] ?? '';

// Prepare the query to look into Title and Genre
$query = "SELECT * FROM movies WHERE title LIKE ? OR genre LIKE ? ORDER BY id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute(["%$search%", "%$search%"]);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($movies) {
    foreach ($movies as $movie) {
        ?>
        <a href="details.php?id=<?php echo $movie['id']; ?>" class="movie-card">
            <div class="poster-box">
                <img src="../assets/uploads/<?php echo htmlspecialchars($movie['poster_path']); ?>" alt="Poster">
            </div>
            <div class="movie-info">
                <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                <div class="movie-meta">
                    <span><?php echo htmlspecialchars($movie['release_year'] ?? 'N/A'); ?></span>
                    <span class="rating-star">⭐ <?php echo number_format($movie['rating'], 1); ?></span>
                </div>
                
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <div class="admin-actions">
                        <object><a href="edit.php?id=<?php echo $movie['id']; ?>" class="btn-edit">Edit</a></object>
                        <object><a href="delete.php?id=<?php echo $movie['id']; ?>" class="btn-delete" onclick="return confirm('Delete this movie?')">Delete</a></object>
                    </div>
                <?php endif; ?>
            </div>
        </a>
        <?php
    }
} else {
    echo "<div style='grid-column: 1/-1; text-align: center; padding: 50px;'>
            <p style='color: #888;'>No movies found matching your search.</p>
          </div>";
}
?>
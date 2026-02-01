<?php
session_start();
require_once '../config/db.php';

// Initial load: Fetch all movies
$stmt = $pdo->query("SELECT * FROM movies ORDER BY id DESC");
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine De Popcorn | Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">🍿 Cine De Popcorn</a>
            
            <div class="search-box">
                <div class="search-form">
                    <input type="text" id="ajaxSearch" placeholder="Search movies live..." autocomplete="off">
                    <button type="button">Search</button>
                </div>
            </div>

            <div class="nav-links">
                <a href="index.php">Home</a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="add.php" class="admin-link">+ Add Movie</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Admin Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="container">
        <header class="page-title">
            <h2 id="resultTitle">Movies</h2>
        </header>

        <div class="movie-grid" id="movieResult">
            <?php if (count($movies) > 0): ?>
                <?php foreach ($movies as $movie): ?>
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
                <?php endforeach; ?>
            <?php else: ?>
                <p>No movies in the database.</p>
            <?php endif; ?>
        </div>
    </main>

    <script>
    document.getElementById('ajaxSearch').addEventListener('input', function() {
        let query = this.value;
        let resultGrid = document.getElementById('movieResult');
        let title = document.getElementById('resultTitle');

        // Update title dynamically
        if(query.length > 0) {
            title.innerText = "Searching for: " + query;
        } else {
            title.innerText = "Featured Movies";
        }

        // Fetch data from search_ajax.php without reloading
        fetch('search_ajax.php?search=' + encodeURIComponent(query))
            .then(response => response.text())
            .then(data => {
                resultGrid.innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
            });
    });
    </script>

</body>
</html>
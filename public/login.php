<?php
session_start();
require_once '../config/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Cine De Popcorn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">🍿 Cine De Popcorn</a>
            <div class="nav-links">
                <a href="index.php">Back to Movies</a>
            </div>
        </div>
    </nav>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Admin Login</h2>
            
            <?php if($error): ?>
                <div style="color:var(--error-red); background:rgba(255,77,77,0.1); padding:10px; border-radius:4px; text-align:center; margin-bottom:20px; border:1px solid rgba(255,77,77,0.2);">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="e.g. admin" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="auth-btn">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
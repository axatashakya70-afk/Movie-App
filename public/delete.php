<?php
session_start();
require_once '../config/db.php';

// Security check [cite: 81, 82]
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM movies WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}

header("Location: index.php");
exit();
?>
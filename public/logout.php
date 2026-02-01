<?php
// Mandatory for session handling [cite: 80]
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the "Guest View" of the homepage
header("Location: index.php");
exit();
?>
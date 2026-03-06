<?php
/**
 * Database Connection for CNN Clone
 */

// Database credentials
$host = 'localhost';
$db_name = 'rsk80_38';
$username = 'rsk80_38';
$password = '123456';

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // In production, you would log this and show a generic error message
    // die("Connection failed: " . $e->getMessage());
    die("Database Connection Error. Please ensure the database 'rsk80_38' exists and credentials are correct.");
}

// Start PHP Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Utility function to sanitize output
 */
function h($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Utility function to redirect
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Get current user data
 */
function get_current_user_data($pdo) {
    if (!is_logged_in()) return null;
    
    $stmt = $pdo->prepare("SELECT id, username, email, profile_image FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}
?>

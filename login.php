<?php
require 'db_config.php';

session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo json_encode(['error' => 'Username and password are required.']);
        exit;
    }

    try {
        // Use prepared statements to prevent SQL injection
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Authentication successful
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            setcookie('user_session', session_id(), time() + (86400 * 30), "/"); // Set session cookie (30 days)
            echo json_encode(['success' => 'Login successful. Redirecting to dashboard...']);
        } else {
            echo json_encode(['error' => 'Invalid username or password.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error during login: ' . $e->getMessage()]);
    }
} else {
    header("HTTP/1.0 403 Forbidden");
    echo "Access denied.";
}
?>
<?php
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic server-side validation (you should enhance this)
    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(['error' => 'All fields are required.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Invalid email format.']);
        exit;
    }

    try {
        // Check if username or email already exists (Preventing duplicates)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['error' => 'Username or email already exists.']);
            exit;
        }

        // Securely hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statements to prevent SQL injection
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        echo json_encode(['success' => 'Registration successful. Redirecting to login...']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error during registration: ' . $e->getMessage()]);
    }
} else {
    // Handle cases where the script is accessed directly
    header("HTTP/1.0 403 Forbidden");
    echo "Access denied.";
}
?>
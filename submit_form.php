<?php
require 'db_config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $field1 = $_POST['field1'];
    $field2 = $_POST['field2'];
    $userId = $_SESSION['user_id'];

    try {
        // Use prepared statements to prevent SQL injection
        $stmt = $pdo->prepare("INSERT INTO submissions (user_id, field1, field2) VALUES (:user_id, :field1, :field2)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':field1', $field1);
        $stmt->bindParam(':field2', $field2);
        $stmt->execute();

        echo "Data submitted successfully!";
        // Optionally redirect the user
        // header("Location: dashboard.php");
        // exit;

    } catch (PDOException $e) {
        echo "Error submitting data: " . $e->getMessage();
    }
} else {
    // Display the form if accessed via GET
    include 'submit_form.html';
}
?>
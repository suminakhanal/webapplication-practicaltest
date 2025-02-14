<?php
session_start();
include 'db.php';

// Validate form submission
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    die("Error: Email and password are required.");
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($email) || empty($password)) {
    die("Error: Email and password cannot be empty.");
}

try {
    // Query the database for the user
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify user exists and password matches
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: profile.php"); // Redirect to profile page
        exit();
    } else {
        echo "Invalid login!";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

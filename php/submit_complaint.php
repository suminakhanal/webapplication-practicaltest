<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db.php';

// Enable error reporting to debug issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Debug: Check if complaint is received
if (!isset($_POST['complaint']) || empty(trim($_POST['complaint']))) {
    die("Error: Complaint text is empty!");
}

$user_id = $_SESSION['user_id'];
$complaint = trim($_POST['complaint']);

try {
    $query = "INSERT INTO complaints (user_id, complaint_text, created_at) VALUES (:user_id, :complaint, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':user_id' => $user_id,
        ':complaint' => $complaint
    ]);

    // Debug: Check if data is inserted
    echo "Complaint successfully added!";
    
    // Redirect to View Complaints page
    header("Location: php\view_complaint.php");
    exit();
} catch (PDOException $e) {
    die("Error inserting complaint: " . $e->getMessage());
}
?>

<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Box</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Complaint Box</h1>
        <nav>
            <a href="../index.html">Home</a>
            <a href="profile.php">Profile</a>
            <a href="view_complaints.php">View Complaints</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="container">
        <h2>Submit Your Complaint</h2>
        <form action="submit_complaint.php" method="POST">
            <textarea name="complaint" placeholder="Write your complaint here..." required></textarea>
            <input type="submit" value="Submit Complaint">
        </form>
    </main>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

    <footer>
        <p>&copy; Complaint Management System</p>
    </footer>
</body>
</html>

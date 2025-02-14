<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

try {
    $query = "SELECT complaints.id, users.first_name, users.last_name, complaints.complaint_text, complaints.created_at 
              FROM complaints 
              INNER JOIN users ON complaints.user_id = users.id 
              ORDER BY complaints.created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $complaints = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching complaints: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Complaints</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Complaints List</h1>
        <nav>
            <a href="../index.html">Home</a>
            <a href="profile.php">Profile</a>
            <a href="complaint_box.php">Submit Complaint</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="container">
        <h2>All Submitted Complaints</h2>
        <?php if (count($complaints) == 0): ?>
            <p>No complaints found.</p>
        <?php else: ?>
        <ul class="complaint-list">
            <?php foreach ($complaints as $complaint): ?>
            <li class="complaint-item">
                <h3><?php echo htmlspecialchars($complaint['first_name'] . ' ' . $complaint['last_name']); ?></h3>
                <p><?php echo htmlspecialchars($complaint['complaint_text']); ?></p>
                <small><em>Submitted on <?php echo $complaint['created_at']; ?></em></small>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 Complaint Management System</p>
    </footer>
</body>
</html>

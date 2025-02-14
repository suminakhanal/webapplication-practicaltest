<?php
session_start();
include 'db.php';

// Check if the user is logged in (optional, for admin-only access)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

try {
    // Fetch all registered users from the database
    $query = "SELECT id, first_name, last_name, email, phone, profile_photo FROM users";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <link rel="stylesheet" href="../css/style.css">

    <style>
        /* User List Styling */
.user-list {
    list-style: none;
    padding: 0;
    margin: 20px auto;
    width: 80%;
}

.user-item {
    background-color: #C9E9D2; /* Matches theme color */
    margin: 10px 0;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.user-item h3 {
    margin: 0;
    color: #56789A; /* Dark blue for names */
}

.user-item p {
    margin: 5px 0;
    color: #34515E; /* Dark text for details */
    font-size: 16px;
}

    </style>

</head>
<body>
    <header>
        <h1>Registered Users</h1>
        <nav>
            <a href="../index.html">Home</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="container">
        <h2>List of Registered Individuals</h2>
        <ul class="user-list">
            <?php foreach ($users as $user): ?>
            <li class="user-item">
                <h3><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h3>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
    </main>

    <footer>
        <p>&copy; 2025 Complaint Management System</p>
    </footer>
</body>
</html>
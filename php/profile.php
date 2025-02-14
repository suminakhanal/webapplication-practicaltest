<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "User not found!";
        exit();
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href=".\css\style.css">
    <style>
/* General Styles */
body {
    font-family: Merriweather;
    background-color: #789DBC; /* Background color for all pages */
    margin: 0;
    padding: 0;
    color: #faf6fa;
}

h3, h2, h1 {
    color: rgb(7, 42, 71);
}




header{
    background-color: #56789A;
    padding: 15px;
    text-align: center;
    font-size: 18px;
}

 footer {
    background-color: #56789A;
    padding: 15px;
    text-align: center;
    font-size: 18px;
    color: black;
}

/* Navigation Bar */
nav {
    
    background-color: #a8b5d4;
    padding: 10px;
    text-align: center;
    color: black;
    
    
}

nav a {
    color: #130101;
    text-decoration: none;
    padding: 10px 20px;
    font-size: 16px;
}

nav a:hover {
    background-color: #C9E9D2; /* Button color used for hover effect */
    color: #000;
}



        .container {
    width: 30%;
   
    margin: 50px auto;
    background-color: rgba(0, 0, 0, 0.1);
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    display: flex;
    flex-direction: column; /* Stack elements vertically */
    align-items: center;    /* Center-align elements */
    justify-content: center;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); /* Add shadow for better appearance */
}

/* Form Fields */
input[type="text"], input[type="email"], input[type="password"], input[type="tel"] {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    
    
}

/* Buttons */
button, input[type="submit"] {
    background-color: #C9E9D2; /* Button color */
    color: #000;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
}

button:hover, input[type="submit"]:hover {
    background-color: #B5D7BF;
}



/* Profile Photo Styling */
.profile-photo {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin: 10px auto;
    display: block;
    border: 2px solid #fff;
}

        </style>
</head>
<body>
    <header>
        <h1>Profile</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="logout.php">Logout</a>
            <a href="users.php">Users</a>
            <a href="complaint_box.php">Complaint Box</a>
            <a href="view_complaints.php">View Complaints</a>



        </nav>
    </header>

    <main class="container">
        <h2>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h2>
        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
            <img src="../uploads/<?php echo htmlspecialchars($user['profile_photo']); ?>" class="profile-photo" onerror="this.src='../uploads/default.png';">
            <input type="file" name="profile_photo">
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
            <input type="submit" value="Update Profile">
        </form>
    </main>

    <footer>
        <p>&copy; 2025 Complaint Management System</p>
    </footer>
</body>
</html>


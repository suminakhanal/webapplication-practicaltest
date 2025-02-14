<?php
include 'db.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate passwords
if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Handle profile photo upload
$profile_photo = "default.png";
if (!empty($_FILES['profile_photo']['name'])) {
    $target = "../uploads/" . basename($_FILES['profile_photo']['name']);
    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target)) {
        $profile_photo = basename($_FILES['profile_photo']['name']);
    }
}

try {
    $query = "INSERT INTO users (first_name, last_name, email, phone, password, profile_photo) 
              VALUES (:first_name, :last_name, :email, :phone, :password, :profile_photo)";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':email' => $email,
        ':phone' => $phone,
        ':password' => $hashed_password,
        ':profile_photo' => $profile_photo
    ]);
    echo "Registration successful! <a href='../login.html'>Login here</a>";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

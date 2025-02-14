<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

if (empty($first_name) || empty($last_name) || empty($email)) {
    die("Error: All fields are required.");
}

// Handle profile photo upload
if (!empty($_FILES['profile_photo']['name'])) {
    $target = "../uploads/" . basename($_FILES['profile_photo']['name']);
    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target)) {
        $query = "UPDATE users SET profile_photo = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([basename($_FILES['profile_photo']['name']), $user_id]);
    }
}

// Update other user details
$query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$first_name, $last_name, $email, $phone, $user_id]);

header("Location: profile.php?success=1");
exit();
?>

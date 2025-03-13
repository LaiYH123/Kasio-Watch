<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, profile_photo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $profile_photo);
$stmt->fetch();
$stmt->close();
?>

<h2>User Profile</h2>
<img src="uploads/<?php echo $profile_photo; ?>" alt="Profile Photo" width="100"><br>
Username: <?php echo htmlspecialchars($username); ?><br>
Gmail: <?php echo htmlspecialchars($email); ?><br>

<a href="profile_update.php">Change User Profile</a> |
<a href="password_update.php">Change Password</a> |
<a href="profile_photo_upload.php">Upload Avatar</a>
<a href="logout.php">Logout</a>
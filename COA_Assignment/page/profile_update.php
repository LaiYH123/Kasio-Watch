<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['username'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
    $stmt->bind_param("si", $new_username, $user_id);

    if ($stmt->execute()) {
        echo "✅ profile update successfully！";
    } else {
        echo "❌ profile update failed：" . $stmt->error;
    }
    $stmt->close();
}

?>

<form action="" method="post">
    New Username: <input type="text" name="username" required><br>
    <input type="submit" value="update">
</form>

<a href="profile.php">return</a>
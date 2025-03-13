<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_photo"])) {
    $user_id = $_SESSION['user_id'];
    $target_dir = "uploads/";
    $file_name = basename($_FILES["profile_photo"]["name"]);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // allow image file type
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Only JPG, JPEG, PNG, GIF files are allowed to be uploaded！");
    }

    // move upload file
    if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
        // Update the avatar path in the database
        $stmt = $conn->prepare("UPDATE users SET profile_photo = ? WHERE id = ?");
        $stmt->bind_param("si", $file_name, $user_id);

        if ($stmt->execute()) {
            echo "✅ Avatar uploaded successfully！";
        } else {
            echo "❌ Avatar uploaded failed：" . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "❌ Avatar uploaded failed！";
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    Choose Your Avatar: <input type="file" name="profile_photo" required><br>
    <input type="submit" value="upload">
</form>

<a href="profile.php">return</a>
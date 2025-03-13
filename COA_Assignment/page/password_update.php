<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error = ""; // save error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $user_id = $_SESSION['user_id'];

    // Get the current password
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify current password
    if (!password_verify($current_password, $hashed_password)) {
        $error = "❌ The current password is incorrect！";
    } else {
        // update new password
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $new_password_hashed, $user_id);

        if ($stmt->execute()) {
            $error = "✅ Password updated successfully！";
        } else {
            $error = "❌ Update failed：" . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<h2>Change Password</h2>

<form action="" method="post">
    Old Password: <input type="password" name="current_password" required><br>
    New Password: <input type="password" name="new_password" required><br>
    <input type="submit" value="Change Password">
</form>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<a href="profile.php">return</a>
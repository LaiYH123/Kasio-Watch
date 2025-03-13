<?php
require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        header("Location: profile.php"); // Login successfully(jumps to profile_page)
        exit;
    } else {
        echo "valid";
    }

    $stmt->close();
}
$conn->close();
?>

<form method="POST">
    <input type="email" name="email" placeholder="Gmail" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
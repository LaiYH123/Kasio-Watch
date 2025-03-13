<?php
require 'db.php';
global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        header("Location: index.php?error=" . urlencode("⚠️ This email address has been registered. Please use another email address.！"));
        exit();
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("sss", $username, $email, $password);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                header("Location: index.php?error=" . urlencode("❌ register failed" . $stmt->error));
                exit();
            }
            $stmt->close();
        } else {
            header("Location: index.php?error=" . urlencode("❌ SQL preparation failed" . $conn->error));
            exit();
        }
    }

    $checkStmt->close();
    $conn->close();
}

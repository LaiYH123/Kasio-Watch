<?php
$servername = "localhost";
$username = "root";
$password = ""; //XAMPP password is empty
$dbname = "my_database"; // database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("数据库连接失败：" . $conn->connect_error);
}

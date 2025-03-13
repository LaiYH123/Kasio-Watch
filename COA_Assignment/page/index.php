<?php
require 'db.php';

// Get error information (if any)
$error = isset($_GET['error']) ? $_GET['error'] : "";
?>

<form action="register.php" method="post">
    Username : <input type="text" name="username" required><br>
    Gmail : <input type="email" name="email" required><br>
    Password : <input type="password" name="password" required><br>
    <input type="submit" value="register">
</form>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
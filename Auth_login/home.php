<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once "Database.php";
$db = new Database();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user'];


if (isset($_POST['delete'])) {
    $stmt = $db->conn->prepare("DELETE FROM student WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    session_destroy();
    header("Location: Register.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>Welcome <?= htmlspecialchars($email) ?></h2>
    <form method="post">
        <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete your account?')">
            Delete Account
        </button>
    </form>
    <p><a href="logout.php">Logout</a></p>
</div>
</body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once "Database.php";
$db = new Database();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


    if (!preg_match('/@(gmail\.com|yahoo\.com)$/i', $email)) {
        $message = " Only @gmail.com or @yahoo.com emails are allowed!";
    } else {

        $check = $db->conn->prepare("SELECT * FROM student WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = " Email already exists!";
        } else {
            $stmt = $db->conn->prepare("INSERT INTO student (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $password);
            if ($stmt->execute()) {
                $message = " Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $message = " Error: " . $stmt->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>Register</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Email (@gmail or @yahoo)" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>
    <p style="color:red;"><?= $message ?></p>
    <p><a href="login.php">Already have an account? Login</a></p>
</div>
</body>
</html>
    
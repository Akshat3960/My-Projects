<?php
$lifetime = 15 * 60;
$path = "/";
$domain = "10.0.3.15";
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();

if (isset($_POST["username"]) && isset($_POST["password"])) {
    if (checkSuperuserLogin($_POST["username"], $_POST["password"])) {
        $_SESSION['authenticated'] = TRUE;
        $_SESSION['username'] = $_POST["username"];
        $_SESSION['is_superuser'] = TRUE;
        $_SESSION['browser'] = $_SERVER["HTTP_USER_AGENT"];
        header("Location: superuser_dashboard.php"); // Redirect to superuser dashboard
        exit();
    } else {
        session_destroy();
        echo "<script>alert('Invalid username/password or you are not a superuser.');window.location='superuser_login.php';</script>";
        die();
    }
}

function checkSuperuserLogin($username, $password)
{
    $mysqli = new mysqli('localhost', 'waph13', 'password', 'waph');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    // Check if the user is in the superusers table
    $sql = "SELECT * FROM superusers WHERE username=? AND password = md5(?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows >= 1) {
        return TRUE;
    }

    // If not found in superusers, check if it's a normal user
    $sql = "SELECT * FROM users WHERE username=? AND password = md5(?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows >= 1) {
        echo "<script>alert('You are a normal user, not a superuser.');window.location='form2.php';</script>";
        return FALSE;
    }

    return FALSE;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Superuser Login</title>
</head>
<body>
<div class="container">
    <h1>Superuser Login</h1>
    <form action="superuser_login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>

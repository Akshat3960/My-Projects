<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$username = $_SESSION['username'];

$mysqli = new mysqli('localhost', 'waph13', 'password', 'waph');
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$query = "SELECT * FROM users INNER JOIN profiles ON users.user_id = profiles.user_id WHERE users.username = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $additional_email = $row['additional_email'];
    $phone = $row['phone'];
} else {
    echo "No profile found for the logged-in user.";
}

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .profile-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .profile-info {
            margin-bottom: 15px;
        }
        .profile-info label {
            font-weight: bold;
            width: 120px;
            display: inline-block;
        }
        .profile-info span {
            display: inline-block;
            width: calc(100% - 120px);
        }
        .home-link {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
        .home-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>User Details</h2>
        <div class="profile-info">
            <label>Name:</label>
            <span><?php echo $name; ?></span>
        </div>
        <div class="profile-info">
            <label>Email:</label>
            <span><?php echo $email; ?></span>
        </div>
        <div class="profile-info">
            <label>Additional Email:</label>
            <span><?php echo $additional_email; ?></span>
        </div>
        <div class="profile-info">
            <label>Phone:</label>
            <span><?php echo $phone; ?></span>
        </div>
           <a href="index.php" class="home-link">Home Page</a>
    </div>
 
</body>
</html>


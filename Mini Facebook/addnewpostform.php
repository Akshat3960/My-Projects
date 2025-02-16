<?php
session_start();

// Check if user is not authenticated, redirect to login.php
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit();
}

// Assuming $_SESSION['username'] is set
$username = $_SESSION['username'];

// Create connection
$mysqli = new mysqli('localhost', 'waph13', 'password', 'waph');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Prepare SQL query to fetch user_id based on username
$sql = "SELECT user_id FROM profiles WHERE name = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);

// Execute query
$stmt->execute();

// Bind result variables
$stmt->bind_result($user_id);

// Fetch result
$stmt->fetch();

// Close statement
$stmt->close();

// Close database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Post</title>
</head>
<body>
    <h2>Add New Post</h2>
    
    <div>
        <p>Logged in as: <?php echo htmlentities($username); ?></p>
        <p>User ID: <?php echo $user_id; ?></p> <!-- Display the user_id -->
    </div>
    
    <form action="addnewpost.php" method="post">
        <!-- Hidden input field to pass user_id to addnewpost.php -->
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        
        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required></textarea><br><br>
        
        <input type="submit" value="Submit">
    </form>
    <br><a href="index.php">Home Page</a>
</body>
</html>

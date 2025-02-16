<?php

session_start();

// Check if user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get user_id from session
$user_id = $_SESSION['user_id']; // Assuming you store user_id in the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $content = $_POST["content"];
    
    if (empty($content)) {
        die("Content is required! <a href='addnewpostform.php'>Go back to add post</a>");
    }

    // Database connection
    $mysqli = new mysqli('localhost', 'waph13', 'password', 'waph');
    if ($mysqli->connect_errno) {
        die("Database connection failed: " . $mysqli->connect_error);
    }

    // Insert post into database
    $prepared_sql = "INSERT INTO posts (user_id, content) VALUES (?, ?)";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }
    
    $stmt->bind_param("is", $user_id, $content);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    
    // Close statement and database connection
    $stmt->close();
    $mysqli->close();

    // Display success message
    echo "Post added successfully!";
    echo '<br><a href="addnewpostform.php">Add another post</a>';
} else {
    // Invalid request method
    echo "Invalid request!";
}
?>


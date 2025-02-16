<?php
session_start();

// Check if user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $post_id = $_POST["post_id"];
    $user_id = $_SESSION["user_id"];
    $content = $_POST["content"];
    
    if (empty($content)) {
        die("Content is required! <a href='addcommentform.php?post_id=$post_id'>Go back to add comment</a>");
    }

    // Database connection
    $mysqli = new mysqli('localhost', 'waph13', 'password', 'waph');
    if ($mysqli->connect_errno) {
        die("Database connection failed: " . $mysqli->connect_error);
    }

    // Insert comment into database
    $prepared_sql = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }
    
    // Bind parameters and execute the statement
    $stmt->bind_param("iis", $post_id, $user_id, $content);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    
    // Close statement and database connection
    $stmt->close();
    $mysqli->close();

    // Display success message
    echo "Comment added successfully!";
    echo '<br><a href="index.php">Back to Home</a>';
} else {
    // Invalid request method
    echo "Invalid request!";
}
?>

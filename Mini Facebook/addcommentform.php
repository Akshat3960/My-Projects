<?php
session_start();

// Check if user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["post_id"])) {
    $post_id = $_GET["post_id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Comment</title>
</head>
<body>
    <h2>Add Comment</h2>
    
    <form action="addcomment.php" method="post">
        <!-- Hidden input field to pass post_id to addcomment.php -->
        <input type="hidden" name="post_id" value="<?php echo htmlentities($post_id); ?>">
        
        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required></textarea><br><br>
        
        <input type="submit" value="Submit">
    </form>
    <br><a href="index.php">Home Page</a>
</body>
</html>

<?php
} else {
    echo "Invalid request!";
}
?>

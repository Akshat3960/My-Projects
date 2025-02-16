<?php
session_start();

// Check if the user is authenticated and is a superuser
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE || !isset($_SESSION['is_superuser'])) {
    session_destroy();
    echo "<script>alert('You do not have permission to access this page.');window.location='superuserlogin.php';</script>";
    die();
}

// Connect to the database
$mysqli = new mysqli('localhost', 'waph13', 'password', 'waph');
if ($mysqli->connect_errno) {
    printf("Database connection failed: %s\n", $mysqli->connect_error);
    exit();
}

// Fetch all users
$sql = "SELECT * FROM users";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Superuser Dashboard</title>
</head>
<body>
<div class="container">
    <h1>Welcome,<?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <a href="logout.php">Logout</a>
    
    <h2>Manage Users</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Username</th>
                <th>Account Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . ($row['is_disabled'] ? 'Disabled' : 'Enabled') . "</td>";
                    echo "<td>";
                    if ($row['is_disabled']) {
                        echo "<form action='enableuser.php' method='post' style='display:inline;'>
                                <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                                <input type='submit' value='Enable'>
                              </form>";
                    } else {
                        echo "<form action='disableuser.php' method='post' style='display:inline;'>
                                <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                                <input type='submit' value='Disable'>
                              </form>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>


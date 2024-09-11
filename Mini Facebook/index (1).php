<?php
$lifetime = 15 * 60;
$path = "/";
$domain = "10.0.3.15";
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();
if (isset($_POST["username"]) and isset($_POST["password"])) {
        if (checklogin_mysql($_POST["username"],$_POST["password"])) {
            $_SESSION['authenticated'] = TRUE;
            $_SESSION['username'] = $_POST["username"];
            $_SESSION['browser'] = $_SERVER["HTTP_USER_AGENT"]; 
        }else{
            session_destroy();
            echo "<script>alert('Invalid username/password');window.location='form2.php';</script>";
            die();
        }
    }
    if (!isset($_SESSION['authenticated']) or $_SESSION['authenticated']!= TRUE) {
        session_destroy();
        echo "<script>alert('You have not login. Please login first!');</script>";
        header("Refresh: 0; url=form2.php");
        die();
    }
        if($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
        session_destroy();
        echo "<script>alert('Session hijacking attack is detected!');</script>";
        header("Refresh:0; url=form2.php");
        die();
    }

function checklogin_mysql($username, $password)
{
    $mysqli = new mysqli('localhost', 'waph13', 'password', 'waph');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }
    $sql = "SELECT * FROM users WHERE username=? AND password = md5(?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows >= 1)
        return TRUE;
    return FALSE;
}

function getPosts()
{
    $mysqli = new mysqli('localhost', 'waph13', 'password', 'waph');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }
    $sql = "SELECT posts.post_id, profiles.name, posts.content, posts.timestamp 
            FROM posts 
            INNER JOIN profiles ON posts.user_id = profiles.user_id
            ORDER BY posts.timestamp DESC";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='post'>";
            // echo "<h3>" . $row['post_id'] . "</h3>";
            echo "<p>" . $row['content'] . "</p>";
            echo "<p>Posted by : " . $row['name'] . "</p>";
            echo "<p>Time: " . $row['timestamp'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No posts found.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Mini Facebook Style</title>
    <link rel="stylesheet" href="minifbstyle.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #f0f0f0, #d3d3d3);
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .title {
            color: #444444;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .user-info {
            text-align: right;
            margin-bottom: 20px;
        }
        .user-info a {
            margin-left: 15px;
            color: #0066cc;
            text-decoration: none;
        }
        .user-info a:hover {
            text-decoration: underline;
        }
        .main-content {
            margin-top: 20px;
        }
        .post {
            border: 1px solid #e0e0e0;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .post h2 {
            color: #333333;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .post p {
            color: #555555;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Welcome to Mini Facebook</div>
        <div class="user-info">
            <a href="#">Login</a>
            <a href="#">Register</a>
        </div>
        <div class="main-content">
            <div class="post">
                <h2>Post Title</h2>
                <p>This is a sample post content. The design is now updated with a modern and clean look.</p>
            </div>
        </div>
    </div>
</body>


<body>
<div class="container">
    <header>
        <h1 class="title">Individual Project 2</h1>
        <div class="user-info">
            <h2>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</h2>
            <a href="logout.php">Logout</a>
            <a href="editprofileform.php">Edit Profile</a>
            <a href="changepasswordform.php">Change Password</a>
            <a href="profile.php">Current Profile</a>
        </div>
    </header>
    <section class="main-content">
        <h3>Posts:</h3>
        <?php getPosts(); ?>
    </section>
</div>
</body>
</html>
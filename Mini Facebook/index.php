<?php
$lifetime = 15 * 60;
$path = "/";
$domain = "10.0.3.15";
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();

if (isset($_POST["username"]) && isset($_POST["password"])) {
    if (checklogin_mysql($_POST["username"], $_POST["password"])) {
        $_SESSION['authenticated'] = TRUE;
        $_SESSION['username'] = $_POST["username"];
        $_SESSION['browser'] = $_SERVER["HTTP_USER_AGENT"];
    } else {
        session_destroy();
        echo "<script>alert('Invalid username/password');window.location='form2.php';</script>";
        die();
    }
}

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
    session_destroy();
    echo "<script>alert('You have not logged in. Please login first!');</script>";
    header("Refresh: 0; url=form2.php");
    die();
}

if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
    session_destroy();
    echo "<script>alert('Session hijacking attack is detected!');</script>";
    header("Refresh:0; url=form2.php");
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment'])) {
        $postId = $_POST['post_id'];
        $comment = $_POST['comment'];

        if (!empty($comment)) {
            addComment($postId, $_SESSION['username'], $comment);
        }
    } elseif (isset($_POST['edit_post'])) {
        $postId = $_POST['post_id'];
        $content = $_POST['content'];
        editPost($postId, $content);
    } elseif (isset($_POST['delete_post'])) {
        $postId = $_POST['post_id'];
        deletePost($postId);
    }
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
    return $result->num_rows >= 1;
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
            echo "<div class='post-content'>";
            echo "<p>" . htmlspecialchars($row['content']) . "</p>";
            echo "<p>Posted by: " . htmlspecialchars($row['name']) . "</p>";
            echo "<p>Time: " . htmlspecialchars($row['timestamp']) . "</p>";
            echo "</div>";

            // Check if the logged-in user is the author of the post
            if ($_SESSION['username'] === htmlspecialchars($row['name'])) {
                // Edit and delete buttons
                echo "<div class='post-actions'>";
                echo "<button class='edit-btn' onclick='editPost(" . $row['post_id'] . ")'>Edit</button>";
                echo "<form method='POST' style='display:inline;' action='index.php'>";
                echo "<input type='hidden' name='post_id' value='" . htmlspecialchars($row['post_id']) . "'>";
                echo "<button type='submit' name='delete_post'>Delete</button>";
                echo "</form>";
                echo "</div>";
            }

            // Display comments
            displayComments($row['post_id']);

            // Comment form
            echo "<div class='comment-form'>";
            echo "<form method='POST' action='index.php'>";
            echo "<input type='hidden' name='post_id' value='" . htmlspecialchars($row['post_id']) . "'>";
            echo "<textarea name='comment' rows='3' placeholder='Add a comment...' required></textarea>";
            echo "<button type='submit'>Post Comment</button>";
            echo "</form>";
            echo "</div>";

            echo "</div>";
        }
    } else {
        echo "<p>No posts found.</p>";
    }
}

function displayComments($postId)
{
    $mysqli = new mysqli('localhost', 'waph13', 'password', 'waph');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }
    $sql = "SELECT comments.content, profiles.name, comments.timestamp 
            FROM comments 
            INNER JOIN profiles ON comments.user_id = profiles.user_id
            WHERE post_id = ?
            ORDER BY comments.timestamp DESC";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<p><strong>" . htmlspecialchars($row['name']) . "</strong>: " . htmlspecialchars($row['content']) . "</p>";
            echo "<p><small>Posted on: " . htmlspecialchars($row['timestamp']) . "</small></p>";
            echo "</div>";
        }
    } else {
        echo "<p>No comments yet.</p>";
    }
}

function addComment($postId, $username, $comment)
{
    $mysqli = new mysqli('localhost', 'waph13', 'password', 'waph');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    // Retrieve user_id
    $sql = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $userId = $user['user_id'];

    // Insert comment
    $sql = "INSERT INTO comments (post_id, user_id, content, timestamp) VALUES (?, ?, ?, NOW())";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iis", $postId, $userId, $comment);
    $stmt->execute();
}

function editPost($postId, $content)
{
    $mysqli = new mysqli('localhost', 'waph13', 'password', 'waph');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    // Update post
    $sql = "UPDATE posts SET content = ? WHERE post_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("si", $content, $postId);
    $stmt->execute();
}

function deletePost($postId)
{
    $mysqli = new mysqli('localhost', 'waph13', 'password', 'waph');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    // Begin a transaction
    $mysqli->begin_transaction();

    try {
        // Delete all comments associated with the post
        $sql = "DELETE FROM comments WHERE post_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();

        // Delete the post itself
        $sql = "DELETE FROM posts WHERE post_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();

        // Commit the transaction
        $mysqli->commit();
    } catch (Exception $e) {
        // Rollback the transaction on failure
        $mysqli->rollback();
        printf("Error deleting post and comments: %s\n", $e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Team 13 Project</title>
    <link rel="stylesheet" href="minifbstyle.css">
    <style>
        .user-info a {
            color: #000000;
            text-decoration: none;
            margin-right: 2px;
            transition: color 0.1s;
        }
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .user-info a:hover {
            color: #000000;
        }
        .main-content h3 {
            color: #000000;
        }
        .post {
            border-bottom: 4px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }
        .post-content {
            margin-bottom: 10px;
        }
        .post:hover {
            background-color: #f0f0f0;
        }
        .comment-form {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
        .comment-form textarea {
            width: 100%;
            box-sizing: border-box;
        }
        .comment-form button {
            margin-top: 5px;
            padding: 5px 10px;
        }
        .comment {
            border-top: 1px solid #ddd;
            padding: 5px;
            margin-top: 5px;
            background-color: #fff;
        }
        .comment p {
            margin: 0;
        }
        .comment p small {
            color: #666;
        }
        .post-actions {
            margin-top: 10px;
        }
        .post-actions button {
            margin-right: 10px;
        }
    </style>
    <script>
        function editPost(postId) {
            var content = prompt("Edit your post content:");
            if (content) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = 'index.php';
                
                var postIdInput = document.createElement('input');
                postIdInput.type = 'hidden';
                postIdInput.name = 'post_id';
                postIdInput.value = postId;
                form.appendChild(postIdInput);

                var contentInput = document.createElement('input');
                contentInput.type = 'hidden';
                contentInput.name = 'content';
                contentInput.value = content;
                form.appendChild(contentInput);

                var editPostInput = document.createElement('input');
                editPostInput.type = 'hidden';
                editPostInput.name = 'edit_post';
                form.appendChild(editPostInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</head>
<body>
<div class="container">
    <header>
        <h1 class="title">Team 13 Project</h1>
        <div class="user-info">
            <h2>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <a href="logout.php">Logout</a>
            <a href="editprofileform.php">Edit Profile</a>
            <a href="changepasswordform.php">Change Password</a>
            <a href="profile.php">Current Profile</a>
            <a href="addnewpostform.php">New post</a>
        </div>
    </header>
    <section class="main-content">
        <h3>Posts:</h3>
        <?php getPosts(); ?>
    </section>
</div>
</body>
</html>

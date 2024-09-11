<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 400px;
      margin: 80px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
    }
    .form.login {
      margin-top: 20px;
    }
    .text_field {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .button {
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    .button:hover {
      background-color: #45a049;
    }
    .home-link {
      display: block;
      text-align: center;
      margin-top: 10px;
      font-size: 14px;
      color: #333;
      text-decoration: none;
    }
    .home-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Change Password</h1>
    <form action="changepassword.php" method="POST" class="form login">
      <input type="hidden" name="username" value="<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>">
      Password: <input type="password" class="text_field" name="password" /> <br>
      <button class="button" type="submit">Submit</button>
    </form>
    <a href="index.php" class="home-link">Home Page</a>
  </div>
</body>
</html>

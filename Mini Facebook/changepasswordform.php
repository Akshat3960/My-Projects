<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      max-width: 400px;
      width: 100%;
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      text-align: center;
      color: #333;
    }
    h1 {
      color: #000; /* Black heading color */
      margin-bottom: 20px;
    }
    .button {
      width: 50%; /* Adjusted button width */
      padding: 8px; /* Smaller padding for compact size */
      background-color: #000; /* Black button background */
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px; /* Smaller font size */
      transition: background-color 0.3s ease;
    }
    .button:hover {
      background-color: #333; /* Darker shade on hover */
    }
    .home-link {
      display: block;
      text-decoration: none;
      color: #000; /* Black link color */
      margin-top: 20px;
      font-size: 16px;
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

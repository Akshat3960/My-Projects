<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }
    .form.edit-profile {
      margin-bottom: 20px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #f9f9f9;
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
      margin-top: 20px;
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
  <?php
  session_start();
  ?>
  <div class="container">
    <h1>Edit Profile</h1>
    <h2>Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2>

    <form action="editprofile.php" method="POST" class="form edit-profile">
      <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
      Name: <input type="text" class="text_field" name="name" /> <br>
      Additional Email: <input type="email" class="text_field" name="additional_email" /> <br>
      Phone: <input type="tel" class="text_field" name="phone" /> <br>
      <!-- Add more fields as needed -->
      <button class="button" type="submit">Save Changes</button>
    </form>
    <a href="index.php" class="home-link">Home</a>
  </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH-Edit Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9; /* Light gray background */
      color: #333; /* Dark gray text color */
    }
    h1, h2 {
      color: #000; /* Black heading color */
      text-align: center;
    }
    .form {
      max-width: 300px; /* Adjust form width as needed */
      margin: 20px auto; /* Center align the form */
      padding: 20px;
      background: #ffffe0; /* Light yellow background */
      border: 2px solid #000; /* Black border */
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
    }
    .text_field {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #000; /* Black border */
      border-radius: 5px;
      box-sizing: border-box;
    }
    .button {
      width: 100%;
      padding: 10px;
      background-color: #007bff; /* Blue button background */
      color: #fff; /* White button text color */
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .button:hover {
      background-color: #0056b3; /* Darker blue on hover */
    }
    .home-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      text-decoration: none;
      color: #007bff; /* Blue link color */
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
  <h1>Edit Profile, WAPH</h1>
  <h2>Welcome <?PHP echo htmlentities($_SESSION['username']); ?> !</h2>

  <form action="editprofile.php" method="POST" class="form edit-profile">
    <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
    Name: <input type="text" class="text_field" name="name" /> <br>
    Additional Email: <input type="email" class="text_field" name="additional_email" /> <br>
    Phone: <input type="tel" class="text_field" name="phone" /> <br>
    <!-- Add more fields as needed -->
    <button class="button" type="submit">Save Changes</button>
  </form>
  <a href="index.php" class="home-link">Home Page</a>
</body>
</html>

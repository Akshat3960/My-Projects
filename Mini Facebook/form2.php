<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH-Login page</title>
  <style>
    body {
      color: #000; /* Black text color */
    }
    .container {
      background-color: #f2f2f2; /* Light gray background */
      padding: 20px;
      border-radius: 10px;
      margin: 20px auto;
      width: 400px; /* Adjust width as needed */
    }
    .header {
      text-align: center;
      margin-bottom: 20px;
    }
    .header h1 {
      color: #000; /* Black text color */
    }
    .form-group label {
      color: #000; /* Black label color */
    }
    .btn-primary {
      background-color: #007bff; /* Blue button background */
      color: #fff; /* White button text color */
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      display: block;
      margin: 10px auto;
    }
    .btn-primary:hover {
      background-color: #0056b3; /* Darker blue on hover */
    }
    .btn-secondary {
      background-color: #007bff; /* Blue button background */
      color: #fff; /* White button text color */
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      display: block;
      margin: 10px auto;
    }
    .btn-secondary:hover {
      background-color: #0056b3; /* Darker blue on hover */
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Please Login</h1>
      <h2>Team 13</h2>
    </div>
    <form action="index.php" method="POST" class="form login">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
      <!-- Button Group -->
      <div class="button-group" style="text-align: center;">
        <button type="submit" class="btn btn-primary">Log In</button>
        <button type="button" onclick="window.location.href='registrationform.php';" class="btn btn-secondary">Sign Up</button>
      </div>
    </form>
  </div>
</body>
</html>

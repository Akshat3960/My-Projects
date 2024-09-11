<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: Light blue;
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
    .header {
      text-align: center;
      margin-bottom: 19px;
    }
    .header h1 {
      font-size: 19px;
      margin-bottom: 7px;
      color: #333;
    }
    .header h2 {
      font-size: 18px;
      margin-top: 0;
      color: #666;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      font-weight: light bold;
      display: block;
      margin-bottom: 5px;
    }
    .form-control {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .button-group {
      text-align: center;
      margin-top: 20px;
    }
    .btn {
      padding: 10px 20px;
      font-size: 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .btn-primary {
      background-color: blue;
      color: #fff;
    }
    .btn-primary:hover {
      background-color: light green
    }
    .btn-secondary {
      background-color: green;
      color: #fff;
      margin-left: 10px;
    }
    .btn-secondary:hover {
      background-color: #5a6268;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Login Page</h1>
    </div>
    <form action="index.php" method="POST" class="form login">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
      </div>
      <!-- Button Group -->
      <div class="button-group">
        <button type="submit" class="btn btn-primary">Log In</button>
        <button type="button" onclick="window.location.href='registrationform.php';" class="btn btn-secondary">Sign Up</button>
      </div>
    </form>
  </div>
</body>
</html>
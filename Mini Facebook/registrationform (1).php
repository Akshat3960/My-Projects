<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Sign Up</title>
    <style>
    body {
      font-family: Arial, sans-serif;
      background-color: light blue;
      margin: 20px;
    }
    
    .form {
      max-width: 400px;
      background-color: light green;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .text_field {
      width: calc(100% - 20px);
      margin-bottom: 10px;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }
    
    .button {
      background-color: #4CAF50;
      color: light green;
      border: none;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .button:hover {
      background-color: #45a049;
    }
    
    .home-link {
      display: block;
      margin-top: 10px;
      text-align: center;
      color: #555;
      text-decoration: none;
    }
    
    .home-link:hover {
      text-decoration: underline;
    }
    
    h1 {
      text-align: center;
      margin-bottom: 19px;
    }
  </style>
  <script>
    function validateForm() {
      // Client-side validation logic
      var username = document.forms["registrationForm"]["username"].value;
      var password = document.forms["registrationForm"]["password"].value;
      var email = document.forms["registrationForm"]["email"].value;
      // Add more validation checks as needed
      
      if (username == "" || password == "" || email == "") {
        alert("All fields are required");
        return false;
      }
      // Add more client-side validation checks as needed
      return true;
    }
  </script>
</head>
<body>
  <h1>User Registration</h1>
  <form action="addnewuser.php" method="POST" class="form login">
    Username:<input type="text" class="text_field" name="username" /> <br>
    Password: <input type="password" class="text_field" name="password" /> <br>
    name:<input type="text" class="text_field" name="name" /> <br>
    additional_email: <input type="text" class="text_field" name="additional_email" /> <br>
    email:<input type="text" class="text_field" name="email" /> <br>
    phone: <input type="text" class="text_field" name="phone" /> <br>
    <button class="button" type="submit">Submit</button>
    <a href="form2.php" class="home-link">Login Page</a>
  </form>
  
</body>
</html>
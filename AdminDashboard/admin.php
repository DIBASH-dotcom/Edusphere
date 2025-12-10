<?php
 require_once "../connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - EDUSPHERE</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 300px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .input-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      font-size: 14px;
      margin-bottom: 5px;
    }

    input {
      width: 100%;
      padding: 10px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }

    .error-message {
      color: red;
      text-align: center;
      margin-top: 10px;
    }

    .register-link {
      text-align: center;
      margin-top: 10px;
    }

    .register-link a {
      color: #4CAF50;
      text-decoration: none;
    }

    .register-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Admin Login</h2>
    <form method="POST">
      <div class="input-group">
        <label for="AdminName">AdminName</label>
        <input type="text" id="AdminName" name="AdminName" required>
      </div>
      <div class="input-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" name="Login" class="btn">Login</button>
      <div id="error-message" class="error-message"></div>
    </form>
    <div class="register-link">
      <p>Don't have an account? <a href="./pages/Register.php">Register here</a></p>
    </div>
  </div>

<?php
if(isset($_POST['Login'])) 
{
 $query="SELECT * FROM `admin_login` WHERE `Admin_Name`='$_POST[AdminName]' AND `Admin_Password`='$_POST[password]' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result)==1)
  {
    session_start();
    $_SESSION['AdminLoginId']=$_POST['AdminName'];
    header(("location:  ../AdminDashboard/AdminLogin.php")); 
  }
  else{
    echo"<script>alert('Incorrect Password');</script>";
  }
}
?>

</body>
</html>

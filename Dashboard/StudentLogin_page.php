<?php
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    require_once "../connection.php";

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM student_register WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student_register = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($student_register) {
        if (password_verify($password, $student_register["password"])) {
            header("Location: ../Dashboard/Student.php");  // Redirect to Student Dashboard
            die();
        } else {
            echo "<div class='error-message'>Invalid Password</div>";
        }
    } else {
        echo "<div class='error-message'>Email does not exist</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 14px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #d9534f;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin: 15px 0;
            border-radius: 8px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Student Login</h2>
        <form action="StudentLogin_page.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
        <div class="footer">
            
            <p>Don't have an account? <a href="StudentRegirstataion.php">Register</a></p>
        </div>
    </div>

</body>
</html>

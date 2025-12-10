<?php
include('../connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $con->prepare("SELECT user_id, password FROM users_lms_libarray WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();
    
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // Start a session and store the user_id in session
            $_SESSION['user_id'] = $row['user_id'];

            // Redirect to the student dashboard page
            header("Location: ../LMS SYSTEM/(student_dashboard.php");
            exit(); // Make sure no further code is executed
        } else {
            echo "<script>alert('Invalid credentials!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
        }
        .login-container h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            color: #333;
        }
        .input-field {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            border-color: #3b82f6;
            outline: none;
        }
        .btn-submit {
            background-color: #3b82f6;
            color: white;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #2563eb;
        }
        .input-field::placeholder {
            color: #999;
        }
        p {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
        a {
            color: #3b82f6;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        footer {
            position: absolute;
            bottom: 10px;
            text-align: center;
            font-size: 14px;
            color: #888;
        }
        footer a {
            color: #3b82f6;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login to LMS</h2>
        <form method="POST" action="login.php" onsubmit="return validateForm()">
            <input type="email" id="email" name="email" required class="input-field" placeholder="Enter your email" />
            <input type="password" id="password" name="password" required class="input-field" placeholder="Enter your password" />
            <button type="submit" class="btn-submit">Login</button>
            <p>Don't have an account? <a href="../LMS SYSTEM/register.php">Register here</a></p>
        </form>
    </div>

    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            
            if (email === "" || password === "") {
                alert("Both fields are required!");
                return false;
            }
            return true;
        }
    </script>

    <footer>
        <p>&copy; 2025 Edusphere. All rights reserved.</p>
    </footer>

</body>
</html>

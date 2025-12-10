<?php
session_start(); // Start the session
require("../connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        header {
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
        }
        .header-content {
            display: flex;
            align-items: center;
            text-align: left;
        }
        .logo {
            width: 50px;
            height: 50px;
            margin-right: 15px;
        }
        h1 {
            font-family: 'Poppins', sans-serif;
            color: #333;
            margin: 0;
        }
        p {
            font-size: 16px;
            color: #666;
            margin-top: 5px;
        }
        .container {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        form input[type="text"], form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #45a049;
        }
        a {
            color: #ffcc00;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        /* Footer Styling */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        footer a {
            color: #ffcc00;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <img class="logo" src="../images/logo2.png" alt="EDUSPHERE Logo">
            <div>
                <h1>Welcome Back!</h1>
                <p>Please log in to access your account and continue your journey with EDUSPHERE.</p>
            </div>
        </div>
    </header>

    <div class="container">
        <h2>Login</h2>
        <?php
        if (isset($_POST["Login"])) {
            $Email = trim($_POST["Email"]);
            $Password = $_POST["Password"];

            // Check if fields are empty
            if (empty($Email) || empty($Password)) {
                echo "<div style='color: red;'>All fields are required.</div>";
            } else {
                // Fetch user from database
                $sql = "SELECT * FROM register WHERE Email = ?";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "s", $Email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_assoc($result);

                // Verify password
                if ($user && password_verify($Password, $user['Password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['first_name'] = $user['First_Name'];
                    header("location: ../pages/HomePage.php");
                    exit();
                } else {
                    echo "<div style='color: red;'>Invalid email or password.</div>";
                }
            }
        }
        ?>

        <form action="Login.php" method="POST">
            <input type="text" name="Email" placeholder="Email" required>
            <input type="password" name="Password" placeholder="Password" required>
            <button type="submit" name="Login">Login</button>
            <p>Don't have an account? <a href="Register.php">Register here</a></p>
        </form>
    </div>

    <footer>
        <p>Contact us at <a href="mailto:dekstop5555@gmail.com">dekstop5555@gmail.com</a></p>
    </footer>
</body>
</html>

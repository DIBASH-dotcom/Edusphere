<?php
session_start();
require_once "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM users_online WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Redirect to respective dashboard
        if ($user['role'] == 'student') {
            header("Location: student_dashboard.php");
        } else {
            header("Location: teacher_dashboard.php");
        }
        exit();
    } else {
        $error_message = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EDUSPHERE OMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6a4c9c;
            --secondary-color: #f8f9fa;
            --accent-color: #5a3c89;
            --text-color: #333;
            --light-gray: #e2e6ea;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--secondary-color);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        .nav-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-container img {
            width: 100px;
            height: auto;
        }

        .nav-container a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-container a:hover {
            color: var(--accent-color);
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin-top: 80px;
        }

        h2 {
            color: var(--primary-color);
            font-size: 28px;
            margin-bottom: 20px;
        }

        p {
            color: var(--text-color);
            font-size: 16px;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group {
            position: relative;
        }

        label {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 15px;
            border: 2px solid var(--light-gray);
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        input[type="email"]:focus + label, input[type="password"]:focus + label,
        input[type="email"]:not(:placeholder-shown) + label, input[type="password"]:not(:placeholder-shown) + label {
            top: 0;
            font-size: 12px;
            background-color: white;
            padding: 0 5px;
        }

        input[type="submit"] {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease;
        }

        input[type="submit"]:hover {
            background-color: var(--accent-color);
        }

        input[type="submit"]:active {
            transform: scale(0.98);
        }

        .error {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 10px;
        }

        .register-link {
            margin-top: 20px;
            font-size: 14px;
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="nav-container">
        <img src="../images/logo2.png" alt="EDUSPHERE Logo">
        <a href="../pages/HomePage.php">Home</a>
    </div>

    <div class="login-container">
        <h2>Welcome Back</h2>
        <p>Please log in to access your account</p>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group">
                <input type="email" id="email" name="email" required placeholder=" ">
                <label for="email">Email Address</label>
            </div>

            <div class="input-group">
                <input type="password" id="password" name="password" required placeholder=" ">
                <label for="password">Password</label>
            </div>

            <input type="submit" value="Log In">
        </form>

        <div class="register-link">
            <p>Don't have an account? <a href="../OMS SYSTEM/register.php">Sign up here</a></p>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Edusphere. All rights reserved.</p>
    </footer>

    <script>
        // Add some simple animations
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelector('.login-container').style.opacity = '0';
            setTimeout(() => {
                document.querySelector('.login-container').style.transition = 'opacity 0.5s ease';
                document.querySelector('.login-container').style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>
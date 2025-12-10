<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login</title>
    <style>
        /* Reset some basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            position: relative;
        }

        .welcome-message {
            position: absolute;
            top: -50px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            animation: fadeOut 5s forwards;
        }

        @keyframes fadeOut {
            0%, 80% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                visibility: hidden;
            }
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            font-size: 14px;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .input-group input:focus {
            border-color: #6a11cb;
            outline: none;
        }

        .submit-group button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-group button:hover {
            background-color: #45a049;
        }

        footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="welcome-message" id="welcomeMessage">Welcome Teachers!</div>
        
        <?php
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            require_once "../connection.php";

            // Use prepared statements to prevent SQL injection
            $sql = "SELECT * FROM teacher_register WHERE email = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $teacher_register = mysqli_fetch_array($result, MYSQLI_ASSOC);

            if ($teacher_register) {
                if (password_verify($password, $teacher_register["password"])) {
                    header("Location: ../Dashboard/Teacher.php");
                    die();
                } else {
                    echo "<div style='color: red; margin-bottom: 15px;'>Invalid Password</div>";
                }
            } else {
                echo "<div style='color: red; margin-bottom: 15px;'>Email does not exist</div>";
            }
        }
        ?>

        <h2>Teacher Login</h2>
        <form action="Teacherlogin.php" method="POST">
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required />
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required />
            </div>
            <div class="submit-group">
                <button type="submit" name="login" id="login">Login</button>
            </div>
        </form>
        <footer>
            © 2025 Your Institution. All Rights Reserved.
        </footer>
    </div>

    <script>
        // Remove the welcome message after 5 seconds
        setTimeout(() => {
            const welcomeMessage = document.getElementById('welcomeMessage');
            if (welcomeMessage) {
                welcomeMessage.style.display = 'none';
            }
        }, 5000);
    </script>
</body>
</html>

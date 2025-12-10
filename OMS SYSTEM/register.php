<?php
require_once "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];  
    $role = $_POST['role'];
    $department = $_POST['department'];
    $year_part = $_POST['year_part'];

    // Server-side validation for email uniqueness
    $stmt = $con->prepare("SELECT email FROM users_online WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>alert('Email is already registered.'); window.location.href='register.php';</script>";
        exit;
    }

    // Password mismatch check
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.location.href='register.php';</script>";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $stmt = $con->prepare("INSERT INTO users_online (name, email, password, role, department, year_part) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $hashed_password, $role, $department, $year_part);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:  #800080;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input[type="text"].error, input[type="email"].error, input[type="password"].error, select.error {
            border: 1px solid red;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
    <script>
        function validateForm() {
            var name = document.forms["registerForm"]["name"];
            var email = document.forms["registerForm"]["email"];
            var password = document.forms["registerForm"]["password"];
            var confirmPassword = document.forms["registerForm"]["confirm_password"];
            var department = document.forms["registerForm"]["department"];
            var yearPart = document.forms["registerForm"]["year_part"];
            var isValid = true;

            // Remove previous error styles
            resetErrors();

            // Check if fields are empty
            if (name.value == "") {
                name.classList.add("error");
                isValid = false;
            }
            if (email.value == "") {
                email.classList.add("error");
                isValid = false;
            }
            if (password.value == "") {
                password.classList.add("error");
                isValid = false;
            }
            if (confirmPassword.value == "") {
                confirmPassword.classList.add("error");
                isValid = false;
            }
            if (department.value == "") {
                department.classList.add("error");
                isValid = false;
            }
            if (yearPart.value == "") {
                yearPart.classList.add("error");
                isValid = false;
            }

            // Validate email format
            if (email.value !== "" && !/\S+@\S+\.\S+/.test(email.value)) {
                email.classList.add("error");
                isValid = false;
            }

            // Check if password and confirm password match
            if (password.value !== confirmPassword.value) {
                confirmPassword.classList.add("error");
                alert("Passwords do not match");
                isValid = false;
            }

            return isValid;
        }

        function resetErrors() {
            var inputs = document.querySelectorAll("input, select");
            inputs.forEach(function(input) {
                input.classList.remove("error");
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="POST" action="" name="registerForm" onsubmit="return validateForm()">
            <label>Name:</label><br>
            <input type="text" name="name" required><br>

            <label>Email:</label><br>
            <input type="email" name="email" required><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br>

            <label>Confirm Password:</label><br>
            <input type="password" name="confirm_password" required><br>

            <label>Role:</label><br>
            <select name="role">
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select><br>

            <label>Department:</label><br>
            <input type="text" name="department" required><br>

            <label>Year & Part:</label><br>
            <input type="text" name="year_part" required><br>

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>

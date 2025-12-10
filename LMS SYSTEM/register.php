<?php
// Include the database connection
include('../connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $department = $_POST['department'];
    $year = $_POST['year'];
    $part = $_POST['part'];

    // Check if email already exists
    $check_query = $con->prepare("SELECT email FROM users_lms_libarray WHERE email = ?");
    $check_query->bind_param("s", $email);
    $check_query->execute();
    $result = $check_query->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already registered!');</script>";
    } else {
        // Insert new user
        $query = $con->prepare("INSERT INTO users_lms_libarray (full_name, email, password, department, year, part) VALUES (?, ?, ?, ?, ?, ?)");
        $query->bind_param("ssssss", $full_name, $email, $password, $department, $year, $part);

        if ($query->execute()) {
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "Error: " . $query->error;
        }
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
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .register-container h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-submit {
            background-color: #3b82f6;
            color: white;
            padding: 10px;
            border-radius: 4px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-submit:hover {
            background-color: #2563eb;
        }
        .input-field:focus {
            outline: none;
            border-color: #3b82f6;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>PLEASE REGISTER HERE TO ENJOY THE LMS </h2>
        <form method="POST" action="register.php" onsubmit="return validateForm()">
            <input type="text" id="full_name" name="full_name" required class="input-field" placeholder="Enter your full name" />
            <input type="email" id="email" name="email" required class="input-field" placeholder="Enter your email" />
            <input type="password" id="password" name="password" required class="input-field" placeholder="Enter your password" />
            <input type="text" id="department" name="department" required class="input-field" placeholder="Enter your department" />
            <input type="text" id="year" name="year" required class="input-field" placeholder="Enter your year" />
            <input type="text" id="part" name="part" required class="input-field" placeholder="Enter your part" />
            <button type="submit" class="btn-submit">Register</button>
        </form>
    </div>

    <script>
        function validateForm() {
            var fullName = document.getElementById("full_name").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var department = document.getElementById("department").value;
            var year = document.getElementById("year").value;
            var part = document.getElementById("part").value;

            if (fullName === "" || email === "" || password === "" || department === "" || year === "" || part === "") {
                alert("All fields are required!");
                return false;
            }

            // Email format validation
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!email.match(emailPattern)) {
                alert("Please enter a valid email address.");
                return false;
            }

            return true;
        }
    </script>

</body>
</html>

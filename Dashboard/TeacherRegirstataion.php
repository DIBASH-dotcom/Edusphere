
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration</title>
    <style>
        /* Basic Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
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
            display: block;
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

        .error {
            color: red;
            font-size: 12px;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 10px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
    <?php
if(isset($_POST["submit"])) {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $password = $_POST["password"];
    $passwordhash = password_hash($password, PASSWORD_DEFAULT);

    $errors = array();

    if(empty($fullname) || empty($email) || empty($subject) || empty($password)) {
        array_push($errors, "All fields are required.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email.");
    }
    if (strlen($password) < 10) {
        array_push($errors, "Password must be at least 10 characters long.");
    }

    require_once "../connection.php";

    // Check if email is already registered
    $sql = "SELECT * FROM teacher_register WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        array_push($errors, "Email is already registered.");
    }

    if(count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        // Insert the data using prepared statements
        $sql = "INSERT INTO teacher_register (fullname, email, subject, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $fullname, $email, $subject, $passwordhash);
        if(mysqli_stmt_execute($stmt)) {
            echo "<div class='success'>Successfully registered. Proceed to login.</div>";
        } else {
            echo "<div class='error'>Something went wrong.</div>";
        }
    }
}
?>



        <h2>Teacher Registration</h2>
        <form id="registrationForm" action="TeacherRegirstataion.php" method="POST">

            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="fullname" name="fullname" >
                <div id="nameError" class="error"></div>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" >
                <div id="emailError" class="error"></div>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject">
                <div id="subjectError" class="error"></div>
            </div>
            <div class="form-group">
                <label for="password">password:</label>
                <input type="password" id="password" name="password" >
                <div id="passwordError" class="error"></div>
            </div>
            <button type="submit" name="submit">Register</button>
        </form>
        <div class="login-link">
            <p>If you already have an account, <a href="./Teacherlogin.php">Login here</a>.</p>
        </div>
    </div>

    <script>
        function validateForm(event) {
            event.preventDefault();  // Prevent the form from submitting
            
            // Clear previous errors
            document.getElementById("nameError").textContent = "";
            document.getElementById("emailError").textContent = "";
            document.getElementById("subjectError").textContent = "";
            document.getElementById("passwordError").textContent = "";
            
            let isValid = true;
            
            // Validation for name
            const name = document.getElementById("name").value;
            if (name === "") {
                document.getElementById("nameError").textContent = "Name is required.";
                isValid = false;
            }
            
            // Validation for email
            const email = document.getElementById("email").value;
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!email.match(emailRegex)) {
                document.getElementById("emailError").textContent = "Please enter a valid email.";
                isValid = false;
            }
            
            // Validation for subject
            const subject = document.getElementById("subject").value;
            if (subject === "") {
                document.getElementById("subjectError").textContent = "Subject is required.";
                isValid = false;
            }
            
            // Validation for password
            const password = document.getElementById("password").value;
            if (password === "" || password< 0) {
                document.getElementById("passwordError").textContent = "password must be a 10.";
                isValid = false;
            }

            // If form is valid, alert success and reset form
            if (isValid) {
                alert("Registration successful!");
                document.getElementById("registrationForm").reset();
            }

            return isValid;
        }
    </script>

</body>
</html>

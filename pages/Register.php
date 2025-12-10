
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            text-align: center;
            padding: 20px;
            background-color: #4caf50;
            color: white;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
        }

        header p {
            margin-top: 10px;
            font-size: 16px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 40px;
            gap: 20px;
            flex-wrap: wrap; /* Ensure it wraps on smaller screens */
        }

        .form-container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 40%;
        }

        .form-container h2 {
            color: green;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button[type="submit"] {
            padding: 15px;
            border-radius: 10px;
            border: none;
            background-color: #4caf50;
            color: white;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .image-container {
            text-align: center;
            width: 40%;
        }

        .image-container h3 {
            font-size: 22px;
            color: #333;
        }

        .image-container p {
            font-size: 16px;
            color: #666;
        }

        .image-container .logo {
            max-width: 200px;
            max-height: 200px;
            margin-top: 20px;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 1024px) {
            .container {
                padding: 20px;
                flex-direction: column; /* Stack the content on smaller screens */
                gap: 40px;
            }

            .form-container {
                width: 100%; /* Form takes full width */
            }

            .image-container {
                width: 100%; /* Image container also takes full width */
            }
        }

        @media (max-width: 600px) {
            header h1 {
                font-size: 24px; /* Adjust header font size */
            }

            header p {
                font-size: 14px; /* Adjust paragraph font size */
            }

            .form-container h2 {
                font-size: 20px; /* Adjust form title font size */
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            select {
                padding: 8px; /* Adjust padding on smaller screens */
            }

            button[type="submit"] {
                padding: 12px; /* Adjust button padding */
                font-size: 14px; /* Adjust font size */
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>We are excited to have you on board!</h1>
        <p>To create your account, simply fill in the details below and start your journey towards a more productive learning experience.</p>
    </header>

    <div class="container">
        <div class="form-container">
        <h2>Registration Form</h2>
        <?php 
if (isset($_POST["submit"])) {
    $First_Name = $_POST["First_Name"];
    $Last_Name = $_POST["Last_Name"];
    $Email = $_POST["Email"];
    $Password = $_POST["Password"];
    $Re_password = $_POST["Re_password"];
    $Contact = $_POST["Contact"];


    $PasswordHash =password_hash($Password, PASSWORD_DEFAULT);


    $errors = array();

    if (empty($First_Name) || empty($Last_Name) || empty($Email) || empty($Password) || empty($Re_password) || empty($Contact)) {
        array_push($errors, "Check once and fill the required fields.");
    }

    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email.");
    }

    if (strlen($Password) < 10) {
        array_push($errors, "Password must have at least 10 characters.");
    } 

    if ($Password !== $Re_password) {
        array_push($errors, "Password and re-password must be same.");
    }

    if (!preg_match("/^[0-9]{10}$/", $Contact)) {
        array_push($errors, "Invalid contact number. It should be a 10-digit number.");
    } 
   require_once "../connection.php";
    $sql ="SELECT *FROM register WHERE Email='$Email'";
    $result = mysqli_query( $con, $sql);
    $rowCount =mysqli_num_rows($result);

    if ($rowCount>0){
        array_push($errors, "Email already exist");
    }


    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        
        $sql = "INSERT INTO 	register (First_Name, Last_Name, Email, Password, Contact )VALUES(?, ?, ?, ? ,?)";
       $stmt = mysqli_stmt_init($con);
      $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
      if ($prepareStmt) {
        mysqli_stmt_bind_param($stmt,"sssss",$First_Name , $Last_Name, $Email, $PasswordHash, $Contact);
        mysqli_stmt_execute($stmt);
        echo "<div class= 'alert alert-sucess'>YOU are registerd now go to Login</div>";
      } else{
        die("Something went wrong");
      }
    }
}
?>

          
            <form action="Register.php" method="POST">
                <label for="first">First Name:</label>
                <input type="text" id="First_Name" name="First_Name"  />

                <label for="last">Last Name:</label>
                <input type="text" id="Last_Name" name="Last_Name" />

                <label for="email">Email:</label>
                <input type="email" id="Email" name="Email" />

                <label for="password">Password:</label>
                <input type="password" id="Password" name="Password"  />

                <label for="repassword">Re-type Password:</label>
                <input type="password" id="Re_password" name="Re_password" />

                <label for="mobile">Contact:</label>
                <input type="text" id="Contact" name="Contact" maxlength="10" placeholder="Contact Number"  />

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" >
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>

                <button type="submit" name="submit" >Submit</button>
            </form>
        </div>

        <div class="image-container">
            <h3>Welcome to EDUSPHERE!</h3>
            <p>Your journey to better learning starts here. Register now to unlock all the features we have to offer!</p>
            <img class="logo" src="../images/logo2.png" alt="EDUSPHERE Logo">
        </div>
    </div>
</body>


</html>

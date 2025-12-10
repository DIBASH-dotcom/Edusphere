<?php
require_once "../connection.php"; // Database connection

session_start(); // Start session

// Check if the user is logged in and is a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    die("Unauthorized access.");
}

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    die("User ID is not set. Please log in.");
}

$message = ""; // Variable to hold any success or error messages

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = $_POST['exam_id']; // Get the exam ID from the form
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Prepare SQL statement to insert the request into the database
    $stmt = $con->prepare("INSERT INTO approval_requests_online (teacher_id, request_type, approval_status, user_id) 
                           VALUES (NULL, ?, 'pending', ?)");
    $stmt->bind_param("si", $exam_id, $user_id); // Bind exam_id and user_id to the request

    if ($stmt->execute()) {
        // If the request is successfully inserted, display a success message
        $message = "Exam approval request submitted.";
    } else {
        // If there's an error, display the error message
        $message = "Error: " . $stmt->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Exam Approval</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 400px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            margin-top: 10px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Request Exam Approval</h2>

    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

    <form action="" method="POST">
        <label for="exam_id">Exam ID:</label>
        <input type="text" id="exam_id" name="exam_id" required>

        <button type="submit">Submit Request</button>
    </form>
</div>

</body>
</html>

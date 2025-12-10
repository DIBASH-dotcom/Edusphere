<?php
include('../connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $note_title = $_POST['note_title'];

    // Initialize file_path to an empty string in case no file is uploaded
    $file_path = '';

    // Check if the file is uploaded
    if (isset($_FILES['file']['name']) && $_FILES['file']['error'] == 0) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        // Define the file upload directory
        $upload_dir = "uploads/"; // Ensure this directory exists in your project

        // Generate a unique file name to avoid conflicts
        $file_path = $upload_dir . uniqid() . "-" . $file_name;

        // Move the uploaded file to the desired location
        if (!move_uploaded_file($file_tmp, $file_path)) {
            echo "<p class='error-message'>Error uploading the file.</p>";
            exit;
        }
    }

    // Insert new note without book_id
    $query = $con->prepare("INSERT INTO notes_lms_libarray (note_title, file_path) VALUES (?, ?)");
    $query->bind_param("ss", $note_title, $file_path);

    if ($query->execute()) {
        echo "<p class='success-message'>Note added successfully!</p>";
    } else {
        echo "<p class='error-message'>Error adding note: " . $query->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Notes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input {
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #0056b3;
        }
        .success-message {
            color: green;
            text-align: center;
        }
        .error-message {
            color: red;
            text-align: center;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Add New Note</h1>

    <form method="POST" action="add_notes.php" enctype="multipart/form-data">
        <label for="note_title">Note Title:</label>
        <input type="text" name="note_title" id="note_title" required>

        <label for="file">Upload Note (Optional):</label>
        <input type="file" name="file" id="file" accept=".pdf,.docx,.txt">

        <button type="submit">Add Note</button>
    </form>

    <a class="back-link" href="admin_dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>

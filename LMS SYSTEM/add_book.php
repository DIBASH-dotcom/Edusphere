<?php
include('../connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $publication = $_POST['publication'];
    $book_image = $_FILES['book_image'];

    // Validate if the image is uploaded
    if ($book_image['error'] === UPLOAD_ERR_OK) {
        // Set the image file path and validate file type
        $target_dir = "../uploads/";  // You can change this directory to your desired folder
        $target_file = $target_dir . basename($book_image["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if the uploaded file is an image
        $check = getimagesize($book_image["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            exit;
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($book_image["tmp_name"], $target_file)) {
            // Prepare the query to insert the new book into the database
            $query = $con->prepare("INSERT INTO books_lms_libarray (book_name, author, publication, book_image) VALUES (?, ?, ?, ?)");
            $query->bind_param("ssss", $book_name, $author, $publication, $target_file);

            // Execute the query and check if the book is added successfully
            if ($query->execute()) {
                echo "<p class='success-message'>Book added successfully!</p>";
            } else {
                echo "<p class='error-message'>Error: " . $query->error . "</p>";
            }
        } else {
            echo "<p class='error-message'>Sorry, there was an error uploading your file.</p>";
        }
    } else {
        echo "<p class='error-message'>Error uploading file.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
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
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #218838;
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
    <h1>Add New Book</h1>

    <form method="POST" action="add_book.php" enctype="multipart/form-data">
        <label for="book_name">Book Name:</label>
        <input type="text" name="book_name" id="book_name" required>

        <label for="author">Author:</label>
        <input type="text" name="author" id="author" required>

        <label for="publication">Publication:</label>
        <input type="text" name="publication" id="publication" required>

        <label for="book_image">Book Image:</label>
        <input type="file" name="book_image" id="book_image" accept="image/*" required>

        <button type="submit">Add Book</button>
    </form>

    <a class="back-link" href="../LMS SYSTEM/Admin Dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>

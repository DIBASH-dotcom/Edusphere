<?php
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $publication_year = $_POST['publication_year'];
    
    $query = "INSERT INTO books (title, author, isbn, publication_year) VALUES ('$title', '$author', '$isbn', '$publication_year')";
    mysqli_query($con, $query);
    header('Location: ../Libarary/LibraryService.php');
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
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 1rem;
            color: #555;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #4A90E2;
            outline: none;
        }

        .submit-btn {
            padding: 12px 25px;
            background-color: #4A90E2;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #357ABD;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Book</h1>
        <form method="POST">
            <div class="input-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div class="input-group">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" required>
            </div>
            <div class="input-group">
                <label for="isbn">ISBN</label>
                <input type="text" name="isbn" id="isbn" required>
            </div>
            <div class="input-group">
                <label for="publication_year">Publication Year</label>
                <input type="number" name="publication_year" id="publication_year" required>
            </div>
            <button type="submit" class="submit-btn">Add Book</button>
        </form>
    </div>
</body>
</html>

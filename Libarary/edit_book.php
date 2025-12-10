<?php
include('../connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the current book details from the database
    $stmt = $con->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    
    if (!$book) {
        echo "Book not found!";
        exit;
    }

    if (isset($_POST["submit"])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $publication_year = $_POST['publication_year'];

        // Update the book details in the database
        $update_query = "UPDATE books SET title = ?, author = ?, isbn = ?, publication_year = ? WHERE id = ?";
        $stmt = $con->prepare($update_query);
        $stmt->bind_param("sssii", $title, $author, $isbn, $publication_year, $id);
        $stmt->execute();
        header('Location: ../Libarary/LibraryService.php');
    }
} else {
    echo "Book ID not provided!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        /* Heading styling */
        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        /* Form container */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        /* Label styling */
        label {
            font-size: 1rem;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }

        /* Input field styling */
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            color: #333;
        }

        /* Focus effect for inputs */
        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #5c9dff;
            outline: none;
        }

        /* Button styling */
        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        /* Button hover effect */
        button:hover {
            background-color: #45a049;
        }

        /* Button focus effect */
        button:focus {
            outline: none;
        }

        /* Error message */
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Edit Book Details</h1>
    <form  action="edit_book.php" method="POST">
        <label for="title">Title</label>
        <input type="text" name="title" value="<?php echo $book['title']; ?>" required>
        
        <label for="author">Author</label>
        <input type="text" name="author" value="<?php echo $book['author']; ?>" required>
        
        <label for="isbn">ISBN</label>
        <input type="text" name="isbn" value="<?php echo $book['isbn']; ?>" required>
        
        <label for="publication_year">Publication Year</label>
        <input type="number" name="publication_year" value="<?php echo $book['publication_year']; ?>" required>
        
        <button type="submit" name="submit">Update Book</button>
    </form>
</body>
</html>

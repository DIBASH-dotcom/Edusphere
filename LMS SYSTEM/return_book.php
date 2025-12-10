<?php
include('../connection.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if user is not logged in
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];

    // Check if the book is borrowed by the user
    $check_query = $con->prepare("SELECT borrow_id FROM borrowed_books_lms_libarray WHERE user_id = ? AND book_id = ? AND return_date IS NULL");
    $check_query->bind_param("ii", $user_id, $book_id);
    $check_query->execute();
    $result = $check_query->get_result();

    if ($result->num_rows > 0) {
        // Mark the book as returned
        $return_query = $con->prepare("UPDATE borrowed_books_lms_libarray SET return_date = NOW() WHERE user_id = ? AND book_id = ? AND return_date IS NULL");
        $return_query->bind_param("ii", $user_id, $book_id);
        
        if ($return_query->execute()) {
            // Update the book status to available
            $update_query = $con->prepare("UPDATE books_lms_libarray SET status = 'available' WHERE book_id = ?");
            $update_query->bind_param("i", $book_id);
            $update_query->execute();

            // Fetch the book image
            $image_query = $con->prepare("SELECT book_image FROM books_lms_libarray WHERE book_id = ?");
            $image_query->bind_param("i", $book_id);
            $image_query->execute();
            $image_result = $image_query->get_result();

            if ($image_result->num_rows > 0) {
                $image_row = $image_result->fetch_assoc();
                $book_image = $image_row['book_image'];

                echo "Book returned successfully!<br>";
                echo "Book Image: <img src='../uploads/$book_image' alt='Book Image' width='100'><br>";
            } else {
                echo "Book returned successfully!";
            }
        } else {
            echo "Error returning the book!";
        }
    } else {
        echo "You have not borrowed this book or the book has already been returned!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .container h1 {
            text-align: center;
            color: #333;
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
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #1f40af;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Return Book</h1>

        <form method="POST" action="return_book.php" onsubmit="return validateForm()">
            <label for="book_id">Book ID:</label>
            <input type="number" name="book_id" id="book_id" class="input-field" required>
            
            <button type="submit" class="btn-submit">Return</button>
        </form>

        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
    </div>

    <script>
        // JavaScript to validate the form
        function validateForm() {
            var bookId = document.getElementById("book_id").value;

            if (bookId === "") {
                alert("Please enter the Book ID.");
                return false;
            }

            return true;
        }
    </script>

</body>
</html>

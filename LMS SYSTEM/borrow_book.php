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

    // Check if the book exists and is available
    $check_query = $con->prepare("SELECT status FROM books_lms_libarray WHERE book_id = ?");
    $check_query->bind_param("i", $book_id);
    $check_query->execute();
    $result = $check_query->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['status'] === 'available') {
            // Borrow the book if it's available
            $borrow_query = $con->prepare("INSERT INTO borrowed_books_lms_libarray (user_id, book_id) VALUES (?, ?)");
            $borrow_query->bind_param("ii", $user_id, $book_id);
            
            if ($borrow_query->execute()) {
                // Update the book status to borrowed
                $update_query = $con->prepare("UPDATE books_lms_libarray SET status = 'borrowed' WHERE book_id = ?");
                $update_query->bind_param("i", $book_id);
                $update_query->execute();
                echo "<p class='success-message'>Book borrowed successfully!</p>";
            } else {
                echo "<p class='error-message'>Error borrowing the book!</p>";
            }
        } else {
            echo "<p class='error-message'>Book is already borrowed!</p>";
        }
    } else {
        echo "<p class='error-message'>Book not found!</p>";
    }
}

// Fetch borrowed books and their images
$borrowed_books_query = $con->prepare("SELECT b.book_id, b.book_name, b.book_image FROM borrowed_books_lms_libarray bb 
                                      JOIN books_lms_libarray b ON bb.book_id = b.book_id
                                      WHERE bb.user_id = ?");
$borrowed_books_query->bind_param("i", $_SESSION['user_id']);
$borrowed_books_query->execute();
$borrowed_books_result = $borrowed_books_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h1, h2 {
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
        .book-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }
        .book-item {
            background: white;
            padding: 10px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 150px;
        }
        .book-item img {
            width: 100px;
            height: 140px;
            object-fit: cover;
            border-radius: 5px;
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
    <h1>Borrow Book</h1>

    <form method="POST" action="borrow_book.php">
        <label for="book_id">Book ID:</label>
        <input type="number" name="book_id" id="book_id" required>

        <button type="submit">Borrow</button>
    </form>
</div>

<h2>Your Borrowed Books</h2>
<div class="book-container">
    <?php if ($borrowed_books_result->num_rows > 0): ?>
        <?php while ($borrowed_book = $borrowed_books_result->fetch_assoc()): ?>
            <div class="book-item">
                <h3><?php echo htmlspecialchars($borrowed_book['book_name']); ?></h3>
                <img src="<?php echo htmlspecialchars($borrowed_book['book_image']); ?>" alt="<?php echo htmlspecialchars($borrowed_book['book_name']); ?>">
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>You have not borrowed any books yet.</p>
    <?php endif; ?>
</div>

<a class="back-link" href="dashboard.php">Back to Dashboard</a>

</body>
</html>

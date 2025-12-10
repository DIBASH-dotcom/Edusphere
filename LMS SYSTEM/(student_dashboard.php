<?php
include('../connection.php');
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Capture book return messages
$return_message = '';
$return_image = '';
if (isset($_GET['returned_book'])) {
    $return_message = $_GET['returned_book_message'];
    $return_image = $_GET['returned_book_image'];
}

// Fetch available books
$available_books_query = "SELECT * FROM books_lms_libarray WHERE status = 'available'";
$available_books_result = $con->query($available_books_query);

// Fetch borrowed books (not returned)
$borrowed_books_query = "SELECT bb.borrow_id, bb.book_id, bb.borrow_date, bb.return_date, b.book_name, b.book_image
                         FROM borrowed_books_lms_libarray bb
                         JOIN books_lms_libarray b ON bb.book_id = b.book_id
                         WHERE bb.user_id = ? AND bb.return_date IS NULL";
$borrowed_books_stmt = $con->prepare($borrowed_books_query);
$borrowed_books_stmt->bind_param("i", $user_id);
$borrowed_books_stmt->execute();
$borrowed_books_result = $borrowed_books_stmt->get_result();

// Fetch returned books
$returned_books_query = "SELECT bb.borrow_id, bb.book_id, bb.borrow_date, bb.return_date, b.book_name
                         FROM borrowed_books_lms_libarray bb
                         JOIN books_lms_libarray b ON bb.book_id = b.book_id
                         WHERE bb.user_id = ? AND bb.return_date IS NOT NULL";
$returned_books_stmt = $con->prepare($returned_books_query);
$returned_books_stmt->bind_param("i", $user_id);
$returned_books_stmt->execute();
$returned_books_result = $returned_books_stmt->get_result();

// Fetch notes uploaded by the admin
$notes_query = "SELECT note_title, file_path FROM notes_lms_libarray";
$notes_result = $con->query($notes_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script>
</head>
<body>
    <div class="container">
        <h1>Student Dashboard</h1>

        <p><strong>Your User ID:</strong> <?php echo $user_id; ?></p>

        <nav>
            <a href="../LMS SYSTEM/view_notes.php">View Notes</a>
            <a href="../LMS SYSTEM/return_book.php">Return Book</a>
        </nav>

        <?php if ($return_message) { ?>
            <p class="message success"><?php echo $return_message; ?></p>
            <img src="../uploads/<?php echo $return_image; ?>" alt="Returned Book Image" width="100">
        <?php } ?>

        <h2>Available Books</h2>
        <table>
            <tr>
                <th>Book ID</th>
                <th>Book Name</th>
                <th>Author</th>
                <th>Publication</th>
                <th>Action</th>
                <th>Book Image</th>
            </tr>
            <?php while ($row = $available_books_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['book_id']; ?></td>
                    <td><?php echo $row['book_name']; ?></td>
                    <td><?php echo $row['author']; ?></td>
                    <td><?php echo $row['publication']; ?></td>
                    <td><a href="borrow_book.php?book_id=<?php echo $row['book_id']; ?>" class="borrow-btn">Borrow</a></td>
                    <td><img src="<?php echo $row['book_image']; ?>" alt="Book Image" width="100"></td>
                </tr>
            <?php } ?>
        </table>

        <h2>Your Borrowed Books (Not Returned Yet)</h2>
        <table>
            <tr>
                <th>Book ID</th>
                <th>Book Name</th>
                <th>Borrow Date</th>
                <th>Return</th>
                <th>Book Image</th>
            </tr>
            <?php while ($row = $borrowed_books_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['book_id']; ?></td>
                    <td><?php echo $row['book_name']; ?></td>
                    <td><?php echo $row['borrow_date']; ?></td>
                    <td><a href="return_book.php?borrow_id=<?php echo $row['borrow_id']; ?>&book_id=<?php echo $row['book_id']; ?>" class="return-btn" onclick="return confirmReturn()">Return</a></td>
                    <td><img src="<?php echo $row['book_image']; ?>" alt="Book Image" width="100"></td>
                </tr>
            <?php } ?>
        </table>

        <h2>Your Returned Books</h2>
        <table>
            <tr>
                <th>Book ID</th>
                <th>Book Name</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
            </tr>
            <?php while ($row = $returned_books_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['book_id']; ?></td>
                    <td><?php echo $row['book_name']; ?></td>
                    <td><?php echo $row['borrow_date']; ?></td>
                    <td><?php echo $row['return_date']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <h2>Notes Available</h2>
        <table>
            <tr>
                <th>Note Title</th>
                <th>Download</th>
            </tr>
            <?php while ($row = $notes_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['note_title']; ?></td>
                    <td><a href="../uploads/<?php echo $row['file_path']; ?>" download>Download</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px #ccc;
}

h1, h2 {
    text-align: center;
}

nav {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

nav a {
    margin: 0 10px;
    padding: 10px 15px;
    background: #007BFF;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: center;
}

.message.success {
    color: green;
    text-align: center;
    font-weight: bold;
}

.borrow-btn, .return-btn {
    padding: 5px 10px;
    background: #28a745;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.return-btn {
    background: #dc3545;
}

img {
    border-radius: 5px;
}
</style>

<script>
function confirmReturn() {
    return confirm("Are you sure you want to return this book?");
}
</script>

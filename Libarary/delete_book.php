<?php
include('../connection.php');

// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the book from the database
    $delete_query = "DELETE FROM books WHERE id = $id";
    if (mysqli_query($con, $delete_query)) {
        // Redirect to the book list page after deletion
        header('Location: ../Libarary/LibraryService.php');
    } else {
        echo "Error deleting book: " . mysqli_error($con);
    }
} else {
    echo "Book not found!";
    exit;
}
?>

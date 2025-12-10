<?php
include('../connection.php');
$query = "SELECT * FROM books";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f4f7fc, #e3eaf5); /* Soft gradient background */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container */
        .container {
            width: 80%;
            max-width: 1200px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Heading styling */
        h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 1px;
        }

        /* Add new book button styling */
        .add-book-btn {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            padding: 12px 25px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 1.1rem;
            margin-bottom: 20px;
            transition: background-color 0.3s;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .add-book-btn:hover {
            background-color: #45a049;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        /* Table header styling */
        thead {
            background-color: #f5f5f5;
        }

        th {
            font-size: 1.1rem;
            color: #555;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }

        /* Table row styling */
        tbody tr {
            border-bottom: 1px solid #f5f5f5;
        }

        td {
            padding: 12px;
            font-size: 1rem;
        }

        /* Action buttons styling */
        .edit-btn, .delete-btn {
            display: inline-block;
            padding: 6px 12px;
            margin-right: 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: transform 0.2s ease;
        }

        .edit-btn {
            background-color: #5c9dff;
            color: #fff;
        }

        .edit-btn:hover {
            background-color: #4a8ad2;
            transform: translateY(-2px);
        }

        .delete-btn {
            background-color: #f44336;
            color: #fff;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
            transform: translateY(-2px);
        }

        /* Hover effect for table rows */
        tbody tr:hover {
            background-color: #f9f9f9;
        }

        /* Smooth scrolling effect */
        html {
            scroll-behavior: smooth;
        }

        /* Responsive design */
        @media screen and (max-width: 768px) {
            .container {
                width: 90%;
            }
            h1 {
                font-size: 2rem;
            }
            .add-book-btn {
                font-size: 1rem;
                padding: 10px 20px;
            }
            td {
                font-size: 0.9rem;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="../pages/HomePage.php">Go to Homepage</a> <!-- Corrected the link -->
        <h1>Library System</h1>
        <a href="add_book.php" class="add-book-btn">Add New Book</a>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Publication Year</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['author']); ?></td>
                    <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                    <td><?php echo htmlspecialchars($row['publication_year']); ?></td>
                    <td>
                        <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                        <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirmDelete();">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this book?");
        }
    </script>
</body>
</html>

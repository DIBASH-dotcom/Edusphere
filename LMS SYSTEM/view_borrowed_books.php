<?php
include('../connection.php');

// Query to get borrowed books with student details
$query = "SELECT users_lms_libarray.full_name, users_lms_libarray.department, users_lms_libarray.year, books_lms_libarray.book_name, borrowed_books_lms_libarray.borrow_date 
          FROM borrowed_books_lms_libarray
          JOIN users_lms_libarray ON borrowed_books_lms_libarray.user_id = users_lms_libarray.user_id
          JOIN books_lms_libarray ON borrowed_books_lms_libarray.book_id = books_lms_libarray.book_id";

$result = $con->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Borrowed Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            width: 150px;
        }

        a:hover {
            background-color: #2563eb;
        }

    </style>
</head>
<body>
    <h1>Borrowed Books</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Student Name</th>
                <th>Department</th>
                <th>Year</th>
                <th>Book Name</th>
                <th>Borrow Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['department']); ?></td>
                    <td><?php echo htmlspecialchars($row['year']); ?></td>
                    <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['borrow_date']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No borrowed books found.</p>
    <?php endif; ?>

    <a href="dashboard.php">Back to Dashboard</a>

    <script>
        // Simple JavaScript to enhance user experience (for example, highlight table rows on hover)
        const rows = document.querySelectorAll('table tr');
        rows.forEach(row => {
            row.addEventListener('mouseover', function() {
                this.style.backgroundColor = '#f1f1f1';
            });
            row.addEventListener('mouseout', function() {
                this.style.backgroundColor = '';
            });
        });
    </script>
</body>
</html>

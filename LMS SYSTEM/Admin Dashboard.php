<?php
include('../connection.php');
session_start();

// PHP code remains unchanged
$users_per_department_query = "SELECT department, COUNT(*) as total_users FROM users_lms_libarray GROUP BY department";
$users_per_department_result = $con->query($users_per_department_query);

$books_query = "SELECT * FROM books_lms_libarray";
$books_result = $con->query($books_query);

$borrowed_books_query = "SELECT bb.borrow_id, bb.user_id, bb.book_id, u.full_name, u.department, u.year, u.part, bb.borrow_date, b.book_name
                         FROM borrowed_books_lms_libarray bb
                         JOIN users_lms_libarray u ON bb.user_id = u.user_id
                         JOIN books_lms_libarray b ON bb.book_id = b.book_id
                         WHERE bb.return_date IS NULL";
$borrowed_books_result = $con->query($borrowed_books_query);

$returned_books_query = "SELECT bb.borrow_id, bb.user_id, bb.book_id, u.full_name, u.department, u.year, u.part, bb.borrow_date, bb.return_date, b.book_name
                         FROM borrowed_books_lms_libarray bb
                         JOIN users_lms_libarray u ON bb.user_id = u.user_id
                         JOIN books_lms_libarray b ON bb.book_id = b.book_id";
$returned_books_result = $con->query($returned_books_query);

$total_users_query = "SELECT COUNT(*) as total_users FROM users_lms_libarray";
$total_users_result = $con->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['total_users'];

$total_borrowed_books = $borrowed_books_result->num_rows;
$total_returned_books = $returned_books_result->num_rows;

$departments = [];
$user_counts = [];

while ($row = $users_per_department_result->fetch_assoc()) {
    $departments[] = $row['department'];
    $user_counts[] = $row['total_users'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Library Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f39c12;
            --background-color: #f4f7f9;
            --text-color: #333;
            --card-bg: #ffffff;
            --hover-color: #3498db;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--primary-color);
            color: white;
            padding: 2rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
        }

        .nav-links {
            list-style: none;
        }

        .nav-links li {
            margin-bottom: 1rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--secondary-color);
        }

        .nav-links i {
            margin-right: 0.5rem;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .welcome-message {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card h2 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .stat-card {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .stat-card p {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #f0f0f0;
            font-weight: 600;
        }

        .book-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .chart-container {
            position: relative;
            margin: auto;
            height: 300px;
            width: 100%;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animated {
            animation: fadeIn 0.5s ease-out forwards;
        }

        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 1rem;
            }

            .main-content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo">LMS Admin</div>
            <ul class="nav-links">
                <li><a href="../AdminDashboard/AdminLogin.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="../LMS SYSTEM/add_book.php"><i class="fas fa-book"></i> Add Book</a></li>
                <li><a href="../LMS SYSTEM/add_notes.php"><i class="fas fa-sticky-note"></i> Add Notes</a></li>
             
                
            </ul>
        </aside>
        <main class="main-content">
            <header class="header">
                <div class="welcome-message">Welcome, <?php echo $_SESSION['AdminLoginId']?></div>
                <div>
                    
                </div>
            </header>

            <section class="card animated">
                <h2>Overview</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3><?php echo $total_users; ?></h3>
                        <p>Total Users</p>
                    </div>
                    <div class="stat-card">
                        <h3><?php echo $total_borrowed_books; ?></h3>
                        <p>Borrowed Books</p>
                    </div>
                    <div class="stat-card">
                        <h3><?php echo $total_returned_books; ?></h3>
                        <p>Returned Books</p>
                    </div>
                </div>
            </section>

            <section class="card animated">
                <h2>Available Books</h2>
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Book ID</th>
                                <th>Book Name</th>
                                <th>Author</th>
                                <th>Publication</th>
                                <th>Status</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $books_result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['book_id']; ?></td>
                                    <td><?php echo $row['book_name']; ?></td>
                                    <td><?php echo $row['author']; ?></td>
                                    <td><?php echo $row['publication']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td>
                                        <?php if (!empty($row['book_image'])) { ?>
                                            <img src="<?php echo $row['book_image']; ?>" alt="Book Image" class="book-image">
                                        <?php } else { ?>
                                            <i class="fas fa-book" style="font-size: 24px; color: #ccc;"></i>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="card animated">
                <h2>Borrowed Books</h2>
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Department</th>
                                <th>Year</th>
                                <th>Part</th>
                                <th>Book ID</th>
                                <th>Book Name</th>
                                <th>Borrow Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $borrowed_books_result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['full_name']; ?></td>
                                    <td><?php echo $row['department']; ?></td>
                                    <td><?php echo $row['year']; ?></td>
                                    <td><?php echo $row['part']; ?></td>
                                    <td><?php echo $row['book_id']; ?></td>
                                    <td><?php echo $row['book_name']; ?></td>
                                    <td><?php echo $row['borrow_date']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="card animated">
                <h2>Returned Books</h2>
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Department</th>
                                <th>Year</th>
                                <th>Part</th>
                                <th>Book ID</th>
                                <th>Book Name</th>
                                <th>Borrowed Date</th>
                                <th>Returned Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $returned_books_result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['full_name']; ?></td>
                                    <td><?php echo $row['department']; ?></td>
                                    <td><?php echo $row['year']; ?></td>
                                    <td><?php echo $row['part']; ?></td>
                                    <td><?php echo $row['book_id']; ?></td>
                                    <td><?php echo $row['book_name']; ?></td>
                                    <td><?php echo $row['borrow_date']; ?></td>
                                    <td><?php echo $row['return_date']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

                </div>
            </section>
        </main>
    </div>

</body>
</html>


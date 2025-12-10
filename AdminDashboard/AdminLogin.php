<?php
include('../connection.php');

$sql_users = "SELECT COUNT(*) as total_users FROM register";
$sql_exams = "SELECT COUNT(*) as exams_online FROM register";
$sql_courses = "SELECT COUNT(*) as total_courses FROM courses_online";
$sql_books = "SELECT COUNT(*) as available_books FROM books_lms_libarray";  

$result_users = $con->query($sql_users);
$result_exams = $con->query($sql_exams);
$result_courses = $con->query($sql_courses);
$result_books = $con->query($sql_books);
session_start();
$Admin_Name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin'; // Fallback to 'Admin' if not set


$total_users = 0;
$exams_online = 0;
$total_courses = 0;
$available_books = 0;

if ($result_users->num_rows > 0) {
    $row = $result_users->fetch_assoc();
    $total_users = $row['total_users'];
}

if ($result_exams->num_rows > 0) {
    $row = $result_exams->fetch_assoc();
    $exams_online = $row['exams_online'];
}

if ($result_courses->num_rows > 0) {
    $row = $result_courses->fetch_assoc();
    $total_courses = $row['total_courses'];
}

if ($result_books->num_rows > 0) {
    $row = $result_books->fetch_assoc();
    $available_books = $row['available_books'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EDU SPHERE</title>
    <style>
        /* Resetting some styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
        }

        /* Container for layout */
        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .sidebar h2 {
            margin-bottom: 30px;
            font-size: 24px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            display: block;
        }

        .sidebar ul li a:hover {
            background-color: #34495e;
            padding: 5px;
        }

        /* Main Content Styles */
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        header {
            background-color: #34495e;
            color: white;
            padding: 20px;
            border-radius: 8px;
        }

        header h1 {
            font-size: 28px;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }

        .stat-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 200px;
            text-align: center;
        }

        .stat-box h3 {
            font-size: 18px;
            color: #7f8c8d;
        }

        .stat-box p {
            font-size: 24px;
            color: #2c3e50;
            font-weight: bold;
        }

        .notifications {
            margin-top: 30px;
        }

        .notifications h2 {
            font-size: 22px;
            color: #2c3e50;
        }

        .notifications ul {
            list-style: none;
            padding: 0;
        }

        .notifications ul li {
            background-color: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        /* Pie chart container */
        .pie-chart {
            width: 50%;
            margin: 30px auto;
            padding: 20px;
        }
    </style>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>EDU SPHERE</h2>
            <ul>
                <li><a href="../OMS SYSTEM/admin_dashboard.php">OMS SYSTEM</a></li>
                <li><a href="../LMS SYSTEM/Admin Dashboard.php">LMS SYSTEM</a></li>
                
            
                <li><a href="../pages/logout.php">Logout</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header>
            <h2 class="welcome">Welcome, <?php echo $_SESSION['AdminLoginId']?>
            </header>

            <!-- Dashboard Stats -->
            <section class="stats">
                <div class="stat-box">
                    <h3>Total Users</h3>
                    <p><?php echo $total_users; ?></p>
                </div>
                <div class="stat-box">
                    <h3>Total Courses</h3>
                    <p><?php echo $total_courses; ?></p>
                </div>
                <div class="stat-box">
                    <h3>Exams Scheduled</h3>
                    <p><?php echo $exams_online; ?></p>
                </div>
                <div class="stat-box">
                    <h3>Library Books</h3>
                    <p><?php echo $available_books; ?></p>
                </div>
            </section>

            <!-- Pie Chart -->
            <section class="pie-chart">
                <canvas id="pieChart"></canvas>
            </section>

        
        </main>
    </div>

    <script>
        // Data for the pie chart
        const pieChartData = {
            labels: ['Total Users', 'Total Courses', 'Exams Scheduled', 'Library Books'],
            datasets: [{
                data: [<?php echo $total_users; ?>, <?php echo $total_courses; ?>, <?php echo $exams_online; ?>, <?php echo $available_books; ?>], // Updated to dynamic values
                backgroundColor: ['#3498db', '#2ecc71', '#f39c12', '#e74c3c'],
                hoverBackgroundColor: ['#2980b9', '#27ae60', '#f1c40f', '#c0392b'],
            }]
        };

        // Configuring the pie chart
        const config = {
            type: 'pie',
            data: pieChartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        };

        // Render the pie chart
        const ctx = document.getElementById('pieChart').getContext('2d');
        new Chart(ctx, config);
    </script>
    
</body>
</html>

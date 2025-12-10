<?php
session_start();
require_once "../connection.php";

// Ensure only students can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}


$exams = $con->query("SELECT * FROM exams_online WHERE status = 'active'");

$materials = $con->query("SELECT * FROM study_materials_online");

// Fetch student's exam results
$user_id = $_SESSION['user_id'];
$results = $con->query("SELECT * FROM results_online WHERE student_id = '$user_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Edusphere</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        }

        .card h3 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .exam-list, .material-list {
            list-style: none;
        }

        .exam-list li, .material-list li {
            margin-bottom: 0.5rem;
        }

        .exam-list a, .material-list a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .exam-list a:hover, .material-list a:hover {
            color: var(--hover-color);
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
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo">Edusphere</div>
            <ul class="nav-links">
                <li><a href="../OMS SYSTEM/student_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="../OMS SYSTEM/available_courses.php"><i class="fas fa-book"></i> Available Courses</a></li>
                <li><a href="../OMS SYSTEM/exam_list.php"><i class="fas fa-search"></i> Search List</a></li>
                
                <li><a href="../OMS SYSTEM/upload_material.php"><i class="fas fa-upload"></i> Upload Material</a></li>
              
            </ul>
        </aside>
        <main class="main-content">
            <header class="header">
                <div class="welcome-message">Welcome, <?php echo $_SESSION['name']; ?></div>
                <div>Student ID: <?php echo $_SESSION['user_id']; ?></div>
            </header>

           
                </ul>
            </section>

            <section class="card">
                <h3><i class="fas fa-book"></i> Download Books & Notes</h3>
                <ul class="material-list">
                    <?php while ($material = $materials->fetch_assoc()) { ?>
                        <li>
                            <i class="fas fa-file-pdf"></i>
                            <a href="uploads/<?php echo $material['filename']; ?>" target="_blank"><?php echo $material['title']; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </section>

            <section class="card">
                <h3><i class="fas fa-chart-bar"></i> Exam Results</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Score</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($result = $results->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $result['subject']; ?></td>
                                <td><?php echo $result['score']; ?></td>
                                <td><?php echo ucfirst($result['status']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>


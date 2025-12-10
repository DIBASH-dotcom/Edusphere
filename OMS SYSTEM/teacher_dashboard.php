<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
}

require_once "../connection.php";

$teacher_id = $_SESSION['user_id'];

// Handle deletion of exam
if (isset($_GET['delete_exam_id'])) {
    $delete_exam_id = (int)$_GET['delete_exam_id'];

    // Verify if the exam belongs to the logged-in teacher
    $sql_check = "SELECT * FROM exams_online WHERE exam_id = ? AND teacher_id = ?";
    $stmt_check = $con->prepare($sql_check);
    $stmt_check->bind_param("ii", $delete_exam_id, $teacher_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Proceed with deletion
        $sql_delete = "DELETE FROM exams_online WHERE exam_id = ?";
        $stmt_delete = $con->prepare($sql_delete);
        $stmt_delete->bind_param("i", $delete_exam_id);

        if ($stmt_delete->execute()) {
            // Redirect to dashboard after successful deletion
            header("Location: teacher_dashboard.php");
            exit();
        } else {
            echo "Error deleting exam: " . $con->error;
        }
    } else {
        echo "Exam not found or you do not have permission to delete it.";
    }
}

// Pagination settings
$limit = 5; // Number of exams per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch teacher's exams with pagination
$sql = "SELECT * FROM exams_online WHERE teacher_id = ? LIMIT ? OFFSET ?";
$stmt = $con->prepare($sql);
if ($stmt) {
    $stmt->bind_param("iii", $teacher_id, $limit, $offset);
    $stmt->execute();
    $exams = $stmt->get_result();
} else {
    echo "Error preparing query: " . $con->error;
}

// Fetch total count of exams for pagination
$sql_count = "SELECT COUNT(*) as total FROM exams_online WHERE teacher_id = ?";
$stmt_count = $con->prepare($sql_count);
if ($stmt_count) {
    $stmt_count->bind_param("i", $teacher_id);
    $stmt_count->execute();
    $count_result = $stmt_count->get_result()->fetch_assoc();
    $total_exams = $count_result['total'];
    $total_pages = ceil($total_exams / $limit);
} else {
    echo "Error preparing query: " . $con->error;
}

// Fetch pending approval requests
$sql2 = "SELECT ar.id, e.exam_id, ar.teacher_id, s.user_id, s.department, s.year_part 
         FROM approval_requests_online ar
         JOIN exams_online e ON e.teacher_id = ar.teacher_id
         JOIN students_online s ON s.department = e.department AND s.year_part = e.year_part 
         WHERE ar.approval_status = 'pending' AND e.teacher_id = ?";
$stmt2 = $con->prepare($sql2);
if ($stmt2) {
    $stmt2->bind_param("i", $teacher_id);
    $stmt2->execute();
    $pending_requests = $stmt2->get_result();
} else {
    echo "Error preparing query: " . $con->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Edusphere</title>
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

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: var(--hover-color);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: #e67e22;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }

        .pagination a {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: var(--hover-color);
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
                <li><a href="#"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="../OMS SYSTEM/add_course.php"><i class="fas fa-plus-circle"></i> Add Course</a></li>
                <li><a href="../OMS SYSTEM/available_courses.php"><i class="fas fa-book"></i> Available Courses</a></li>
                <li><a href="../OMS SYSTEM/create_exam.php"><i class="fas fa-file-alt"></i> Create Exam</a></li>
                
                <li><a href="../pages/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <header class="header">
                <div class="welcome-message">Welcome, <?php echo $_SESSION['name']; ?></div>
                <div>Teacher ID: <?php echo $_SESSION['user_id']; ?></div>
            </header>

            <section class="card">
                <h3>Your Created Exams</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Exam ID</th>
                            <th>Subject</th>
                            <th>Department</th>
                            <th>Year</th>
                            <th>Exam Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($exam = $exams->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $exam['exam_id']; ?></td>
                                <td><?php echo $exam['subject']; ?></td>
                                <td><?php echo $exam['department']; ?></td>
                                <td><?php echo $exam['year_part']; ?></td>
                                <td><?php echo $exam['exam_date']; ?></td>
                                <td><?php echo $exam['status']; ?></td>
                                <td>
                                    <?php if ($exam['status'] == 'pending') { ?>
                                        <a href="verify_exam.php?exam_id=<?php echo $exam['exam_id']; ?>" class="btn">Verify</a>
                                    <?php } else { ?>
                                       
                                    <?php } ?>
                                    <a href="teacher_dashboard.php?delete_exam_id=<?php echo $exam['exam_id']; ?>" class="btn btn-secondary" onclick="return confirm('Are you sure you want to delete this exam?');">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <a href="teacher_dashboard.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php } ?>
                </div>
            </section>

            <section class="card">
                <h3>Pending Approval Requests</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Department</th>
                            <th>Year</th>
                            <th>Exam ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($request = $pending_requests->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $request['user_id']; ?></td>
                                <td><?php echo $request['department']; ?></td>
                                <td><?php echo !empty($request['year_part']) ? $request['year_part'] : 'Not Available'; ?></td>
                                <td><?php echo $request['exam_id']; ?></td>
                                <td>
                                    <a href="approve_student.php?request_id=<?php echo $request['id']; ?>" class="btn">Approve</a>
                                    <a href="reject_student.php?request_id=<?php echo $request['id']; ?>" class="btn btn-secondary">Reject</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>


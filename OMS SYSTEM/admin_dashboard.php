<?php
session_start();
require_once "../connection.php";

// Function to check if a teacher exists in the database
function checkTeacherExists($teacher_id, $con) {
    $check_teacher_sql = "SELECT id FROM users_online WHERE id = ?";
    if ($stmt_check = $con->prepare($check_teacher_sql)) {
        $stmt_check->bind_param('i', $teacher_id);
        $stmt_check->execute();
        $stmt_check->store_result();
        return $stmt_check->num_rows > 0;
    }
    return false;
}

// Function to upload course image
function uploadCourseImage($file) {
    if (isset($file) && $file['error'] == 0) {
        $image_name = $file['name'];
        $image_tmp_name = $file['tmp_name'];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);

        // Set a unique file name
        $course_image = 'uploads/' . uniqid() . '.' . $image_extension;

        // Move the uploaded file to the desired location
        move_uploaded_file($image_tmp_name, $course_image);

        return $course_image;
    }
    return NULL;
}

// Handle course addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_course'])) {
    // Get form values
    $course_name = $_POST['course_name'];
    $teacher_id = $_POST['teacher_id'];
    $department = $_POST['department'];
    $year_part = $_POST['year_part'];

    // Check if teacher ID exists
    if (!checkTeacherExists($teacher_id, $con)) {
        echo "Error: Teacher ID does not exist.";
        exit;
    }

    // Handle file upload for course image
    $course_image = uploadCourseImage($_FILES['course_image']);

    // Prepare the SQL query to insert data into the table
    $sql = "INSERT INTO courses_online (course_name, teacher_id, department, year_part, course_image) 
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $con->prepare($sql)) {
        // Bind parameters and execute the query
        $stmt->bind_param('sisss', $course_name, $teacher_id, $department, $year_part, $course_image);

        if ($stmt->execute()) {
            echo "Course added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $con->error;
    }
}


// Fetch courses, users, materials, and exam reports
$courses = $con->query("SELECT * FROM courses_online");
$users = $con->query("SELECT id, name, role FROM users_online");
$materials = $con->query("SELECT * FROM study_materials_online");
$exam_reports = $con->query("SELECT * FROM exams_online");

// Fetch data for the pie chart
$course_count_sql = "SELECT COUNT(*) AS total_courses FROM courses_online";
$teacher_count_sql = "SELECT COUNT(DISTINCT teacher_id) AS total_teachers FROM courses_online";
$student_count_sql = "SELECT COUNT(*) AS total_students FROM users_online WHERE role = 'student'";

$course_count_result = $con->query($course_count_sql);
$teacher_count_result = $con->query($teacher_count_sql);
$student_count_result = $con->query($student_count_sql);

$course_count = $course_count_result->fetch_assoc()['total_courses'];
$teacher_count = $teacher_count_result->fetch_assoc()['total_teachers'];
$student_count = $student_count_result->fetch_assoc()['total_students'];

// Data for pie chart
$chart_data = [
    'courses' => $course_count,
    'teachers' => $teacher_count,
    'students' => $student_count
];

// Handle user deletion
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    $delete_user_sql = "DELETE FROM users_online WHERE id = ?";
    if ($stmt_delete = $con->prepare($delete_user_sql)) {
        $stmt_delete->bind_param('i', $user_id);
        if ($stmt_delete->execute()) {
            echo "User deleted successfully.";
        } else {
            echo "Error deleting user: " . $stmt_delete->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Online Management System</title>
    <style>
        .container {
            max-width: 1100px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .chart-container {
            width: 400px;
            height: 400px;
            margin: 40px auto;
            display: block;
            background-color: white;
            margin-right: 1.5rem;
            
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
            padding: 10px;
            text-align: left;
        }
        input[type="text"], input[type="file"], input[type="number"], input[type="submit"] {
            padding: 10px;
            margin: 5px;
            width: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">
</aside>
<div class="welcome-message">Welcome, <?php echo $_SESSION['AdminLoginId']?></div>
    <h2>Admin Dashboard - Online Management System</h2>
    <p>Here you can manage courses, users, uploaded materials, and exam reports.</p>

    <!-- Course Management Form -->
    <h3>Manage Courses</h3>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="text" name="course_name" required placeholder="Course Name"><br>
        <input type="number" name="teacher_id" required placeholder="Teacher ID"><br>
        <input type="text" name="department" required placeholder="Department"><br>
        <input type="text" name="year_part" required placeholder="Year/Part"><br>
        <input type="file" name="course_image"><br>
        <input type="submit" name="add_course" value="Add Course">
    </form>

    <!-- Existing Courses -->
    <h3>Existing Courses</h3>
    <table>
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Teacher</th>
                <th>Department</th>
                <th>Year/Part</th>
                <th>Course Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($course = $courses->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $course['course_name']; ?></td>
                    <td>
                        <?php
                        $teacher_result = $con->query("SELECT name FROM users_online WHERE id = " . $course['teacher_id']);
                        $teacher = $teacher_result->fetch_assoc();
                        echo $teacher['name'];
                        ?>
                    </td>
                    <td><?php echo $course['department']; ?></td>
                    <td><?php echo $course['year_part']; ?></td>
                    <td>
                        <?php if ($course['course_image']) { ?>
                            <img src="<?php echo $course['course_image']; ?>" alt="Course Image" width="50">
                        <?php } ?>
                    </td>
                    <td><a href="delete_course.php?id=<?php echo $course['course_id']; ?>" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Manage Users -->
    <h3>Manage Users</h3>
    <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Role</th>
            
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $users->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['role']; ?></td>
  
                </tr>
            <?php } ?>
        </tbody>
    </table>
    
  
    <!-- Dashboard Statistics -->
    <h3>Dashboard Statistics</h3>
    <div class="chart-container">
        <canvas id="pieChart"></canvas>
    </div>

    <script>
        const chartData = <?php echo json_encode($chart_data); ?>;

        const pieChartData = {
            labels: ['Courses', 'Teachers', 'Students'],
            datasets: [{
                data: [chartData.courses, chartData.teachers, chartData.students],
                backgroundColor: ['green', 'blue', '#FFCE56']
            }]
        };

        const ctx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctx, {
            type: 'pie',
            data: pieChartData
        });
    </script>
</div>

</body>
</html>

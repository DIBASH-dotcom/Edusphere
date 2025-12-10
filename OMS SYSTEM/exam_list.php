<?php
session_start();
require_once "../connection.php";

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    die("Access Denied! Only students can participate in exams.");
}

// Initialize variables
$exam_id = $department = $year_part = $subject = "";
$search_condition = "WHERE status = 'active'"; // Default search condition for active exams

// Check if the form is submitted and fetch the input data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = $_POST['exam_id'];
    $department = $_POST['department'];
    $year_part = $_POST['year_part'];
    $subject = $_POST['subject'];

    // Dynamically build search conditions based on user input
    if (!empty($exam_id)) {
        $search_condition .= " AND exam_id = ?";
    }
    if (!empty($department)) {
        $search_condition .= " AND department = ?";
    }
    if (!empty($year_part)) {
        $search_condition .= " AND year_part = ?";
    }
    if (!empty($subject)) {
        $search_condition .= " AND subject = ?";
    }
}

// Prepare the SQL query with dynamic conditions
$sql = "SELECT * FROM exams_online $search_condition";

// Prepare the statement
$stmt = $con->prepare($sql);

// Bind parameters based on input
$bind_types = ""; // Store the types for binding
$bind_values = []; // Store the values to bind

// Add conditions to binding dynamically
if (!empty($exam_id)) {
    $bind_types .= "i";  // Integer type for exam_id
    $bind_values[] = $exam_id;
}
if (!empty($department)) {
    $bind_types .= "s";  // String type for department
    $bind_values[] = $department;
}
if (!empty($year_part)) {
    $bind_types .= "s";  // String type for year_part
    $bind_values[] = $year_part;
}
if (!empty($subject)) {
    $bind_types .= "s";  // String type for subject
    $bind_values[] = $subject;
}

// Bind the parameters to the prepared statement
if ($bind_types) {
    $stmt->bind_param($bind_types, ...$bind_values);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Exams</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        form {
            margin: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
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
            background-color: #f4f4f4;
        }
        td a {
            color: #4CAF50;
            text-decoration: none;
        }
        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h2>Search Exam</h2>
        <li><a href="../OMS SYSTEM/student_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
    </header>

    <form method="post">
        <label>Exam ID:</label>
        <input type="text" name="exam_id" value="<?php echo htmlspecialchars($exam_id); ?>"><br>

        <label>Department:</label>
        <input type="text" name="department" value="<?php echo htmlspecialchars($department); ?>"><br>

        <label>Year/Part:</label>
        <input type="text" name="year_part" value="<?php echo htmlspecialchars($year_part); ?>"><br>

        <label>Subject:</label>
        <input type="text" name="subject" value="<?php echo htmlspecialchars($subject); ?>"><br>

        <button type="submit">Search Exam</button>
    </form>

    <h2>Available Exams</h2>
    <table>
        <tr>
            <th>Exam ID</th>
            <th>Subject</th>
            <th>Department</th>
            <th>Year/Part</th>
            <th>Exam Date</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['exam_id']; ?></td>
            <td><?php echo $row['subject']; ?></td>
            <td><?php echo $row['department']; ?></td>
            <td><?php echo $row['year_part']; ?></td>
            <td><?php echo $row['exam_date']; ?></td>
            <td><a href="participate_exam.php?exam_id=<?php echo $row['exam_id']; ?>">Participate</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php 
$stmt->close();  // Close the statement
$con->close();   // Close the connection
?>

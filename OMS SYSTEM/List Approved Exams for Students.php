<?php
require_once "../connection.php";
session_start();

if ($_SESSION['role'] !== 'student') {
    die("Unauthorized access.");
}

$result = $con->query("
    SELECT e.exam_id, e.subject, e.department, e.year_part, e.exam_date 
    FROM exams_online e
    JOIN approval_requests_online a ON e.exam_id = a.request_type
    WHERE a.approval_status = 'approved'
");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Exam ID: " . $row['exam_id'] . " - " . $row['subject'] . " (" . $row['department'] . ", " . $row['year_part'] . ") - " . $row['exam_date'] . "<br>";
    }
} else {
    echo "No approved exams available.";
}
?>

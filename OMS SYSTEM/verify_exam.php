<?php
session_start();
require_once "../connection.php";

if (isset($_GET['exam_id'])) {
    $exam_id = $_GET['exam_id'];
    $sql = "UPDATE exams_online SET status = 'verified' WHERE exam_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $exam_id);
    if ($stmt->execute()) {
        echo "<script>alert('Exam verified successfully!'); window.location.href='teacher_dashboard.php';</script>";
    }
}
?>

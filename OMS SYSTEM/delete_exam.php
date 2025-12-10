<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
}

require_once "../connection.php";

// Check if exam_id is provided in the URL
if (isset($_GET['exam_id'])) {
    $exam_id = (int)$_GET['exam_id'];
    $teacher_id = $_SESSION['user_id']; 

    // Verify if the exam belongs to the logged-in teacher
    $sql = "SELECT * FROM exams_online WHERE exam_id = ? AND teacher_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $exam_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    
        $sql_delete = "DELETE FROM exams_online WHERE exam_id = ?";
        $stmt_delete = $con->prepare($sql_delete);
        $stmt_delete->bind_param("i", $exam_id);

        if ($stmt_delete->execute()) {
        
            header("Location: teacher_dashboard.php");
            exit();
        } else {
            echo "Error deleting exam: " . $con->error;
        }
    } else {
        echo "Exam not found or you do not have permission to delete it.";
    }
} else {
    echo "Invalid exam ID.";
}
?>

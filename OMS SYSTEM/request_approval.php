<?php
session_start();
require_once "../connection.php";

// Fetch available exams from the database
$sql = "SELECT exam_id, subject FROM exams_online"; // Use 'subject' instead of 'exam_name'
$result = $con->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_approval'])) {
    $exam_id = $_POST['exam_id'];
    $request_type = 'exam_request'; // Mark the request type as 'exam_request'
    
    // Insert request with pending status and exam_id in remarks
    $sql = "INSERT INTO approval_requests_online (request_type, remarks, approval_status) VALUES (?, ?, 'pending')";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $request_type, $exam_id); // Use 'remarks' to store exam_id
    if ($stmt->execute()) {
        echo "<script>alert('Approval request sent to the teacher.'); window.location.href='student_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error sending request.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Exam Approval</title>
</head>
<body>
    <h1>Request Exam Approval</h1>

    <form action="request_approval.php" method="POST">
        <label for="exam_id">Select Exam:</label>
        <select name="exam_id" id="exam_id" required>
            <option value="" disabled selected>Select an exam</option>
            <?php
            // Check if there are any exams available
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['exam_id'] . "'>" . $row['subject'] . "</option>"; // Use 'subject' as the exam name
                }
            } else {
                echo "<option value='' disabled>No exams available</option>";
            }
            ?>
        </select><br><br>

        <button type="submit" name="request_approval">Request Approval</button>
    </form>
</body>
</html>

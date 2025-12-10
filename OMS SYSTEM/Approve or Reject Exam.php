<?php
require_once "../connection.php";
session_start();

// Check if the user is a teacher (not admin)
if ($_SESSION['role'] !== 'teacher') {
    die("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $approval_id = $_POST['approval_id'];
    $status = $_POST['status']; // 'approved' or 'rejected'
    $approved_by = $_SESSION['user_id'];

    // Update the approval status in the database
    $stmt = $con->prepare("UPDATE approval_requests_online SET approval_status=?, approved_by=?, approval_date=NOW() WHERE id=?");
    $stmt->bind_param("sii", $status, $approved_by, $approval_id);
    
    if ($stmt->execute()) {
        echo "Exam approval updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve or Reject Exam</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
</head>
<body>
    <h2>Approve or Reject Exam</h2>
    <form method="POST" action="approve_or_reject_exam.php">
        <div>
            <label for="approval_id">Approval ID:</label>
            <input type="number" id="approval_id" name="approval_id" required>
        </div>

        <div>
            <label for="status">Approval Status:</label>
            <select id="status" name="status" required>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
</body>
</html>

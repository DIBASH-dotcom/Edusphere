<?php
session_start();
require_once "../connection.php";

// Check if the action and request_id are set (for approving or declining)
if (isset($_GET['request_id']) && isset($_GET['action'])) {
    $request_id = $_GET['request_id'];
    $action = $_GET['action'];

    if ($action == 'approve') {
        $status = 'approved';
    } elseif ($action == 'decline') {
        $status = 'declined';
    } else {
        // Redirect if action is invalid
        header("Location: teacher_dashboard.php");
        exit();
    }

    // Update request status in the database
    $sql = "UPDATE approval_requests_online SET status = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $status, $request_id);

    if ($stmt->execute()) {
        echo "<script>alert('Request $status!'); window.location.href='teacher_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error updating request status.'); window.location.href='teacher_dashboard.php';</script>";
    }
    exit(); // Ensure no further code is executed after this
}

// Fetch all requests for display (if needed)
$sql = "SELECT * FROM approval_requests_online";
$result = $con->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Requests</title>
</head>
<body>
    <h1>Approval Requests</h1>

    <?php
    if ($result->num_rows > 0) {
        // Loop through the requests and display them
        while ($request = $result->fetch_assoc()) {
            echo "<div>";
            echo "Request ID: " . $request['id'] . "<br>";
            echo "Status: " . $request['status'] . "<br>";
            echo "<a href='approve_student.php?request_id=" . $request['id'] . "&action=approve'>Approve</a> | ";
            echo "<a href='approve_student.php?request_id=" . $request['id'] . "&action=decline'>Decline</a>";
            echo "</div><hr>";
        }
    } else {
        echo "No requests found.";
    }
    ?>
</body>
</html>

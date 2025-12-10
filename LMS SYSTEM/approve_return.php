<?php
include('../connection.php');

// Ensure the return_id is passed through GET method
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['return_id'])) {
        $return_id = $_GET['return_id'];

        // Check if the return request exists and is in pending status
        $check_query = $con->prepare("SELECT return_id FROM returned_books_lms_libarray WHERE return_id = ? AND approval_status = 'pending'");
        $check_query->bind_param("i", $return_id);
        $check_query->execute();
        $result = $check_query->get_result();

        // If the return request exists and is pending, approve it
        if ($result->num_rows > 0) {
            // Update the approval status to 'approved'
            $approve_query = $con->prepare("UPDATE returned_books_lms_libarray SET approval_status = 'approved' WHERE return_id = ?");
            $approve_query->bind_param("i", $return_id);

            // Execute the update query
            if ($approve_query->execute()) {
                echo "Return approved successfully!";
                echo "Affected rows: " . $approve_query->affected_rows;
            } else {
                echo "Error approving the return." . $approve_query->error;
            }
        } else {
            echo "Return request is either already approved or does not exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Return</title>
</head>
<body>
    <h1>Approve Return Request</h1>

    <form method="POST" action="approve_return.php">
        <label for="return_id">Return ID:</label>
        <input type="number" name="return_id" id="return_id" required><br><br>

        <button type="submit">Approve Return</button>
    </form>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>

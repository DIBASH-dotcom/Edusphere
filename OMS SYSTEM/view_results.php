<?php
session_start();
require_once "../connection.php";

$result = null; // Variable define गर्नुहोस्

if (isset($_GET['exam_id'])) {
    $exam_id = $_GET['exam_id'];
    
    // SQL Query
    $sql = "SELECT student_id, score
            FROM results_online r 
            JOIN students_online s ON r.student_id = s.id 
            JOIN users_online u ON s.user_id = u.id 
            WHERE r.exam_id = ?";
    
    $stmt = $con->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $exam_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
        } else {
            echo "❌ Query execution failed: " . $stmt->error;
        }
    } else {
        echo "❌ SQL Prepare failed: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Results</title>
</head>
<body>
    <h2>Exam Results</h2>
    
    <?php if ($result && $result->num_rows > 0) { ?>
        <table border="1">
            <tr>
                <th>Student Name</th>
                <th>Marks</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['marks']); ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No results found or query failed.</p>
    <?php } ?>
</body>
</html>

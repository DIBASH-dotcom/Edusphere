<?php
session_start();
require_once "../connection.php";

// Check if the user is logged in and is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    die("Access Denied! Only teachers can add questions.");
}

// Check if the exam ID is provided
if (!isset($_GET['exam_id']) || empty($_GET['exam_id'])) {
    die("Exam ID is missing.");
}

$exam_id = $_GET['exam_id']; // Get the exam ID from the URL

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the form
    $question = $_POST['question'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_answer = $_POST['correct_answer'];
    $note = $_POST['note'];

    // Insert the question into the database
    $sql = "INSERT INTO questions_online (exam_id, question, option_a, option_b, option_c, option_d, correct_answer, note)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the SQL statement
    $stmt = $con->prepare($sql);
    $stmt->bind_param("isssssss", $exam_id, $question, $option_a, $option_b, $option_c, $option_d, $correct_answer, $note);

    // Execute the query
    if ($stmt->execute()) {
        echo "Question added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
</head>
<body>
    <h2>Add Question for Exam ID: <?php echo htmlspecialchars($exam_id); ?></h2>
    
    <form method="POST">
        <label>Question:</label><br>
        <textarea name="question" required></textarea><br><br>

        <label>Option A:</label><br>
        <input type="text" name="option_a" required><br><br>

        <label>Option B:</label><br>
        <input type="text" name="option_b" required><br><br>

        <label>Option C:</label><br>
        <input type="text" name="option_c" required><br><br>

        <label>Option D:</label><br>
        <input type="text" name="option_d" required><br><br>

        <label>Correct Answer:</label><br>
        <input type="text" name="correct_answer" required><br><br>

        <label>Note:</label><br>
        <textarea name="note"></textarea><br><br>

        <button type="submit">Add Question</button>
    </form>

    <br><br>
    <a href="view_questions.php?exam_id=<?php echo htmlspecialchars($exam_id); ?>">Back to Questions</a>
</body>
</html>

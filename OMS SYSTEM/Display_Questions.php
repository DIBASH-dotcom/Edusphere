<?php
session_start();
require_once "../connection.php"; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access Denied! Please log in.");
}

$exam_id = $_GET['exam_id']; // Get the exam_id from the URL (pass the exam ID)
$role = $_SESSION['role']; // Get the user's role (teacher or student)
$user_id = $_SESSION['user_id']; // Get user ID

// Fetch questions for the given exam
$sql = "SELECT * FROM questions_online WHERE exam_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $exam_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Questions for Exam ID: $exam_id</h2>";

// If the user is a teacher, provide an option to add new questions
if ($role === 'teacher') {
    echo "<a href='add_question.php?exam_id=$exam_id'>Add New Question</a><br><br>";
}

// Display the questions for the exam
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<p><strong>Question: </strong>" . htmlspecialchars($row['question']) . "</p>";
        echo "<p><strong>Option A: </strong>" . htmlspecialchars($row['option_a']) . "</p>";
        echo "<p><strong>Option B: </strong>" . htmlspecialchars($row['option_b']) . "</p>";
        echo "<p><strong>Option C: </strong>" . htmlspecialchars($row['option_c']) . "</p>";
        echo "<p><strong>Option D: </strong>" . htmlspecialchars($row['option_d']) . "</p>";

        // Show the correct answer if the user is a teacher
        if ($role === 'teacher') {
            echo "<p><strong>Correct Answer: </strong>" . htmlspecialchars($row['correct_answer']) . "</p>";
        }

        // Display note if the user is a teacher
        if ($role === 'teacher') {
            echo "<p><strong>Note: </strong>" . htmlspecialchars($row['note']) . "</p>";
        }

        // Students cannot see the answer, but we can show a "Take Exam" button
        if ($role === 'student') {
            echo "<button>Start Exam</button>";
        }

        echo "</div><hr>";
    }
} else {
    echo "No questions found for this exam.";
}

$stmt->close();
$con->close();
?>

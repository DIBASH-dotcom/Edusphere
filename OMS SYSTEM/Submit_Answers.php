<?php
require_once "../connection.php";
session_start();

if ($_SESSION['role'] !== 'student') {
    die("Unauthorized access.");
}

$student_id = $_SESSION['user_id'];

// Ensure exam_id is set
$exam_id = isset($_SESSION['exam_id']) ? $_SESSION['exam_id'] : (isset($_POST['exam_id']) ? $_POST['exam_id'] : null);

if (empty($exam_id)) {
    die("Error: exam_id is missing!");
}

$exam_id = (int) $exam_id;  // Convert to integer

// Check if 'answer' exists in POST data
if (isset($_POST['answer']) && is_array($_POST['answer'])) {
    $answers = $_POST['answer'];
    $score = 0;
    $total_questions = count($answers);

    if ($total_questions > 0) {
        foreach ($answers as $question_id => $selected_option) {
            $result = $con->query("SELECT correct_answer FROM questions_online WHERE id = $question_id");
            $row = $result->fetch_assoc();

            if ($row && $row['correct_answer'] == $selected_option) {
                $score++;
            }
        }

        $status = ($score >= ($total_questions / 2)) ? 'Pass' : 'Fail';

        // Fetch subject from exams_online table
        $subject_query = $con->prepare("SELECT subject FROM exams_online WHERE exam_id = ?");
        $subject_query->bind_param("i", $exam_id);
        $subject_query->execute();
        $subject_result = $subject_query->get_result();
        $subject_row = $subject_result->fetch_assoc();
        $subject = $subject_row['subject'] ?? 'Unknown';

        // Insert result into the database
        $stmt = $con->prepare("INSERT INTO results_online (student_id, exam_id, subject, score, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisis", $student_id, $exam_id, $subject, $score, $status);
        $stmt->execute();

        echo "Exam submitted successfully! Your score: $score/$total_questions. Status: $status.";
    } else {
        echo "No answers were provided.";
    }
} else {
    echo "No answers submitted or invalid answer format.";
}
?>

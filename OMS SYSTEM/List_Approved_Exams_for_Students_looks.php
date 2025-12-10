<?php
require_once "../connection.php";
session_start();

if ($_SESSION['role'] !== 'student') {
    die("Unauthorized access.");
}

$student_id = $_SESSION['user_id'];
$exam_id = $_SESSION['exam_id'];
$answers = $_POST['answer'];
$score = 0;
$total_questions = count($answers);

// उत्तर जाँच्ने
foreach ($answers as $question_id => $selected_option) {
    $result = $con->query("SELECT correct_answer FROM questions_online WHERE id = $question_id");
    $row = $result->fetch_assoc();

    if ($row['correct_answer'] == $selected_option) {
        $score++;
    }
}

// पास वा फेल निर्धारण गर्ने
$status = ($score >= ($total_questions / 2)) ? 'Pass' : 'Fail';

// नतिजा डाटाबेसमा राख्ने
$stmt = $con->prepare("INSERT INTO results_online (student_id, exam_id, subject, score, status) VALUES (?, ?, (SELECT subject FROM exams_online WHERE exam_id = ?), ?, ?)");
$stmt->bind_param("iiisi", $student_id, $exam_id, $exam_id, $score, $status);
$stmt->execute();

echo "Exam submitted successfully! Your score: $score/$total_questions. Status: $status.";
?>

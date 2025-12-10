<?php
require_once "../connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exam_id = $_POST['exam_id'];
    $question_ids = $_POST['question_ids'];
    $answers = $_POST['answers'];
    $student_id = 1; // Replace with actual student ID (e.g., from session)

    $score = 0;
    foreach ($question_ids as $index => $question_id) {
        $student_answer = trim($answers[$index]);
        $sql = "SELECT correct_answer FROM exam_questions WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $question_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        $correct = ($student_answer === $row['correct_answer']);
        if ($correct) $score++;

        $sql_save = "INSERT INTO student_answers (exam_id, student_id, question_id, student_answer, is_correct)
                     VALUES (?, ?, ?, ?, ?)";
        $stmt_save = mysqli_prepare($con, $sql_save);
        mysqli_stmt_bind_param($stmt_save, "iiisi", $exam_id, $student_id, $question_id, $student_answer, $correct);
        mysqli_stmt_execute($stmt_save);
    }

    echo "Your score: $score / " . count($question_ids);
}
?>

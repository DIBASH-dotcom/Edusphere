<?php
require_once "../connection.php";
session_start();

if ($_SESSION['role'] !== 'student') {
    die("Unauthorized access.");
}

if (!isset($_GET['exam_id'])) {
    die("Invalid exam.");
}

$exam_id = $_GET['exam_id'];
$_SESSION['exam_id'] = $exam_id;

$questions = $con->query("SELECT * FROM questions_online WHERE exam_id = $exam_id");

if ($questions->num_rows > 0) {
    echo "<h3>You have only 10 seconds per question!</h3>";
    echo "<form id='examForm' action='submit_Answers.php' method='POST'>";
    
    $index = 0;
    while ($row = $questions->fetch_assoc()) {
        $question_id = $row['id'];
        echo "<div class='question' id='question-$index' style='" . ($index === 0 ? "" : "display:none;") . "'>";
        echo "<p><b>Question " . ($index + 1) . ":</b> " . $row['question'] . "</p>";
        echo "<input type='radio' name='answer[$question_id]' value='A'> " . $row['option_a'] . "<br>";
        echo "<input type='radio' name='answer[$question_id]' value='B'> " . $row['option_b'] . "<br>";
        echo "<input type='radio' name='answer[$question_id]' value='C'> " . $row['option_c'] . "<br>";
        echo "<input type='radio' name='answer[$question_id]' value='D'> " . $row['option_d'] . "<br><br>";
        echo "</div>";
        $index++;
    }

    echo "<input type='hidden' id='totalQuestions' value='$index'>";
    echo "<input type='submit' id='submitBtn' value='Submit Answer' style='display:none;'>";
    echo "</form>";
}
?>

<script>
    let currentQuestion = 0;
    const totalQuestions = document.getElementById('totalQuestions').value;
    let timer = 10;

    function showNextQuestion() {
        if (currentQuestion < totalQuestions - 1) {
            document.getElementById('question-' + currentQuestion).style.display = "none";
            currentQuestion++;
            document.getElementById('question-' + currentQuestion).style.display = "block";
            timer = 10;
        } else {
            document.getElementById('examForm').submit();
        }
    }

    function updateTimer() {
        if (timer > 0) {
            document.getElementById('timer').innerText = "Time Left: " + timer + " sec";
            timer--;
        } else {
            showNextQuestion();
        }
    }

    document.body.insertAdjacentHTML('afterbegin', "<h3 id='timer'>Time Left: 10 sec</h3>");
    setInterval(updateTimer, 1000);
</script>

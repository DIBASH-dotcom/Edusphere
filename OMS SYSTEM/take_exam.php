<?php
session_start();
require_once "../connection.php";

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    echo "<script>alert('Unauthorized access!'); window.location.href='login.php';</script>";
    exit();
}

// Validate the exam_id from URL
if (!isset($_GET['exam_id']) || !is_numeric($_GET['exam_id'])) {
    echo "<script>alert('Invalid Exam!'); window.location.href='student_dashboard.php';</script>";
    exit();
}

$exam_id = intval($_GET['exam_id']); // Ensure it is an integer

// Use prepared statements to fetch exam details
$stmt = $con->prepare("SELECT * FROM exams_online WHERE exam_id = ?");
$stmt->bind_param("i", $exam_id);
$stmt->execute();
$exam = $stmt->get_result()->fetch_assoc();
if (!$exam) {
    echo "<script>alert('Exam not found!'); window.location.href='student_dashboard.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Exam - <?= htmlspecialchars($exam['subject']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .question {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .options {
            margin-bottom: 20px;
        }
        .options label {
            display: block;
            padding: 5px;
            background: #e8e8e8;
            margin: 5px 0;
            border-radius: 5px;
            cursor: pointer;
        }
        .options input {
            margin-right: 10px;
        }
        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?= htmlspecialchars($exam['subject']) ?> Exam</h2>
        <form method="POST" action="submit_Answers.php">
            <input type="hidden" name="exam_id" value="<?= htmlspecialchars($exam_id) ?>">

            <?php
            // Fetch questions using prepared statements
            $stmt = $con->prepare("SELECT * FROM questions_online WHERE exam_id = ?");
            $stmt->bind_param("i", $exam_id);
            $stmt->execute();
            $questions = $stmt->get_result();
            
            // Display questions and options
            while ($q = $questions->fetch_assoc()) {
                echo "<div class='question'><strong>" . htmlspecialchars($q['question']) . "</strong></div>";
                echo "<div class='options'>";
                echo "<label><input type='radio' name='q" . $q['id'] . "' value='A' required> " . htmlspecialchars($q['option_a']) . "</label>";
                echo "<label><input type='radio' name='q" . $q['id'] . "' value='B'> " . htmlspecialchars($q['option_b']) . "</label>";
                echo "<label><input type='radio' name='q" . $q['id'] . "' value='C'> " . htmlspecialchars($q['option_c']) . "</label>";
                echo "<label><input type='radio' name='q" . $q['id'] . "' value='D'> " . htmlspecialchars($q['option_d']) . "</label>";
                echo "</div>";
            }
            ?>
            
            <input type="submit" value="Submit Answer">
        </form>
    </div>
</body>
</html>

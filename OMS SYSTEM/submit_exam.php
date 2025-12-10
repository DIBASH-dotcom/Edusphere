<?php
session_start();
require_once "../connection.php";

// Check if the exam_id is passed in the URL
if (isset($_GET['exam_id']) && !empty($_GET['exam_id'])) {
    $exam_id = $_GET['exam_id'];
} else {
    // If exam_id is not set, you can redirect or handle the error
    die("Exam ID is not provided.");
}

// Fetch exam questions based on the exam_id
$questions = $con->query("SELECT * FROM questions_online WHERE exam_id = '$exam_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Submission</title>
</head>
<body>
    <h1>Exam Questions</h1>
    <form action="submit_exam.php" method="POST">
        <input type="hidden" name="exam_id" value="<?php echo htmlspecialchars($exam_id); ?>">

        <?php while ($q = $questions->fetch_assoc()): ?>
            <div>
                <p><?php echo htmlspecialchars($q['question_text']); ?></p>
                <label>
                    <input type="radio" name="q<?php echo $q['id']; ?>" value="A"> <?php echo htmlspecialchars($q['option_a']); ?>
                </label><br>
                <label>
                    <input type="radio" name="q<?php echo $q['id']; ?>" value="B"> <?php echo htmlspecialchars($q['option_b']); ?>
                </label><br>
                <label>
                    <input type="radio" name="q<?php echo $q['id']; ?>" value="C"> <?php echo htmlspecialchars($q['option_c']); ?>
                </label><br>
                <label>
                    <input type="radio" name="q<?php echo $q['id']; ?>" value="D"> <?php echo htmlspecialchars($q['option_d']); ?>
                </label><br>
            </div>
        <?php endwhile; ?>

        <button type="submit">Submit Exam</button>
    </form>
</body>
</html>

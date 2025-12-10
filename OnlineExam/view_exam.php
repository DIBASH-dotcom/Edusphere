<?php
require_once "../connection.php";

if (isset($_GET['exam_id'])) {
    $exam_id = $_GET['exam_id'];

    // Fetch exam details
    $sql_exam = "SELECT * FROM create_exam WHERE id = ?";
    $stmt_exam = mysqli_prepare($con, $sql_exam);
    mysqli_stmt_bind_param($stmt_exam, "i", $exam_id);
    mysqli_stmt_execute($stmt_exam);
    $result_exam = mysqli_stmt_get_result($stmt_exam);
    $exam = mysqli_fetch_assoc($result_exam);

    // Fetch related questions
    $sql_questions = "SELECT * FROM exam_questions WHERE exam_id = ?";
    $stmt_questions = mysqli_prepare($con, $sql_questions);
    mysqli_stmt_bind_param($stmt_questions, "i", $exam_id);
    mysqli_stmt_execute($stmt_questions);
    $result_questions = mysqli_stmt_get_result($stmt_questions);
} else {
    echo "Invalid exam ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        main {
            padding: 1.5rem;
        }

        .exam-section {
            background: white;
            padding: 1.5rem;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin: 0.5rem 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Exam Details</h1>
    </header>
    <main>
        <section class="exam-section">
            <h2><?php echo htmlspecialchars($exam['title']); ?></h2>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($exam['description']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($exam['date']); ?></p>

            <h3>Questions:</h3>
            <ul>
                <?php while ($question = $result_questions->fetch_assoc()): ?>
                <li><?php echo htmlspecialchars($question['question']); ?></li>
                <?php endwhile; ?>
            </ul>
        </section>
    </main>
</body>
</html>
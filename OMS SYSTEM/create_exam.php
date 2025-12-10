<?php
// PHP code remains unchanged
session_start();
require_once "../connection.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    die("Access Denied! Only teachers can create exams.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_exam'])) {
    $subject = $_POST['subject'];
    $department = $_POST['department'];
    $year_part = $_POST['year_part'];
    $exam_date = $_POST['exam_date'];
    $teacher_id = $_SESSION['user_id'];

    $sql = "INSERT INTO exams_online (subject, teacher_id, department, year_part, exam_date) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sisss", $subject, $teacher_id, $department, $year_part, $exam_date);

    if ($stmt->execute()) {
        $exam_id = $stmt->insert_id;
        $success_message = "Exam created successfully! Now you can add questions.";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_question'])) {
    $exam_id = $_POST['exam_id'];
    $question = $_POST['question'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_answer = $_POST['correct_answer'];
    $note = $_POST['note'];

    $sql = "INSERT INTO questions_online (exam_id, question, option_a, option_b, option_c, option_d, correct_answer, note) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("isssssss", $exam_id, $question, $option_a, $option_b, $option_c, $option_d, $correct_answer, $note);

    if ($stmt->execute()) {
        $success_message = "Question added successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exam - Edusphere</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f39c12;
            --background-color: #f4f7f9;
            --text-color: #333;
            --card-bg: #ffffff;
            --hover-color: #3498db;
            --error-color: #e74c3c;
            --success-color: #2ecc71;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: var(--card-bg);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        form {
            display: grid;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="datetime-local"],
        textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: inherit;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: var(--hover-color);
        }

        .message {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .success {
            background-color: var(--success-color);
            color: white;
        }

        .error {
            background-color: var(--error-color);
            color: white;
        }

        .options-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .options-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create an Exam</h1>
        
        <?php if (isset($success_message)): ?>
            <div class="message success">
                <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="message error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="subject"><i class="fas fa-book"></i> Subject:</label>
                <input type="text" id="subject" name="subject" required>
            </div>

            <div class="form-group">
                <label for="department"><i class="fas fa-building"></i> Department:</label>
                <input type="text" id="department" name="department" required>
            </div>

            <div class="form-group">
                <label for="year_part"><i class="fas fa-calendar-alt"></i> Year/Part:</label>
                <input type="text" id="year_part" name="year_part" required>
            </div>

            <div class="form-group">
                <label for="exam_date"><i class="fas fa-clock"></i> Exam Date:</label>
                <input type="datetime-local" id="exam_date" name="exam_date" required>
            </div>

            <button type="submit" name="create_exam"><i class="fas fa-plus-circle"></i> Create Exam</button>
        </form>

        <?php if (isset($exam_id)): ?>
            <h2>Add Questions</h2>
            <form method="post">
                <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">

                <div class="form-group">
                    <label for="question"><i class="fas fa-question-circle"></i> Question:</label>
                    <textarea id="question" name="question" required></textarea>
                </div>

                <div class="options-grid">
                    <div class="form-group">
                        <label for="option_a"><i class="fas fa-check-circle"></i> Option A:</label>
                        <input type="text" id="option_a" name="option_a" required>
                    </div>
                    <div class="form-group">
                        <label for="option_b"><i class="fas fa-check-circle"></i> Option B:</label>
                        <input type="text" id="option_b" name="option_b" required>
                    </div>
                    <div class="form-group">
                        <label for="option_c"><i class="fas fa-check-circle"></i> Option C:</label>
                        <input type="text" id="option_c" name="option_c" required>
                    </div>
                    <div class="form-group">
                        <label for="option_d"><i class="fas fa-check-circle"></i> Option D:</label>
                        <input type="text" id="option_d" name="option_d" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="correct_answer"><i class="fas fa-star"></i> Correct Answer (a, b, c, or d):</label>
                    <input type="text" id="correct_answer" name="correct_answer" required>
                </div>

                <div class="form-group">
                    <label for="note"><i class="fas fa-sticky-note"></i> Note:</label>
                    <textarea id="note" name="note"></textarea>
                </div>

                <button type="submit" name="add_question"><i class="fas fa-plus"></i> Add Question</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>


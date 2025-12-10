<?php
if(isset($_POST["submit"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $date= $_POST["date"];
    $questions= $_POST["questions"];
   

    $errors = array();

    if(empty($title) || empty($description) || empty($date) || empty($questions)) {
        array_push($errors, "All fields are required.");
    }
    
   

    require_once "../connection.php";

    // Check if email is already registered
    $sql = "SELECT * FROM create_exam WHERE title = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $title);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        array_push($errors, "title is already registered.");
    }

    if(count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        // Insert the data of exam
        $sql = "INSERT INTO create_exam (title, description, date) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $title, $description, $date);
        if(mysqli_stmt_execute($stmt)) {
            $exam_id = mysqli_insert_id($con);  // Get the ID of the newly inserted exam

    // Insert questions related to the exam
    $questions_array = explode("\n", $questions);  // Assuming each question is separated by a new line
    

    foreach ($questions_array as $question) {
     
        $question = trim($question);
          
        if (!empty($question)) {
            $sql_question = "INSERT INTO exam_questions (exam_id, question) VALUES (?, ?)";
            $stmt_question = mysqli_prepare($con, $sql_question);
            mysqli_stmt_bind_param($stmt_question, "is", $exam_id, $question);
            mysqli_stmt_execute($stmt_question);
        }
    }
            echo "<div class='success'>Successfully registered. Proceed to login.</div>";
        } else {
            echo "<div class='error'>Something went wrong.</div>";
        }
    }
}

require_once "../connection.php";
$sql = "SELECT * FROM create_exam";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Create Exam</title>
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

        .form-section, .list-section {
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin: 0.5rem 0 0.2rem;
        }

        form input, form textarea, form button {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 0.8rem;
            text-align: left;
        }

        table th {
            background-color: #f8f9fa;
        }

        .delete-btn {
            color: white;
            background-color: #dc3545;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <header>
        <h1>Teacher Dashboard - Manage Exams</h1>
    </header>
    <main>
        <!-- Form to Create Exam -->
        <section class="form-section">
            <h2>Create Exam</h2>
            <form id="createexamForm" action="create_exam.php" method="POST">
                <label for="title">Exam Title:</label>
                <input type="title" id="title" name="title" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>

                <label for="date">Exam Date:</label>
                <input type="date" id="date" name="date" required>
   
                <label for="questions">Questions (one per line):</label>
                <textarea id="questions" name="questions" rows="6" required></textarea>
     


                <label for="questions">Questions (format: question|correct answer):</label>
<textarea id="questions" name="questions" rows="6" required></textarea>

                <button type="submit" name="submit">Create Exam</button>
            </form>
        </section>

        <!-- List of Exams -->
        <section class="list-section">
            <h2>Exam List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td>
                            <a href="exam_create.php?delete=<?php echo $row['id']; ?>" class="delete-btn">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>

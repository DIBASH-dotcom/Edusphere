<?php
// Include the database connection file
require_once "../connection.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form values
    $course_name = $_POST['course_name'];
    $teacher_id = $_POST['teacher_id'];
    $department = $_POST['department'];
    $year_part = $_POST['year_part'];
    
    // Check if the teacher_id exists in the users_online table
    $check_teacher_sql = "SELECT id FROM users_online WHERE id = ?";
    if ($stmt_check = $con->prepare($check_teacher_sql)) {
        $stmt_check->bind_param('i', $teacher_id);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows == 0) {
            // Teacher ID does not exist, show an error message
            echo "Error: Teacher ID does not exist.";
            exit;
        }

        // Close the check statement
        $stmt_check->close();
    }

    // Handle file upload for course image
    $course_image = NULL;
    if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] == 0) {
        $image_name = $_FILES['course_image']['name'];
        $image_tmp_name = $_FILES['course_image']['tmp_name'];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        
        // Set a unique file name
        $course_image = 'uploads/' . uniqid() . '.' . $image_extension;
        
        // Move the uploaded file to the desired location
        move_uploaded_file($image_tmp_name, $course_image);
    }

    // Prepare the SQL query to insert data into the table
    $sql = "INSERT INTO courses_online (course_name, teacher_id, department, year_part, course_image) 
            VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $con->prepare($sql)) {
        // Bind parameters and execute the query
        $stmt->bind_param('sisss', $course_name, $teacher_id, $department, $year_part, $course_image);
        
        if ($stmt->execute()) {
            echo "Course added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $con->error;
    }
}

// Close the database connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-size: 16px;
            color: #555;
        }

        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Course</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="course_name">Course Name:</label>
                <input type="text" id="course_name" name="course_name" required>
            </div>

            <div class="form-group">
                <label for="teacher_id">Teacher ID:</label>
                <input type="number" id="teacher_id" name="teacher_id" required>
            </div>

            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" required>
            </div>

            <div class="form-group">
                <label for="year_part">Year/Part:</label>
                <input type="text" id="year_part" name="year_part" required>
            </div>

            <div class="form-group">
                <label for="course_image">Course Image:</label>
                <input type="file" id="course_image" name="course_image">
            </div>

            <input type="submit" value="Add Course">
        </form>
    </div>
</body>
</html>

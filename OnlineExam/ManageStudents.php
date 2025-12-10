<?php
require_once "../connection.php";

// Handle Add Student Form Submission
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $roll_number = $_POST['roll_number'];
    $email = $_POST['email'];

    $errors = array();
    if (empty($name) || empty($roll_number) || empty($email)) {
        array_push($errors, "All fields are required.");
    }

    // Check if roll number already exists
    $sql = "SELECT * FROM managestudents WHERE roll_number = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $roll_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        array_push($errors, "Student with this roll number already exists.");
    }

    if (count($errors) == 0) {
        $sql = "INSERT INTO managestudents (name, roll_number, email) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $name, $roll_number, $email);
        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='success'>Student added successfully!</div>";
        } else {
            echo "<div class='error'>Something went wrong.</div>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}

// Handle Delete Student Request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM managestudents WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        echo "<div class='success'>Student deleted successfully!</div>";
    } else {
        echo "<div class='error'>Failed to delete the student.</div>";
    }
}

// Fetch All Students
$sql = "SELECT * FROM managestudents";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> - Manage Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #28a745;
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

        form input, form button {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #218838;
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
        <h1> Manage Students</h1>
    </header>
    <main>
        <!-- Form to Add Students -->
        <section class="form-section">
            <h2>Add Student</h2>
            <form action="ManageStudents.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="roll_number">Roll Number:</label>
                <input type="text" id="roll_number" name="roll_number" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <button type="submit" name="submit">Add Student</button>
            </form>
        </section>

        <!-- List of Students -->
        <section class="list-section">
            <h2>Student List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Roll Number</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['roll_number']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="ManageStudents.php?delete=<?php echo $row['id']; ?>" class="delete-btn">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>

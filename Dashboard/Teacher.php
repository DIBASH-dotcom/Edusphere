<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .dashboard-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 1rem 0 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 1rem;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        main {
            flex: 1;
            padding: 1rem;
        }

        section {
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        section h2 {
            margin-top: 0;
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

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #007bff;
            color: white;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Teacher Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="#overview">Overview</a></li>
                    <li><a href="../OnlineExam/create_exam.php">Create Exam</a></li>
                    <li><a href="../OnlineExam/ManageStudents.php">Manage Students</a></li>
                    <li><a href="../OnlineExam/Results provided by teacher for student.php">Results</a></li>
                    <li><a href="#logout">Logout</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <section id="overview">
                <h2>Overview</h2>
                <p>Welcome to the Teacher Dashboard! Here, you can manage exams, view student performance, and more.</p>
            </section>

            <section id="create-exam">
                <h2>Create Exam</h2>
                <form action="create_exam.php" method="POST">
                    <label for="exam-title">Exam Title:</label>
                    <input type="text" id="exam-title" name="exam_title" required>

                    <label for="exam-description">Description:</label>
                    <textarea id="exam-description" name="exam_description" required></textarea>

                    <label for="exam-date">Exam Date:</label>
                    <input type="date" id="exam-date" name="exam_date" required>

                    <button type="submit" name="submit">Create Exam</button>
                </form>
            </section>

            <section id="manage-students">
                <h2>Manage Students</h2>
                <p>List of enrolled students:</p>
                <ul>
                    <!-- Example student list -->
                    <li>Student 1 <button>Remove</button></li>
                    <li>Student 2 <button>Remove</button></li>
                    <li>Student 3 <button>Remove</button></li>
                </ul>
            </section>

            <section id="results">
                <h2>Exam Results</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Exam Title</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example results -->
                        <tr>
                            <td>Student 1</td>
                            <td>Math Test</td>
                            <td>85%</td>
                        </tr>
                        <tr>
                            <td>Student 2</td>
                            <td>Science Test</td>
                            <td>92%</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
        <footer>
            <p>&copy; 2025 Online Exam System</p>
        </footer>
    </div>
</body>
</html>

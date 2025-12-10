<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .dashboard-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 2px solid #ddd;
        }

        header h1 {
            margin: 0;
            color: #333;
        }

        header p {
            color: #555;
        }

        .student-info, .features {
            margin: 20px 0;
        }

        h2 {
            color: #333;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin: 5px 0;
            color: #555;
        }

        .feature-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .feature-box {
            flex: 1;
            min-width: 200px;
            background: #f1f1f1;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .feature-box h3 {
            color: #333;
            margin: 0;
        }

        .feature-box p {
            color: #555;
        }

        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Student Dashboard</h1>
            <p>Welcome, Ram Bahadur!</p>
        </header>
        
        <section class="student-info">
            <h2>Student Information</h2>
            <ul>
                <li><strong>Name:</strong> Ram Bahadur</li>
                <li><strong>ID:</strong> 2025001</li>
                <li><strong>Course:</strong> BSc. Computer Science</li>
            </ul>
        </section>
        
        <section class="features">
            <h2>Dashboard Features</h2>
            <div class="feature-grid">
                <div class="feature-box">
                    <h3>Exam Details</h3>
                    <p>View and manage your upcoming exams.</p>
                    <a href="../OnlineExam/AvailableExams.php" class="btn">Go to Exams</a>
                </div>
                <div class="feature-box">
                    <h3>Grades</h3>
                    <p>Check your academic performance.</p>
                    <a href="grades.html" class="btn">View Grades</a>
                </div>
                <div class="feature-box">
                    <h3>Library</h3>
                    <p>Access library resources and materials.</p>
                    <a href="library.html" class="btn">Visit Library</a>
                </div>
            </div>
        </section>

        <footer>
            <p>&copy; 2025 Student Dashboard. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>

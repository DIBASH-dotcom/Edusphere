<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Notes</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your custom styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .notes-list {
            margin-top: 20px;
        }

        .note-item {
            padding: 10px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .note-item h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .download-btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .download-btn:hover {
            background-color: #45a049;
        }

        hr {
            border: 0;
            border-top: 1px solid #eee;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            font-size: 16px;
        }

        .back-link a {
            text-decoration: none;
            color: #4CAF50;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Available Notes</h1>
        <div class="notes-list">
            <?php
                include('../connection.php'); 
                session_start();

                // Fetch notes from the database
                $query = "SELECT * FROM notes_lms";
                $result = mysqli_query($con, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='note-item'>";
                        echo "<h3>" . htmlspecialchars($row['note_title']) . "</h3>";
                        echo "<a href='" . htmlspecialchars($row['file_path']) . "' download class='download-btn'>Download Note</a>";
                        echo "</div><hr>";
                    }
                } else {
                    echo "<p>No notes available.</p>";
                }
            ?>
        </div>

        <!-- Back link to the dashboard or other page -->
        <div class="back-link">
            <a href="dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>

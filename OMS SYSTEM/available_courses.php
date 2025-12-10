<?php
require_once "../connection.php";

$sql = "SELECT course_id, course_name, teacher_id, department, year_part, course_image FROM courses_online";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Courses - Edusphere</title>
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
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 2rem;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .course-card {
            background-color: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .course-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .course-info {
            padding: 1.5rem;
        }

        .course-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .course-details {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .download-btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .download-btn:hover {
            background-color: var(--hover-color);
        }

        .no-image {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            background-color: #e0e0e0;
            color: #666;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .courses-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="container">
    <li><a href="../OMS SYSTEM/student_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <h1>Available Courses</h1>
        <div class="courses-grid">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="course-card">
                    <?php if (!empty($row['course_image'])) { ?>
                        <img src="../<?php echo htmlspecialchars($row['course_image']); ?>" alt="<?php echo htmlspecialchars($row['course_name']); ?>" class="course-image">
                    <?php } else { ?>
                        <div class="no-image">No Image Available</div>
                    <?php } ?>
                    <div class="course-info">
                        <h2 class="course-name"><?php echo htmlspecialchars($row['course_name']); ?></h2>
                        <div class="course-details">
                            <p><i class="fas fa-user"></i> Teacher ID: <?php echo htmlspecialchars($row['teacher_id']); ?></p>
                            <p><i class="fas fa-building"></i> Department: <?php echo htmlspecialchars($row['department']); ?></p>
                            <p><i class="fas fa-calendar-alt"></i> Year/Part: <?php echo htmlspecialchars($row['year_part']); ?></p>
                        </div>
                        <?php if (!empty($row['course_image'])) { ?>
                            <a href="../<?php echo htmlspecialchars($row['course_image']); ?>" download class="download-btn">
                                <i class="fas fa-download"></i> Download Image
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>


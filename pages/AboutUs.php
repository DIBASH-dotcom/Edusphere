<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Edusphere</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --text-color: #ecf0f1;
            --bg-color: #34495e;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .navbar {
            background-color: rgba(44, 62, 80, 0.8);
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar ul {
            display: flex;
            justify-content: flex-end;
            list-style: none;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            border-radius: 5px;
        }

        .navbar a:hover {
            background-color: var(--primary-color);
        }

        .hello {
            text-align: center;
            padding: 4rem 0;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hello h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
        }

        .hello h1 a {
            text-decoration: none;
            color: var(--text-color);
            background-color: var(--accent-color);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .hello h1 a:hover {
            background-color: #c0392b;
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .hello p {
            font-size: 1.2rem;
            margin: 1.5rem 0;
        }

        .contributors {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .contributor {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .contributor:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .contributor img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 3px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .contributor:hover img {
            transform: scale(1.1);
        }

        .contributor h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .contributor p {
            font-size: 0.9rem;
            color: var(--primary-color);
        }

        .footer {
            background-color: var(--secondary-color);
            color: var(--text-color);
            text-align: center;
            padding: 1rem;
            position: relative;
            width: 100%;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .hello h1 {
                font-size: 2rem;
            }

            .contributors {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .navbar ul {
                flex-direction: column;
                align-items: center;
            }

            .navbar li {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul>
            
            <li><a href="../pages/HomePage.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="../Authentication/AuthenticationService.php"><i class="fas fa-user-lock"></i> Authentication</a></li>
            <li><a href="../OMS SYSTEM/OMS DEMO.php"><i class="fas fa-pencil-alt"></i> Exam</a></li>
            <li><a href="../LMS SYSTEM/libararyservice.php"><i class="fas fa-book"></i> Library</a></li>
            <li><a href="../CHAT/ChatService.php"><i class="fas fa-comments"></i> Chat</a></li>
            <li><a href="./AboutUs.php"><i class="fas fa-info-circle"></i> About</a></li>
            <li><a href="../web.php"><i class="fas fa-fax"></i> FAQ</a></li>
            
        </ul>
    </nav>
    <div class="container">
        <div class="hello">
            <h1>THANKS FOR USING US! <a href="../Message.php">Share Suggestions</a></h1>
            <p>This website is developed for student and teacher purposes.</p>
            <h2>Meet Our Amazing Contributors</h2>
            <div class="contributors">
                <?php
                $contributors = [
                    ['name' => 'Ram Babu Sah', 'role' => 'DESIGNER', 'image' => '../images/rambabu.jpg'],
                    ['name' => 'Zbacchh Kumar Ram', 'role' => 'FULL STACK DEVELOPMENT', 'image' => '../images/pramesh.jpg'],
                    ['name' => 'Sussan Gyawali', 'role' => 'DATABASE MANAGER', 'image' => '../images/susan.jpeg'],
                    ['name' => 'Rachana Karki', 'role' => 'DESIGNER', 'image' => '../images/rachana.jpg'],
                    ['name' => 'Dilip Khattri', 'role' => 'FULL STACK DEVELOPER', 'image' => '../images/dilip.jpg'],
                    ['name' => 'Dibash Magar', 'role' => 'FRONT END DEVELOPER', 'image' => '../images/dibash.jpeg'],
                ];

                foreach ($contributors as $contributor) {
                    echo "<div class='contributor'>";
                    echo "<img src='{$contributor['image']}' alt='{$contributor['name']}'>";
                    echo "<h3>{$contributor['name']}</h3>";
                    echo "<p>{$contributor['role']}</p>";
                    echo "</div>";
                }
                ?>
            </div>
            <p>Thanks for your valuable time!</p>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2025 Edusphere. All rights reserved.</p>
    </footer>

    <script>
        document.querySelectorAll('.contributor').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);
            });
        });

        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>


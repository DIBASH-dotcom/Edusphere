<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSPHERE</title>
    <style>
        :root {
            --primary-color: #004d99;
            --secondary-color: #0077cc;
            --background-color: #f4f4f4;
            --text-color: #333;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--background-color);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 60px;
            height: 60px;
            margin-right: 1rem;
            border-radius: 50%;
        }

        .logo h1 {
            font-size: 1.5rem;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-left: 1.5rem;
        }

        nav ul li a {
            color: var(--white);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #99ccff;
        }

        .hero {
            background-color: var(--secondary-color);
            color: var(--white);
            text-align: center;
            padding: 4rem 0;
        }

        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .services {
            padding: 4rem 0;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .service-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: var(--secondary-color);
        }

        .about, .contact {
            padding: 4rem 0;
            text-align: center;
        }

        .about {
            background-color: #e4e4e4;
        }

        .contact form {
            max-width: 500px;
            margin: 0 auto;
        }

        .contact input,
        .contact textarea {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        footer {
            background-color: #333;
            color: var(--white);
            text-align: center;
            padding: 1rem 0;
        }

        footer a {
            color: #99ccff;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }

            nav ul {
                margin-top: 1rem;
            }

            nav ul li {
                margin: 0 0.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">
                <img src="../images/logo2.png" alt="EDUSPHERE Logo">
                <h1>EDUSPHERE</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="../AdminDashboard/admin.php">Admin</a></li>
                    <li><a href="../pages/Login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h2>Welcome to EDUSPHERE</h2>
            <p>Your one-stop solution for educational services</p>
        </div>
    </section>

    <section class="services">
        <div class="container">
            <div class="services-grid">
                <?php
                $services = [
                    [
                        "title" => "E-Library",
                        "description" => "Access a wide range of books, research papers, and educational resources anytime, anywhere."
                    ],
                    [
                        "title" => "Online Exam",
                        "description" => "Prepare and practice with online exams designed to enhance your learning experience."
                    ],
                    [
                        "title" => "Authentication Services",
                        "description" => "Secure login and personalized experience for all users."
                    ]
                ];

                foreach ($services as $service) {
                    echo "<div class='service-card'>";
                    echo "<h3>{$service['title']}</h3>";
                    echo "<p>{$service['description']}</p>";
                    echo "<a href='./Login.php' class='btn'>View</a>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </section>

    <section class="about">
        <div class="container">
            <h2>About Us</h2>
            <p>At EDUSPHERE, we are committed to revolutionizing education by providing an online platform that connects students with learning resources, assessments, and much more. Our goal is to empower students and educators alike by offering a seamless and effective online learning environment.</p>
        </div>
    </section>

    <section class="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <form action="ContactServlet" method="POST">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" rows="4" required></textarea>
                <button type="submit" class="btn">Send Message</button>
            </form>
        </div>
    </section>

    <footer>
        <div class="container">
           <!-- <p>Contact us at <a href="mailto:dekstop5555@gmail.com">dekstop5555@gmail.com</a></p> -->
        </div>
    </footer>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edusphere - Your Ultimate Educational Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --text-color: #333;
            --bg-color: #ecf0f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: var(--bg-color);
            line-height: 1.6;
        }

        .header {
            background: var(--secondary-color);
            padding: 1rem 5%;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .header.scrolled {
            padding: 0.5rem 5%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
            width: 40px;
            height: 40px;
            margin-right: 10px;
            transition: transform 0.3s ease;
        }

        .logo:hover img {
            transform: rotate(360deg);
        }

        .logo h1 {
            color: #fff;
            font-size: 1.5rem;
        }

        .navbar ul {
            display: flex;
            list-style: none;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .navbar a:hover {
            background: var(--primary-color);
            border-radius: 5px;
        }

        .hero {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            text-align: center;
            padding: 8rem 5% 5rem;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease 0.2s;
            animation-fill-mode: both;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: var(--accent-color);
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease 0.4s;
            animation-fill-mode: both;
        }

        .btn:hover {
            background: #c0392b;
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .services {
            padding: 5rem 5%;
            text-align: center;
        }

        .services h3 {
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .service-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .service {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .service:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .service i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .service h4 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .service p {
            margin-bottom: 1rem;
        }

        .service button {
            background: var(--primary-color);
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .service button:hover {
            background: var(--secondary-color);
        }

        .about {
            background: #fff;
            padding: 5rem 5%;
            text-align: center;
        }

        .about h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .footer {
            background: var(--secondary-color);
            color: #fff;
            text-align: center;
            padding: 2rem 5%;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
            }

            .navbar {
                margin-top: 1rem;
            }

            .navbar ul {
                flex-direction: column;
                align-items: center;
            }

            .navbar a {
                padding: 0.5rem;
            }

            .hero {
                padding: 6rem 5% 3rem;
            }
        }
    </style>
</head>
<body>
    <header class="header" id="header">
        <div class="header-content">
            <div class="logo">
                <img src="../images/logo2.png" alt="Edusphere Logo">
                <h1>Edusphere</h1>
            </div>
            <nav class="navbar">
                <ul>
                    <li><a href="../Authentication/AuthenticationService.php"><i class="fas fa-user-lock"></i> Authentication</a></li>
                    <li><a href="../OMS SYSTEM/OMS DEMO.php"><i class="fas fa-pencil-alt"></i> Exam</a></li>
                    <li><a href="../LMS SYSTEM/libararyservice.php"><i class="fas fa-book"></i> Library</a></li>
                    <li><a href="../CHAT/ChatService.php"><i class="fas fa-comments"></i> Chat</a></li>
                    <li><a href="./AboutUs.php"><i class="fas fa-info-circle"></i> About</a></li>
                    <li><a href="../web.php"><i class="fas fa-fax"></i> FAQ</a></li>
                    <li><a href="../pages/logout.php"><i class="fas fa-sign-out-alt"></i> LogOut</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <h2>Welcome to Edusphere,</h2>
            <p>Your ultimate platform for education, exams, and insights.</p>
            <a href="#services" class="btn">Explore Services</a>
        </section>

        <section id="services" class="services">
            <h3>Our Services</h3>
            <div class="service-container">
                <div class="service">
                    <i class="fas fa-user-shield"></i>
                    <h4>Authentication Service</h4>
                    <p>Secure login and signup functionality.</p>
                    <button><a href="../Authentication/AuthenticationService.php">View</a></button>
                </div>
                <div class="service">
                    <i class="fas fa-tasks"></i>
                    <h4>Exam Service</h4>
                    <p>Online examination platform for seamless assessments.</p>
                    <button><a href="../OMS SYSTEM/OMS DEMO.php">View</a></button>
                </div>
                <div class="service">
                    <i class="fas fa-book-reader"></i>
                    <h4>Library Service</h4>
                    <p>Access digital resources and e-books easily.</p>
                    <button><a href="../Libarary/LibraryService.php">View</a></button>
                </div>
                <div class="service">
                    <i class="fas fa-comments"></i>
                    <h4>Chat Service</h4>
                    <p>Connect and collaborate with peers and mentors.</p>
                    <button><a href="../Chat/ChatService.php">View</a></button>
                </div>
                <div class="service">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <h4>LMS Service</h4>
                    <p>Learning Management System to organize courses.</p>
                    <button><a href="../LMS SYSTEM/libararyservice.php">View</a></button>
                </div>
                <div class="service">
                    <i class="fas fa-brain"></i>
                    <h4>AI Insights Service</h4>
                    <p>Get personalized recommendations and insights.</p>
                    <button><a href="./ChatService.php">View</a></button>
                </div>
            </div>
        </section>

        <section id="about" class="about">
            <h3>About Us</h3>
            <p>Edusphere is designed to transform the way you learn, access resources, and excel in your educational journey.</p>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Edusphere. All rights reserved.</p>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

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


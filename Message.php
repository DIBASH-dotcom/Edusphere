<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Edusphere</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --text-color: #333;
            --bg-color: #f4f4f4;
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
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .navbar {
            background-color: var(--secondary-color);
            padding: 1rem 0;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
            margin-left: 10px;
            
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
            background-color: var(--primary-color);
            border-radius: 5px;
        }

        #contact {
            background-color: #fff;
            padding: 4rem 0;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        #contact h2 {
            text-align: center;
            color: var(--secondary-color);
            margin-bottom: 2rem;
            font-size: 2.5rem;
        }

        #contact form {
            max-width: 600px;
            margin: 0 auto;
        }

        #contact form input,
        #contact form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        #contact form textarea {
            min-height: 150px;
        }

        #contact form button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #contact form button:hover {
            background-color: #2980b9;
        }

        #form-message {
            text-align: center;
            color: green;
            font-size: 1.2rem;
            margin-top: 10px;
            display: none;
        }

        footer {
            background-color: var(--secondary-color);
            color: #fff;
            text-align: center;
            padding: 1rem 0;
            margin-top: 2rem;
        }

        footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
            }

            .logo {
                margin-bottom: 1rem;
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
        <div class="container">
            <div class="navbar-content">
                <div class="logo">
                    <img src="./images/logo2.png" alt="Edusphere Logo">
                    <h1>Edusphere</h1>
                </div>
                <ul>
                    <li><a href="./pages/HomePage.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="./Authentication/AuthenticationService.php"><i class="fas fa-user-lock"></i> Authentication</a></li>
                    <li><a href="./OMS SYSTEM/OMS DEMO.php"><i class="fas fa-pencil-alt"></i> Exam</a></li>
                    <li><a href="./LMS SYSTEM/libararyservice.php"><i class="fas fa-book"></i> Library</a></li>
                    <li><a href="./CHAT/ChatService.php"><i class="fas fa-comments"></i> Chat</a></li>
                    <li><a href="./pages/AboutUs.php"><i class="fas fa-info-circle"></i> About</a></li>
                    <li><a href="./web.php"><i class="fas fa-fax"></i> FAQ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <form id="contact-form">
                <input type="text" name="name" id="name" placeholder="Your Name" required>
                <input type="email" name="email" id="email" placeholder="Your Email" required>
                <textarea name="message" id="message" placeholder="Your Message" rows="4" required></textarea>
                <button type="submit">Send Message</button>
                <p id="form-message">Message Sent Successfully!</p>
                <p>If you have any doubts, check our <a href="./web.php">FAQ page</a>.</p>
            </form>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>Contact us at <a href="mailto:support@edusphere.com">support@edusphere.com</a></p>
        </div>
    </footer>

    <script>
        document.getElementById("contact-form").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent actual form submission

            // Basic Validation
            let name = document.getElementById("name").value.trim();
            let email = document.getElementById("email").value.trim();
            let message = document.getElementById("message").value.trim();

            if (name === "" || email === "" || message === "") {
                alert("Please fill in all fields.");
                return;
            }

            // Simulated form submission
            document.getElementById("form-message").style.display = "block";

            // Optionally, reset form fields
            this.reset();
        });
    </script>
</body>
</html>

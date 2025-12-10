<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSPHERE - Online Examination System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fa;
            --accent-color: #28a745;
            --text-color: #333;
            --light-gray: #e2e6ea;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--secondary-color);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        nav {
            background-color: var(--primary-color);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            margin: 0 15px;
            transition: all 0.3s ease;
            padding: 8px 12px;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        nav img {
            width: 120px;
            height: auto;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            text-align: center;
        }

        h1 {
            font-size: 36px;
            color: var(--text-color);
            margin-bottom: 30px;
        }

        #timer {
            font-size: 24px;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 600;
        }

        button {
            padding: 14px 28px;
            background: var(--accent-color);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            border-radius: 50px;
            margin-top: 20px;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(40, 167, 69, 0.2);
        }

        button:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(40, 167, 69, 0.3);
        }

        .option {
            display: block;
            margin: 15px 0;
            padding: 15px;
            background: var(--light-gray);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            text-align: left;
        }

        .option:hover {
            background-color: #d0d4d9;
            transform: translateY(-2px);
        }

        .hidden { 
            display: none; 
        }

        footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }

        #questionText {
            font-size: 24px;
            color: var(--text-color);
            margin-bottom: 25px;
        }

        #resultContainer {
            background-color: #f1f8ff;
            border-radius: 12px;
            padding: 30px;
            margin-top: 30px;
        }

        #score {
            font-size: 48px;
            color: var(--primary-color);
            font-weight: 700;
        }
    </style>
</head>
<body>

    <nav>
        <div>
            <img src="../images/logo2.png" alt="EDUSPHERE Logo">
        </div>
        <div>
            <a href="../OMS SYSTEM/login.php">Login</a>
            <a href="../OMS SYSTEM/register.php">Register</a>
            <a href="../pages/HomePage.php">Home</a>
            <a href="../Message.php">Contact</a>
        </div>
    </nav>

    <div class="container">
        <h1>Welcome to EDUSPHERE Online Examination
            this is a demo propsal 
        </h1>
        <button id="startBtn" onclick="startQuiz()">Start Quiz</button>

        <div id="quizContainer" class="hidden">
            <p id="timer">Time Left: <span id="time">30</span>s</p>
            <h2 id="questionText"></h2>
            <div id="options"></div>
            <button onclick="nextQuestion()">Next Question</button>
        </div>

        <div id="resultContainer" class="hidden">
            <h2>Quiz Completed!</h2>
            <p>Your Score: <span id="score"></span>/5</p>
            <button onclick="restartQuiz()">Retake Quiz</button>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Edusphere. All rights reserved.</p>
    </footer>

    <script>
        let questions = [
            { question: "What is the capital of France?", options: ["London", "Paris", "Berlin", "Madrid"], answer: "Paris" },
            { question: "Which is the largest planet in our solar system?", options: ["Earth", "Mars", "Jupiter", "Venus"], answer: "Jupiter" },
            { question: "What is the result of 5 + 3?", options: ["5", "8", "10", "15"], answer: "8" },
            { question: "Which is the national animal of India?", options: ["Lion", "Tiger", "Elephant", "Leopard"], answer: "Tiger" },
            { question: "Which is the longest river in the world?", options: ["Nile", "Amazon", "Ganga", "Yangtze"], answer: "Nile" }
        ];
        
        let currentQuestionIndex = 0;
        let score = 0;
        let timer;
        let timeLeft = 30;

        function startQuiz() {
            document.getElementById("startBtn").classList.add("hidden");
            document.getElementById("quizContainer").classList.remove("hidden");
            loadQuestion();
            startTimer();
        }

        function startTimer() {
            timeLeft = 30;
            document.getElementById("time").innerText = timeLeft;
            timer = setInterval(() => {
                timeLeft--;
                document.getElementById("time").innerText = timeLeft;
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    alert("Time's up! Moving to the next question.");
                    nextQuestion();
                }
            }, 1000);
        }

        function loadQuestion() {
            clearInterval(timer);
            startTimer();
            let questionObj = questions[currentQuestionIndex];
            document.getElementById("questionText").innerText = questionObj.question;
            let optionsDiv = document.getElementById("options");
            optionsDiv.innerHTML = "";

            questionObj.options.forEach(option => {
                let btn = document.createElement("div");
                btn.classList.add("option");
                btn.innerText = option;
                btn.onclick = () => selectAnswer(option);
                optionsDiv.appendChild(btn);
            });
        }

        function selectAnswer(answer) {
            let correctAnswer = questions[currentQuestionIndex].answer;
            if (answer === correctAnswer) {
                score++;
            }
            nextQuestion();
        }

        function nextQuestion() {
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                loadQuestion();
            } else {
                showResult();
            }
        }

        function showResult() {
            clearInterval(timer);
            document.getElementById("quizContainer").classList.add("hidden");
            document.getElementById("resultContainer").classList.remove("hidden");
            document.getElementById("score").innerText = score;
        }

        function restartQuiz() {
            currentQuestionIndex = 0;
            score = 0;
            document.getElementById("resultContainer").classList.add("hidden");
            document.getElementById("startBtn").classList.remove("hidden");
        }
    </script>

</body>
</html>
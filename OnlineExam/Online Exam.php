<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Exam System</title>
  <style>
    /* CSS Section */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
      color: #333;
    }

    header {
      background-color: #4CAF50;
      color: white;
      padding: 15px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    header .logo {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    header .logo img {
      width: 50px;
      height: 50px;
      margin-right: 10px;
    }

    header h1 {
      font-size: 2rem;
      margin: 0;
    }

    .navbar ul {
      list-style: none;
      padding: 0;
      display: flex;
      justify-content: center;
      margin-top: 10px;
    }

    .navbar ul li {
      margin: 0 20px;
    }

    .navbar ul li a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      font-size: 1.1rem;
    }

    .navbar ul li a:hover {
      text-decoration: underline;
    }

    .container {
      max-width: 700px;
      margin: 20px auto;
      padding: 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }

    h2 {
      text-align: center;
      font-size: 1.8rem;
      color: #333;
      margin-bottom: 20px;
    }

    .question {
      margin: 20px 0;
    }

    .options {
      margin: 10px 0;
    }

    .options label {
      display: block;
      margin: 10px 0;
      padding: 5px;
      background-color: #f0f0f0;
      border-radius: 5px;
      cursor: pointer;
    }

    .options input[type="radio"] {
      margin-right: 10px;
    }

    .btn {
      display: inline-block;
      background: #4CAF50;
      color: white;
      padding: 12px 25px;
      text-align: center;
      text-decoration: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.3s;
      margin-top: 30px;
      width: 100%;
    }

    .btn:hover {
      background: #45a049;
    }

    .result {
      text-align: center;
      font-size: 1.5rem;
      color: #333;
    }

    .note {
      text-align: center;
      margin-top: 30px;
      font-size: 1rem;
      color: #888;
    }

    .note a {
      color: #4CAF50;
      text-decoration: none;
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">
      <img src="../images/logo2.png" alt="Edusphere Logo">
      <h1>Edusphere</h1>
    </div>
    <nav class="navbar">
      <ul>
        <li><a href="../pages/HomePage.php">Home</a></li>
        <li><a href="../Dashboard/StudentRegirstataion.php">Student</a></li>
        <li><a href="../Dashboard/TeacherRegirstataion.php">Teacher</a></li>
      </ul>
    </nav>
  </header>

  <div class="container" id="exam-container">
    <h2>Test Your Knowledge</h2>
    <div id="question-container">
      <!-- Questions will load here dynamically -->
    </div>
    <button class="btn" onclick="submitExam()">Submit</button>
    <p class="note">Note: These questions are for demo purposes only to help you learn. You should log in first to see how it works.</p>
  </div>

  <div class="container" id="result-container" style="display: none;">
    <h2>Exam Result</h2>
    <p class="result" id="result"></p>
    <button class="btn" onclick="restartExam()">Retake Exam</button>
  </div>

  <script>
    // JavaScript Section
    const questions = [
      {
        question: "What does HTML stand for?",
        options: [
          "HyperText Markup Language",
          "HyperText Markdown Language",
          "HighText Markup Language",
          "HyperTransfer Markup Language"
        ],
        answer: 0
      },
      {
        question: "What does CSS stand for?",
        options: [
          "Cascading Style Sheets",
          "Creative Style Sheets",
          "Computer Style Sheets",
          "Colorful Style Sheets"
        ],
        answer: 0
      },
      {
        question: "What does JS stand for?",
        options: [
          "JavaSource",
          "JavaScript",
          "JustScript",
          "JScript"
        ],
        answer: 1
      }
    ];

    let currentAnswers = [];

    // Load Questions
    function loadQuestions() {
      const container = document.getElementById("question-container");
      container.innerHTML = ""; // Clear container
      questions.forEach((q, index) => {
        const questionDiv = document.createElement("div");
        questionDiv.classList.add("question");
        questionDiv.innerHTML = ` 
          <p><strong>${index + 1}. ${q.question}</strong></p>
          <div class="options">
            ${q.options.map((opt, optIndex) => ` 
              <label>
                <input type="radio" name="question-${index}" value="${optIndex}">
                ${opt}
              </label>
            `).join('')}
          </div>
        `;
        container.appendChild(questionDiv);
      });
    }

    // Submit Exam
    function submitExam() {
      currentAnswers = [];
      let score = 0;
      questions.forEach((q, index) => {
        const selectedOption = document.querySelector(`input[name="question-${index}"]:checked`);
        if (selectedOption) {
          currentAnswers.push(parseInt(selectedOption.value));
          if (parseInt(selectedOption.value) === q.answer) {
            score++;
          }
        } else {
          currentAnswers.push(null); // No answer selected
        }
      });

      // Display Result
      document.getElementById("exam-container").style.display = "none";
      document.getElementById("result-container").style.display = "block";
      document.getElementById("result").textContent = `You scored ${score} out of ${questions.length}`;
    }

    // Restart Exam
    function restartExam() {
      currentAnswers = [];
      document.getElementById("result-container").style.display = "none";
      document.getElementById("exam-container").style.display = "block";
      loadQuestions();
    }

    // Initialize Exam
    loadQuestions();
  </script>

</body>
</html>

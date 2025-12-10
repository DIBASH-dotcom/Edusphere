<?php
// Preserve any existing PHP backend code here
$current_time = date('h:i A');
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Get the current year for the copyright notice
$current_year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edusphere Chat Service</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --primary-dark: #3a56d4;
      --secondary: #3f37c9;
      --light: #f8f9fa;
      --dark: #212529;
      --success: #4cc9f0;
      --gray: #6c757d;
      --gray-light: #e9ecef;
      --border-radius: 0.75rem;
      --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s ease;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f2f5;
      color: var(--dark);
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    
    .header {
      background-color: white;
      box-shadow: var(--shadow);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
    }
    
    .header-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0.75rem 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .logo {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .logo img {
      height: 40px;
    }
    
    .logo h1 {
      font-size: 1.5rem;
      color: var(--primary);
      margin: 0;
    }
    
    .navbar ul {
      display: flex;
      list-style: none;
      gap: 1.5rem;
    }
    
    .navbar a {
      text-decoration: none;
      color: var(--dark);
      font-weight: 500;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.9rem;
    }
    
    .navbar a:hover {
      color: var(--primary);
    }
    
    .main-container {
      max-width: 1200px;
      margin: 80px auto 2rem;
      padding: 0 1rem;
      display: flex;
      justify-content: center;
      flex: 1;
    }
    
    .chat-container {
      width: 100%;
      max-width: 800px;
      background-color: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      height: 70vh;
    }
    
    .chat-header {
      background-color: var(--primary);
      color: white;
      padding: 1rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    
    .chat-header h3 {
      margin: 0;
      font-size: 1.25rem;
      font-weight: 600;
    }
    
    .chat-header-actions {
      display: flex;
      gap: 1rem;
    }
    
    .chat-header-actions button {
      background: none;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 1.1rem;
      opacity: 0.8;
      transition: var(--transition);
    }
    
    .chat-header-actions button:hover {
      opacity: 1;
    }
    
    .chat-box {
      flex-grow: 1;
      overflow-y: auto;
      padding: 1.5rem;
      background-color: #f5f7fb;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    
    .message {
      max-width: 80%;
      padding: 0.75rem 1rem;
      border-radius: 1rem;
      position: relative;
      animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .bot-message {
      background-color: white;
      color: var(--dark);
      border-top-left-radius: 0.25rem;
      align-self: flex-start;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .user-message {
      background-color: var(--primary);
      color: white;
      border-top-right-radius: 0.25rem;
      align-self: flex-end;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .message-time {
      font-size: 0.7rem;
      opacity: 0.7;
      margin-top: 0.25rem;
      text-align: right;
    }
    
    .typing-indicator {
      display: flex;
      align-items: center;
      gap: 0.25rem;
      padding: 0.5rem 1rem;
      background-color: white;
      border-radius: 1rem;
      width: fit-content;
      margin-top: 0.5rem;
      align-self: flex-start;
    }
    
    .typing-dot {
      width: 8px;
      height: 8px;
      background-color: var(--gray);
      border-radius: 50%;
      animation: typingAnimation 1.4s infinite ease-in-out;
    }
    
    .typing-dot:nth-child(1) { animation-delay: 0s; }
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
    
    @keyframes typingAnimation {
      0%, 60%, 100% { transform: translateY(0); }
      30% { transform: translateY(-5px); }
    }
    
    .chat-input {
      display: flex;
      padding: 1rem;
      background-color: white;
      border-top: 1px solid var(--gray-light);
      gap: 0.75rem;
    }
    
    .chat-input-wrapper {
      position: relative;
      flex-grow: 1;
    }
    
    #messageInput {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid var(--gray-light);
      border-radius: 1.5rem;
      outline: none;
      transition: var(--transition);
      font-size: 0.95rem;
    }
    
    #messageInput:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.2);
    }
    
    .chat-actions {
      display: flex;
      gap: 0.5rem;
    }
    
    .chat-actions button {
      padding: 0.75rem;
      background-color: var(--primary);
      color: white;
      border: none;
      border-radius: 50%;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
      width: 40px;
      height: 40px;
    }
    
    .chat-actions button:hover {
      background-color: var(--primary-dark);
      transform: translateY(-2px);
    }
    
    .chat-actions button:active {
      transform: translateY(0);
    }
    
    .emoji-button {
      background-color: transparent !important;
      color: var(--gray) !important;
    }
    
    .emoji-button:hover {
      color: var(--primary) !important;
      background-color: var(--gray-light) !important;
    }
    
    .footer {
      background-color: var(--primary);
      color: white;
      padding: 2rem 0;
      margin-top: 2rem;
    }
    
    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 2rem;
    }
    
    .footer-section {
      flex: 1;
      min-width: 200px;
    }
    
    .footer-section h3 {
      margin-bottom: 1rem;
      font-size: 1.2rem;
    }
    
    .footer-section ul {
      list-style: none;
      padding: 0;
    }
    
    .footer-section ul li {
      margin-bottom: 0.5rem;
    }
    
    .footer-section ul li a {
      color: white;
      text-decoration: none;
      transition: var(--transition);
    }
    
    .footer-section ul li a:hover {
      opacity: 0.8;
    }
    
    .footer-bottom {
      text-align: center;
      margin-top: 2rem;
      padding-top: 1rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    @media (max-width: 768px) {
      .header-content {
        flex-direction: column;
        padding: 0.5rem;
      }
      
      .navbar ul {
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 0.5rem;
      }
      
      .navbar a {
        font-size: 0.8rem;
      }
      
      .main-container {
        margin-top: 120px;
        padding: 0 0.5rem;
      }
      
      .chat-container {
        height: calc(100vh - 140px);
      }
      
      .message {
        max-width: 90%;
      }
      
      .footer-content {
        flex-direction: column;
        padding: 0 1rem;
      }
    }
    
    @media (max-width: 480px) {
      .logo h1 {
        font-size: 1.2rem;
      }
      
      .navbar ul {
        gap: 0.5rem;
      }
      
      .navbar a {
        font-size: 0.75rem;
      }
      
      .chat-header h3 {
        font-size: 1rem;
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
          <li><a href="../pages/HomePage.php"><i class="fas fa-home"></i> Home</a></li>
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

  <div class="main-container">
    <div class="chat-container">
      <div class="chat-header">
        <h3><i class="fas fa-comments"></i> Edusphere Chat Service</h3>
        <div class="chat-header-actions">
          <button title="Clear chat"><i class="fas fa-eraser"></i></button>
          <button title="Settings"><i class="fas fa-cog"></i></button>
        </div>
      </div>
      <div class="chat-box" id="chatBox">
        <div class="message bot-message">
          Hello <?php echo htmlspecialchars($user_name); ?>! Welcome to Edusphere Chat Service. How can I assist you today?
          <div class="message-time"><?php echo $current_time; ?></div>
        </div>
      </div>
      <div class="chat-input">
        <div class="chat-input-wrapper">
          <input type="text" id="messageInput" placeholder="Type your message here..." />
        </div>
        <div class="chat-actions">
          <button class="emoji-button" title="Add emoji"><i class="far fa-smile"></i></button>
          <button onclick="sendMessage()" title="Send message"><i class="fas fa-paper-plane"></i></button>
        </div>
      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="footer-content">
      <div class="footer-section">
        <h3>About Edusphere</h3>
        <p>Edusphere is a comprehensive educational platform designed to enhance learning experiences through innovative technology and collaborative tools.</p>
      </div>
      <div class="footer-section">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="../Authentication/AuthenticationService.php">Authentication</a></li>
          <li><a href="../OMS SYSTEM/OMS DEMO.php">Exam System</a></li>
          <li><a href="../LMS SYSTEM/libararyservice.php">Library Services</a></li>
          <li><a href="../CHAT/ChatService.php">Chat Service</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h3>Contact Us</h3>
        <ul>
          <li><i class="fas fa-envelope"></i> support@edusphere.com</li>
          <li><i class="fas fa-phone"></i> +1 (123) 456-7890</li>
          <li><i class="fas fa-map-marker-alt"></i> 123 Education St, Learning City, ED 12345</li>
        </ul>
      </div>
      <div class="footer-section">
        <h3>Follow Us</h3>
        <ul>
          <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
          <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
          <li><a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
          <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; <?php echo $current_year; ?> Edusphere. All rights reserved.</p>
    </div>
  </footer>

  <script>
    function sendMessage() {
      const messageInput = document.getElementById("messageInput");
      const messageText = messageInput.value.trim();
      const chatBox = document.getElementById("chatBox");

      if (messageText !== "") {
        // Get current time
        const now = new Date();
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        // Display user message
        const userMessage = document.createElement("div");
        userMessage.classList.add("message", "user-message");
        userMessage.innerHTML = `${messageText}<div class="message-time">${timeString}</div>`;
        chatBox.appendChild(userMessage);

        // Clear input field
        messageInput.value = "";

        // Show typing indicator
        const typingIndicator = document.createElement("div");
        typingIndicator.classList.add("typing-indicator");
        typingIndicator.innerHTML = `
          <div class="typing-dot"></div>
          <div class="typing-dot"></div>
          <div class="typing-dot"></div>
        `;
        chatBox.appendChild(typingIndicator);

        // Scroll to the bottom
        chatBox.scrollTop = chatBox.scrollHeight;

        // Auto-reply from bot after delay
        setTimeout(() => {
          // Remove typing indicator
          chatBox.removeChild(typingIndicator);

          // Add bot response
          const botMessage = document.createElement("div");
          botMessage.classList.add("message", "bot-message");
          
          // Here you would typically integrate with your PHP backend
          // For now, we'll use a simple response
          botMessage.innerHTML = `Thank you for your message! Our team will get back to you soon.<div class="message-time">${timeString}</div>`;
          chatBox.appendChild(botMessage);

          // Scroll to the bottom again
          chatBox.scrollTop = chatBox.scrollHeight;
        }, 1500);
      }
    }

    // Allow sending message with Enter key
    document.getElementById("messageInput").addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
        sendMessage();
      }
    });

    // Clear chat functionality
    document.querySelector(".chat-header-actions button:first-child").addEventListener("click", function() {
      const chatBox = document.getElementById("chatBox");
      
      // Keep only the first welcome message
      while (chatBox.childNodes.length > 1) {
        chatBox.removeChild(chatBox.lastChild);
      }
    });
  </script>
</body>
</html>
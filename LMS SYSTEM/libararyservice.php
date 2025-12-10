<?php
// Initialize the books array (this would typically come from a database)
$books = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addBook"])) {
    $newBook = trim($_POST["bookName"]);
    if (!empty($newBook)) {
        $books[] = $newBook;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibArray Service</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 28px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        nav {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: 10px 5%;
            background-color: #333;
        }
        nav img {
            width: 50px;
            height: auto;
            margin-right: 20px;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: #4CAF50;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
            text-align: center;
        }
        .book-input {
            margin: 25px 0;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        #bookName {
            padding: 12px;
            width: 300px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
        }
        button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }
        #library {
            margin-top: 25px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }
        .book {
            background-color: #009688;
            color: white;
            padding: 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
            min-width: 150px;
        }
        .book:hover {
            transform: scale(1.05);
            background-color: #00796b;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
    LibArray Service
</header>

<nav>
    <img src="../images/logo2.png" alt="LibArray Logo">
    <a href="../LMS SYSTEM/login.php">Login</a>
    <a href="../LMS SYSTEM/register.php">Register</a>
</nav>

<div class="container">
    <h2>Welcome to LibArray Service!</h2>
    <h4>Please log in to explore the library. This is a Demo</h4>

    <form method="POST" action="" class="book-input">
        <input type="text" id="bookName" name="bookName" placeholder="Enter book name" required>
        <button type="submit" name="addBook">Add Book</button>
    </form>

    <h3>Available Books</h3>
    <div id="library">
        <?php foreach ($books as $book): ?>
            <div class="book"><?php echo htmlspecialchars($book); ?></div>
        <?php endforeach; ?>
    </div>
</div>

<footer>
    © <?php echo date("Y"); ?> Edusphere. All rights reserved.
</footer>

<script>
    let books = <?php echo json_encode($books); ?>;

    function displayBooks() {
        let libraryDiv = document.getElementById("library");
        libraryDiv.innerHTML = "";
        books.forEach((book, index) => {
            let bookDiv = document.createElement("div");
            bookDiv.className = "book";
            bookDiv.textContent = book;
            bookDiv.onclick = function() {
                removeBook(index);
            };
            libraryDiv.appendChild(bookDiv);
        });
    }

    function removeBook(index) {
        books.splice(index, 1);
        displayBooks();
    }

    // Initial display of books
    displayBooks();
</script>

</body>
</html>
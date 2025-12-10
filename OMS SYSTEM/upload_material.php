<?php
session_start();
require_once "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $file_name = basename($_FILES["file"]["name"]);
    $target_dir = "uploads/";
    $target_file = $target_dir . $file_name;
    
    // Check if the user is logged in and has a valid session
    if (isset($_SESSION['user_id'])) {
        $uploaded_by = $_SESSION['user_id']; // Get the logged-in user's ID
    } else {
        echo "<script>alert('Please log in first.'); window.location.href='login.php';</script>";
        exit();
    }
    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO study_materials_online (title, filename, uploaded_by) VALUES (?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssi", $title, $file_name, $uploaded_by);
        
        if ($stmt->execute()) {
            echo "<script>alert('File uploaded successfully!');</script>";
        } else {
            echo "<script>alert('Error uploading file. Please try again later.');</script>";
        }
        
        $stmt->close(); // Close the statement after executing
    } else {
        echo "<script>alert('Failed to upload file.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Study Material</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Google Font */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
        }

        a {
            text-decoration: none;
            color: #764ba2;
            font-weight: bold;
            transition: 0.3s;
        }

        a:hover {
            color: #667eea;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #764ba2;
        }

        input[type="file"] {
            border: none;
        }

        .file-preview {
            display: none;
            margin-top: 10px;
        }

        .file-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        button {
            background: #764ba2;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
            margin-top: 10px;
            width: 100%;
        }

        button:hover {
            background: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload Study Material</h2>
        <a href="../OMS SYSTEM/student_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Name:</label>
            <input type="text" id="title" name="title" required>
            
            <label for="file">Choose file to upload:</label>
            <input type="file" id="file" name="file" required accept="image/*, .pdf, .doc, .docx">
            
            <div class="file-preview" id="filePreview">
                <img id="previewImage" src="" alt="Preview">
            </div>

            <button type="submit">Upload</button>
        </form>
    </div>

    <script>
        // File Preview Functionality
        document.getElementById("file").addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById("previewImage");
                    const filePreview = document.getElementById("filePreview");

                    if (file.type.startsWith("image/")) {
                        previewImage.src = e.target.result;
                        filePreview.style.display = "block";
                    } else {
                        filePreview.style.display = "none";
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>

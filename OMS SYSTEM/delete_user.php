<?php 
session_start();
require_once "../connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // First, delete dependent courses
    $sql_delete_courses = "DELETE FROM users_online WHERE id = ?";
    $stmt_courses = $con->prepare($sql_delete_courses);
    
    if ($stmt_courses === false) {
        die("Error preparing statement: " . $con->error);
    }
    
    $stmt_courses->bind_param("i", $id);
    if (!$stmt_courses->execute()) {
        die("Error executing delete courses query: " . $stmt_courses->error);
    }

    // Now, delete the user
    $sql = "DELETE FROM users_online WHERE id = ?";
    $stmt = $con->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('User removed!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        die("Error executing delete user query: " . $stmt->error);
    }
}
?>
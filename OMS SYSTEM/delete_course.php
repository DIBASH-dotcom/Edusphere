<?php
session_start();
require_once "../connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // सही तालिका नाम राख्नुहोस् (courses_online जस्तै)
    $sql = "DELETE FROM courses_online WHERE course_id = ?";  
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Course deleted!'); window.location.href='admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error deleting course!'); window.location.href='admin_dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Query preparation failed!'); window.location.href='admin_dashboard.php';</script>";
    }
}
?>

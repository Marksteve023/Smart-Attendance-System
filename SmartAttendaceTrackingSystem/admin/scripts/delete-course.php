<?php

include '../../config/db.php';

// Start the session
session_start();

// Check if the 'course_id' parameter is present in the URL
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    // Validate the course ID (make sure it's numeric)
    if (is_numeric($course_id)) {
        try {
            // Prepare the SQL DELETE query
            $sql = "DELETE FROM courses WHERE course_id = :course_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);

            // Execute the query and check if successful
            if ($stmt->execute()) {
                // Set success message and redirect back to course page
                $_SESSION['success_message'] = "Course deleted successfully!";
            } else {
                // Set error message in case of failure
                $_SESSION['error_message'] = "Failed to delete the course.";
            }
        } catch (PDOException $e) {
            // Handle any database exceptions
            $_SESSION['error_message'] = "Error: " . $e->getMessage();
        }
    } else {
        // Invalid course ID
        $_SESSION['error_message'] = "Invalid course ID.";
    }

    // Redirect back to the course page
    header("Location: ../course.php");
    exit();
}
?>

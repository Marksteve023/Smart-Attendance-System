<?php
// Include the database connection
include '../../config/db.php';

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $course_name = $_POST['course_name'];
    $section = $_POST['section'];
    $semester = $_POST['semester'];

    // Check if the course name, section, and semester are filled
    if (!empty($course_name) && !empty($section) && !empty($semester)) {
        // Prepare the SQL query to insert the course
        $sql = "INSERT INTO courses (course_name, section, semester) VALUES (:course_name, :section, :semester)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':course_name', $course_name);
        $stmt->bindParam(':section', $section);
        $stmt->bindParam(':semester', $semester);
        
        // Execute the query and check for errors
        if ($stmt->execute()) {
            // Success: Set the session message
            $_SESSION['success_message'] = "Course added successfully!";
        } else {
            // Error: Set the session message with error details
            $_SESSION['error_message'] = "Failed to add course. Error: " . implode(", ", $stmt->errorInfo());
        }
    } else {
        $_SESSION['error_message'] = "Please fill in all fields!";
    }
    
    // Redirect back to the course list page
    header("Location: /admin/course.php");
    exit();
}
?>

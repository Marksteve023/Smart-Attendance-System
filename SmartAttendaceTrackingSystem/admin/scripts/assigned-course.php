<?php
session_start();
include '../../config/db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $school_teacher_id = trim($_POST['school_teacher_id']);
    $course_id = trim($_POST['course_id']);

    // Validate form fields
    if (empty($school_teacher_id) || empty($course_id)) {
        $_SESSION['error'] = "Teacher ID and Course are required!";
        header("Location: /admin/manage-teachers.php");
        exit();
    }

    try {
        // Check if the teacher exists in the teachers table
        $stmt = $conn->prepare("SELECT teacher_name FROM teachers WHERE school_teacher_id = ?");
        $stmt->execute([$school_teacher_id]);
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$teacher) {
            $_SESSION['error'] = "Teacher with ID {$school_teacher_id} not found!";
            header("Location: admin/manage-teachers.php");
            exit();
        }

        $teacher_name = $teacher['teacher_name']; // Get teacher name for reference

        // Fetch the section from the courses table
        $stmtCourse = $conn->prepare("SELECT section FROM courses WHERE course_id = ?");
        $stmtCourse->execute([$course_id]);
        $course = $stmtCourse->fetch(PDO::FETCH_ASSOC);
        
        // Get the course section
        $section = $course['section'];

        // Check if the course is already assigned to this teacher
        $stmt = $conn->prepare("SELECT * FROM assigned_courses WHERE school_teacher_id = ? AND course_id = ?");
        $stmt->execute([$school_teacher_id, $course_id]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "This course is already assigned to the teacher!";
            header("Location: admin/manage-teachers.php");
            exit();
        }

        // Insert into assigned_courses table
        $stmt = $conn->prepare("INSERT INTO assigned_courses (school_teacher_id, course_id, section) VALUES (?, ?, ?)");
        $stmt->execute([$school_teacher_id, $course_id, $section]);

        // Check if insertion was successful
        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = "Course successfully assigned to {$teacher_name} in section {$section}.";
        } else {
            $_SESSION['error'] = "Failed to assign course. Please try again.";
        }

        // Redirect after success or failure
        header("Location: admin/manage-teachers.php");
        exit();

    } catch (PDOException $e) {
        // Catch and handle any errors from the database
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: admin/manage-teachers.php");
        exit();
    }
} else {
    // Invalid request method
    $_SESSION['error'] = "Invalid request method!";
    header("Location: admin/manage-teachers.php");
    exit();
}
?>

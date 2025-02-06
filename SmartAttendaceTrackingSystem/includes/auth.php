<?php
// Start session if not already started
session_start();

// Include the database connection
require_once __DIR__ . '/../config/db.php';  

// Initialize error message
$error_message = "";

// Check if request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Collect and sanitize form data
    $role = strtolower(trim($_POST['role'] ?? '')); 
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validate form inputs
    if (empty($role) || empty($username) || empty($password)) {
        $error_message = "All fields are required!";
    } else {
        try {
            // Query to get the teacher from the teachers table
            $sql = "SELECT * FROM teachers WHERE username = :username AND role = :role";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['teacher_id'] = $user['teacher_id'];  // Now using teacher_id for session
                $_SESSION['role'] = $user['role'];
                $_SESSION['username'] = $user['username'];

                // Redirect user based on role
                if ($role === 'admin') {
                    header("Location: ./admin/dashboard.php");
                    exit;
                } elseif ($role === 'teacher') {
                    header("Location: ./teacher/dashboard.php");
                    exit;
                }
            } else {
                $error_message = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}
?>

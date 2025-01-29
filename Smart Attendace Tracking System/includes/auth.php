<?php
// Start the session to store login status or user information
session_start();

// Define error messages
$errorMessage = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form values
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sample credentials (in practice, fetch from a database)
    $users = [
        'admin' => ['password' => 'admin123', 'role' => 'admin'],
        'teacher' => ['password' => 'teacher123', 'role' => 'teacher']
    ];

    // Check if the username exists and the password matches
    if (isset($users[$username]) && $users[$username]['password'] === $password && $users[$username]['role'] === $role) {
        // Set session variables for the logged-in user
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        
        // Redirect to the respective dashboard based on the role
        if ($role == 'admin') {
            header("Location: admin/dashboard.php");  // Redirect to admin dashboard
        } elseif ($role == 'teacher') {
            header("Location: teacher/dashboard.php");  // Redirect to teacher dashboard
        }
        exit();
    } else {
        $errorMessage = "Invalid login credentials!";
    }
}
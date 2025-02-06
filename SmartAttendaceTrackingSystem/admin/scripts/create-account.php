<?php
session_start();  // Start the session to store the success message

include '../../config/db.php';  // Correct path to include db.php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $school_teacher_id = htmlspecialchars($_POST['school_teacher_id']);
    $teacher_name = htmlspecialchars($_POST['teacher_name']);
    $program = htmlspecialchars($_POST['program']);
    $role = htmlspecialchars($_POST['role']);
    
    // Sanitize and validate email  
    $username = filter_var($_POST['username'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Validate password strength
    $password = $_POST['password'];
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters.";
        exit;
    }

    // Hash the password before saving
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the picture is uploaded and process it
    $picture = $_FILES['picture']['name'];

    // Default picture if none uploaded
    if (empty($picture)) {
        $picture = 'default.png';  // Replace with a default picture name
    } else {
        // Validate file type and size (example: only allowing images up to 2MB)
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = strtolower(pathinfo($picture, PATHINFO_EXTENSION));
        $max_file_size = 2 * 1024 * 1024;  // 2MB

        if (!in_array($file_extension, $allowed_extensions)) {
            echo "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
            exit;
        }

        if ($_FILES['picture']['size'] > $max_file_size) {
            echo "File size exceeds the 2MB limit.";
            exit;
        }

        // Move the uploaded file to the uploads folder (make sure folder exists and is writable)
        $target_dir = "../../uploads/";  // Corrected path to uploads folder
        $target_file = $target_dir . basename($picture);

        if (!move_uploaded_file($_FILES['picture']['tmp_name'], $target_file)) {
            echo "Failed to upload file.";
            exit;
        }
    }

    // Prepare SQL query to insert the new account into the teachers table
    $sql = "INSERT INTO teachers (school_teacher_id, teacher_name, program, role, username, password, picture)
            VALUES (:school_teacher_id, :teacher_name, :program, :role, :username, :password, :picture)";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':school_teacher_id', $school_teacher_id);
        $stmt->bindParam(':teacher_name', $teacher_name);
        $stmt->bindParam(':program', $program);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':picture', $picture);

        // Execute the query
        $stmt->execute();

        // Set success message in session
        $_SESSION['success_message'] = "Account created successfully!";


        // Return the success message as a JSON response
        echo json_encode(['success' => true, 'message' => $_SESSION['success_message']]);
    } catch (Exception $e) {
        // If there is an error, catch it and display it
        echo json_encode(['success' => false, 'message' => 'Error creating account: ' . $e->getMessage()]);
    }
    // Redirect back to the User list page
    header("Location: /admin/user.php");
    exit();
}
?>

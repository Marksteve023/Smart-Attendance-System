<?php
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id']; // Get user ID from the form
    $teacher_id = $_POST['teacher_id'];
    $teacher_name = $_POST['teacher_name'];
    $program = $_POST['program'];
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null; // If password is provided, hash it
    $picture = $_FILES['picture']['name'] ? $_FILES['picture']['name'] : null;

    // Handle file upload
    if ($picture) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);
    }

    // SQL query to update the user details
    $sql = "UPDATE users SET teacher_id = :teacher_id, teacher_name = :teacher_name, program = :program, role = :role, username = :username";
    
    if ($password) {
        $sql .= ", password = :password";
    }

    if ($picture) {
        $sql .= ", picture = :picture";
    }

    $sql .= " WHERE user_id = :user_id";

    try {
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':teacher_id', $teacher_id);
        $stmt->bindParam(':teacher_name', $teacher_name);
        $stmt->bindParam(':program', $program);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':username', $username);
        if ($password) $stmt->bindParam(':password', $password);
        if ($picture) $stmt->bindParam(':picture', $picture);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        // Send success response
        echo json_encode(["success" => true, "message" => "Account updated successfully."]);
    } catch (PDOException $e) {
        // Send error response
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}
?>

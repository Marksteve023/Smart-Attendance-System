<?php

include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the ID is being passed correctly
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];

        error_log("Received ID: " . $id); 
        // SQL query to delete the account
        $sql = "DELETE FROM users WHERE user_id = :id";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);  
            $stmt->execute();

            // Check if the row was actually deleted
            if ($stmt->rowCount() > 0) {
                // Send a success response
                echo json_encode(["success" => true]);
            } else {
                // If no rows were affected, send an error response
                echo json_encode(["success" => false, "message" => "No user found with that ID"]);
            }
        } catch (PDOException $e) {
            // Log the error for debugging
            error_log("Error deleting user: " . $e->getMessage());

            // Send an error response
            echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
        }
    } else {
        // If the ID is not set or is empty, send an error response
        echo json_encode(["success" => false, "message" => "ID not provided or empty"]);
    }
} else {
    // Handle the case where the request is not POST
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>

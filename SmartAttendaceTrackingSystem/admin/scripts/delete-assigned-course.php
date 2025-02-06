<?php
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the assigned_course_id
    $data = json_decode(file_get_contents('php://input'), true);
    $assigned_course_id = $data['assigned_course_id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM assigned_courses WHERE assigned_course_id = :assigned_course_id";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':assigned_course_id', $assigned_course_id);
        $stmt->execute();
        
        // Return success message
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>

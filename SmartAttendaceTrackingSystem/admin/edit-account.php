<?php
session_start(); 


require_once __DIR__ . '/../config/db.php'; 


if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
}


$username = $_SESSION['username'];


$sql = "SELECT * FROM users WHERE username = :username";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$user) {
    header("Location: login.php");
    exit();
}


$teacher_id = $user['teacher_id'];
$teacher_name = $user['teacher_name'];
$program = $user['program'];
$role = $user['role'];
$current_picture = $user['picture'];

$error_message = "";
$success_message = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_name = htmlspecialchars(trim($_POST['teacher_name']));
    $program = htmlspecialchars(trim($_POST['program']));
    $role = htmlspecialchars(trim($_POST['role']));
    $new_picture = $_FILES['picture']['name'];

   
    if (empty($teacher_name) || empty($program)) {
        $error_message = "Name and Program are required!";
    } else {
        
        if (!empty($new_picture)) {
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            $file_extension = strtolower(pathinfo($new_picture, PATHINFO_EXTENSION));
            $max_file_size = 2 * 1024 * 1024; 

            if (!in_array($file_extension, $allowed_extensions)) {
                $error_message = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
            } elseif ($_FILES['picture']['size'] > $max_file_size) {
                $error_message = "File size exceeds the 2MB limit.";
            } else {
             
                $target_dir = "../../uploads/";
                $target_file = $target_dir . basename($new_picture);
                if (!move_uploaded_file($_FILES['picture']['tmp_name'], $target_file)) {
                    $error_message = "Failed to upload picture.";
                } else {
                    $current_picture = $new_picture; 
                }
            }
        }

        if (empty($error_message)) {
            // Update the user details in the database
            $sql = "UPDATE users SET teacher_name = :teacher_name, program = :program, role = :role, picture = :picture WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':teacher_name', $teacher_name);
            $stmt->bindParam(':program', $program);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':picture', $current_picture);
            $stmt->bindParam(':username', $username);

            if ($stmt->execute()) {
                $success_message = "Account updated successfully!";
            } else {
                $error_message = "Error updating account.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>  
<?php include 'admin-head.php'; ?>
</head>
<body>
    <!-- Sidebar -->
    <?php include 'admin-sidebar.php'; ?>

    <main class="main container">
        <h1>Edit Account</h1>

        <!-- Show error or success messages -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="edit-account.php" method="post" enctype="multipart/form-data">
            <div class="input-field">
                <label for="teacher_name">Full Name</label>
                <input type="text" name="teacher_name" id="teacher_name" value="<?php echo $teacher_name; ?>" required>
            </div>

            <div class="input-field">
                <label for="program">Program</label>
                <input type="text" name="program" id="program" value="<?php echo $program; ?>" required>
            </div>

            <div class="input-field">
                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="Admin" <?php echo $role == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="Teacher" <?php echo $role == 'Teacher' ? 'selected' : ''; ?>>Teacher</option>
                </select>
            </div>

            <div class="input-field">
                <label for="picture">Profile Picture</label>
                <input type="file" name="picture" id="picture" accept="image/*">
                <img src="../../uploads/<?php echo $current_picture; ?>" alt="Current Picture" class="current-picture">
            </div>

            <div class="input-field">
                <button type="submit" class="update-btn">Update Account</button>
            </div>
        </form>
    </main>

    <script src="assets/js/global.js"></script>
</body>
</html>

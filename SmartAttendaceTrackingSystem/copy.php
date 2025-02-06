
<?php

session_start();

include './config/db.php'; // Ensure the connection file path is correct


$errorMessage = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form values
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate inputs (basic check for empty fields)
    if (empty($role) || empty($username) || empty($password)) {
        $errorMessage = "Please fill in all fields.";
    } else {
    
        $query = "SELECT id, username, password, role FROM users WHERE username = :username AND role = :role";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        // Check if a user was found
        if ($stmt->rowCount() > 0) {
            // Fetch user data from the database
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password using password_verify
            if (password_verify($password, $user['password'])) {
                // Set session variables for the logged-in user
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['user_id'] = $user['id'];

                // Redirect based on user role
                if ($role == 'Admin') {
                    header("Location: admin/dashboard.php");  // Redirect to the admin dashboard
                    exit();
                } elseif ($role == 'Teacher') {
                    header("Location: teacher/dashboard.php");  // Redirect to the teacher dashboard
                    exit();
                }
            } else {
                $errorMessage = "Incorrect password!";
            }
        } else {
            $errorMessage = "No user found with this username and role.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="assets/js/global.js" defer></script>
    <title>Login</title>
</head>
<body>

    <main class="login">
        <h1>Login</h1>

        <form action="" method="post" class="login-form" id="logIn" autocomplete="off">
            <!-- Role Selection -->
            <div class="input-field">
                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="admin" <?php echo (isset($role) && $role == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="teacher" <?php echo (isset($role) && $role == 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                </select>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            </div>
            
            <!-- Username Field -->
            <div class="input-field">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <input 
                        type="email" 
                        name="username" 
                        id="username" 
                        placeholder="Enter your username" 
                        value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" 
                        required 
                    >
                </div>
            </div>

            <!-- Password Field -->
            <div class="input-field">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="Enter your password" 
                        required 
                    >
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="LogIn" id="LogIn">Login</button>
        </form>
    </main>
</body>
</html>

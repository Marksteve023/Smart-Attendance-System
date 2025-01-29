<?php

include 'includes/auth.php';

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

<!--
    <header class="title">
        <h1>Smart Attendance Tracking System</h1>
    </header> 

-->

    <main class="login">
        <h1>Login</h1>

        <form action="login.php" method="post" class="login-form" id="logIn" autocomplete="off">
            <!-- Role Selection -->
            <div class="input-field">
                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="admin" <?php echo (isset($role) && $role == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="teacher" <?php echo (isset($role) && $role == 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                </select>
                <div class="error-message" id="roleError">Please select a role.</div>
            </div>
            
            <!-- Username Field -->
            <div class="input-field">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <input 
                        type="text" 
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
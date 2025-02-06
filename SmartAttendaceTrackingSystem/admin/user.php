<?php

include '../config/db.php'; 


$sql = "SELECT * FROM teachers";
$stmt = $conn->prepare($sql);
$stmt->execute();
$teachers = $stmt->fetchAll();

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'admin-head.php'; ?>
</head>
<body>
    <?php include 'admin-sidebar.php'; ?>

    <main class="main container" id="main"> 
        <h1>Manage Accounts</h1>

        <!-- Create Account Section -->
        <div class="create-account-container">
            <h2>Create Account</h2>


            <form action="../admin/scripts/create-account.php" method="post" enctype="multipart/form-data" id="create-account-form">
                <div class="account-form-row">
                    <!-- Column 1 -->
                    <div class="column">
                        <div class="input-field">
                            <label for="school_teacher_id">School ID</label>
                            <input type="text" name="school_teacher_id" id="school_teacher_id" placeholder="ID" required aria-label="ID">
                        </div>

                        <div class="input-field">
                            <label for="teacher_name">Full Name</label>
                            <input type="text" name="teacher_name" id="teacher_name" placeholder="Full Name" required aria-label="Full Name">
                        </div>

                        <div class="input-field">
                            <label for="program">Program</label>
                            <input type="text" name="program" id="program" placeholder="Program" required aria-label="Program">
                        </div>

                        <div class="input-field">
                            <label for="role">Role</label>
                            <select name="role" id="role"> 
                                <option value="" disabled selected>---Role---</option>
                                <option value="Admin">Admin</option>
                                <option value="Teacher">Teacher</option>
                            </select>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="column">
                        <div class="input-field">
                            <label for="username">Username (Email)</label>
                            <input type="email" name="username" id="username" placeholder="account@example.com" required aria-label="Username">
                        </div>

                        <div class="input-field">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" required aria-label="Password">
                            <div id="password-error" style="color: red; display: none;"></div>
                        </div>

                        <div class="input-field">
                            <label for="picture">Profile Picture</label>
                            <input type="file" name="picture" id="picture" accept="image/*" aria-label="Upload Profile Picture">
                        </div>

                        <div class="input-field">
                            <button type="submit" class="create-btn" name="submit" id="create_account">Create Account</button>
                        </div>
                    </div>
                </div>
            </form>
          
       
        </div>

        <!-- Teacher List Section -->
        <div class="Account-list-container">
            <h2>Teacher List</h2>

            <!-- Search Bar -->
            <div class="search-wrapper">
                    <input type="text" id="search-account" placeholder="Search by School ID, Name, Program, or Role" class="search-input">
                </div>
            <div class="table-wrapper">
                <table class="account-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>School ID</th>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Program</th>
                            <th>Role</th>
                            <th>Username</th>
                            <th>Created At</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="account-list">
                        <?php foreach ($teachers as $teacher): ?>
                            <tr>
                                <td><?php echo $teacher['teacher_id']; ?></td>
                                <td><?php echo $teacher['school_teacher_id']; ?></td>
                                <td><img src="<?php echo !empty($teacher['picture']) ? '../uploads/' . $teacher['picture'] : '../uploads/default.png'; ?>" alt="Teacher Picture" class="user-picture"></td>
                                <td><?php echo $teacher['teacher_name']; ?></td>
                                <td><?php echo $teacher['program']; ?></td>
                                <td><?php echo $teacher['role']; ?></td>
                                <td><?php echo $teacher['username']; ?></td>
                                <td><?php echo $teacher['created_at']; ?></td>
                                <td><button type="button" class="edit-btn" onclick="editAccount(<?php echo $teacher['teacher_id']; ?>)">Edit</button></td>
                                <td><button type="button" class="delete-btn" onclick="deleteAccount(<?php echo $teacher['teacher_id']; ?>)">Delete</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="../assets/js/admin.js"></script>

</body>
</html>

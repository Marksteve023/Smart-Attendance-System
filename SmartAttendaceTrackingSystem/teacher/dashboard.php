<?php
session_start();

// Check if the user is logged in and has the teacher role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../login.php");
    exit();
}

// Here you should fetch dynamic data for the dashboard (e.g., $students_count)
// For now, I'll keep the static values; replace these with actual database queries
$students_count = 100; // Example static value, replace with database query
$teachers_count = 10;   // Example static value
$courses_count = 15; // Example static value
$subjects_count = 10; // Example static value
$users_count = 20; // Example static value

?>

<!-- dashboard.php -->
<!DOCTYPE html>
<head>
    <?php include'teacher-head.php';?>
</head>

<body>
    
     <!--=============== SIDEBAR ===============-->
    <?php include'sidebar.php';?>


    <!--=============== MAIN ===============-->
    <main class="main container" id="main">
         <h1>Dashboard</h1>


         <div class="dashboard-cards">
            <div class="dashboard-card">
                <h2><?php echo $students_count; ?></h2>
                <p>Students</p>
            </div>
            <div class="dashboard-card">
                <h2><?php echo $teachers_count; ?></h2>
                <p>Teachers</p>
            </div>
            <div class="dashboard-card">
                <h2><?php echo $courses_count; ?></h2>
                <p>Courses</p>
            </div>
            <div class="dashboard-card">
                <h2><?php echo $subjects_count; ?></h2>
                <p>Subjects</p>
            </div>
            <div class="dashboard-card">
                <h2><?php echo $users_count; ?></h2>
                <p>Users</p>
            </div>
        </div>

    </main>
      
    <!--=============== MAIN JS ===============-->
    <script src="/assets/js/teacher.js"></script>
   </body>
</html>

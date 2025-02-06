<?php
session_start();
include '../config/db.php'; 

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php"); 
    exit();
}



// Fetch counts from the database
$sql_students = "SELECT COUNT(*) FROM students";  
$sql_teachers = "SELECT COUNT(*) FROM teachers";  
$sql_courses = "SELECT COUNT(*) FROM courses";  


$students_count = $conn->query($sql_students)->fetchColumn();
$teachers_count = $conn->query($sql_teachers)->fetchColumn();
$courses_count = $conn->query($sql_courses)->fetchColumn();


$conn = null;
?>

<!-- dashboard.php -->
<!DOCTYPE html>
<head>
    <?php include 'admin-head.php'; ?>
</head>

<body>
    
     <!--=============== SIDEBAR ===============-->
    <?php include 'admin-sidebar.php'; ?> 

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
        </div>
    </main>

    <!--=============== MAIN JS ===============-->
    <script src="../assets/js/admin.js"></script>
</body>
</html>

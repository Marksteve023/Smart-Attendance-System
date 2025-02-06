<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it's not already started
}

include '../config/db.php'; // Include the database connection


// Get teacher details (assuming the session stores teacher ID or username)
$teacher_username = $_SESSION['username'];  // Assuming the session stores the username

// Query to fetch teacher details
$sql_teacher = $conn->prepare("SELECT teacher_name, picture FROM teachers WHERE username = :username");
$sql_teacher->bindParam(':username', $teacher_username);
$sql_teacher->execute();

$teacher = $sql_teacher->fetch(PDO::FETCH_ASSOC);

// Set default values if teacher data is not found
if ($teacher && isset($teacher['teacher_name'], $teacher['picture'])) {
    $teacher_name = $teacher['teacher_name'];
    $profile_picture = !empty($teacher['picture']) ? $teacher['picture'] : 'admin.png'; // Default if no picture
} else {
    $teacher_name = 'Administrator';  // Default name
    $profile_picture = 'default-profile.jpg';  // Default picture if no data is found
}


?>



<!--=============== HEADER ===============-->
<header class="header" id="header"> 
    <div class="header__container">
        <a href="" class="header__logo">
            <i class="ri-admin-line"></i>
            <span>Administrator</span>
        </a>

        <button class="header__toggle"id="header-toggle">
                <i class="ri-menu-line"></i>
        </button>
    </div>

</header>

    <!--=============== SIDEBAR ===============-->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar__container">
            
            <!--====== sIDEBAR USER ======-->
            <div class="sidebar__user">
                <div class="sidebar__img">
                    <img src="../uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="image">
                </div>

                <div class="sidebar__info">
                    <h3><?php echo htmlspecialchars($teacher_name); ?></h3>
                    <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </div>
            </div><!--====== END SIDEBAR USER ======-->
    
            <!--====== SIDEBAR CONTENT ======-->
            <div class="sidebar_content">
                <h3 class="sidebar__title">Manage</h3>

                <div class="sidebar__list">
                    <a href="dashboard.php" class="sidebar__link">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </div>


                <!--=======  Manage COURSE ======-->
                <div class="sidebar__list">
                    <a href="course.php" class="sidebar__link">
                        <i class="ri-git-repository-line"></i>
                        <span>Manage Course</span>
                    </a>
                </div>

                <!--=======  Manage Teacher ======-->
                <div class="sidebar__list">
                    <a href="manage-teachers.php" class="sidebar__link">
                        <i class="ri-user-line"></i>
                        <span>Manage Teacher</span>
                    </a>
                </div>

                
                <!--=======  Manage StudenT ======-->
                <div class="sidebar__list">
                    <a href="manage-students.php" class="sidebar__link">
                        <i class="ri-graduation-cap-line"></i>
                        <span>Manage Student</span>
                    </a>
                </div>


                <!--=======  Manage User ======-->
                <div class="sidebar__list">
                    <a href="user.php" class="sidebar__link">
                        <i class="ri-user-add-line"></i>
                        <span>Mange Accounts</span>
                    </a>
                </div>

            </div>

            <div class="sidebar__actions">

                <button>
                    <i class="ri-moon-clear-line sidebar__link sidebar__theme" id="theme-button">
                    <span>Theme</span>
                    </i>
                </button>

                 <form action="/includes/logout.php">

                    <button class="sidebar__link">
                        <i class="ri-logout-box-line"></i>
                        <span>Log Out</span>
                    </button>
                    
                </form>

            </div>
        </div>
    </nav>
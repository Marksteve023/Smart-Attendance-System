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
                    <img src="../assets/img/administrator.png" alt="image">
                </div>

                <div class="sidebar__info">
                    <h3>Admin</h3>
                    <span>admin@gmail.com</span>
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

                <!--=======  Manage StudenT ======-->
                <div class="sidebar__list">
                    <a href="manage-students.php" class="sidebar__link">
                        <i class="ri-graduation-cap-line"></i>
                        <span>Manage Student</span>
                    </a>
                </div>

                <!--=======  Manage Teacher ======-->
                <div class="sidebar__list">
                    <a href="manage-teachers.php" class="sidebar__link">
                        <i class="ri-user-line"></i>
                        <span>Manage Teacher</span>
                    </a>
                </div>
                <!--=======  Manage ATTENDACE ======-->
                <div class="sidebar__list">
                    <a href="manage-attendance.php" class="sidebar__link">
                        <i class="ri-survey-line"></i>
                        <span> Attendance</span>
                    </a>
                </div>

                <!--======= Reports ======-->
                <div class="sidebar__list">
                    <a href="reports.php" class="sidebar__link">
                        <i class="ri-file-chart-line"></i>
                        <span> Reports</span>
                    </a>
                </div>

                <!--=======  Manage User ======-->
                <div class="sidebar__list">
                    <a href="user.php" class="sidebar__link">
                        <i class="ri-user-add-line"></i>
                        <span>User</span>
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
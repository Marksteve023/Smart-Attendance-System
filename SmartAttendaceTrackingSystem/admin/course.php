<?php

session_start();


include '../config/db.php';

// Corrected SQL to fetch courses
$sql = "SELECT c.course_id, c.course_name, c.section, c.semester, c.created_at FROM courses c";

// Fetch the courses from the database
$stmt = $conn->prepare($sql);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<?php include 'admin-head.php'; ?>
</head>
<body>
    <!--=============== SIDEBAR ===============-->
    <?php include 'admin-sidebar.php'; ?>
    <!--=============== MAIN ===============-->
    <main class="main container" id="main">
        <h1>Course</h1>
        
        <div class="Course-container">

            <!--=============== CREATE COURSE ===============-->
            <div class="createCourse">
                <h2>Create Course</h2>
                <form action="../admin/scripts/create-course.php" method="post" class="createCourse-form" id="createcourse">
                    <!-- Course Field -->
                    <div class="input-field">
                        <label for="course_name">Course Name</label>
                        <input type="text" name="course_name" id="course_name" required>
                    </div>

                    <div class="input-field">
                        <label for="section">Section</label>
                        <input type="text" name="section" id="section" required>
                    </div>

                    <div class="input-field">
                        <label for="semester">Semester</label>
                        <select name="semester" id="semester">
                            <option value="" disabled selected>---Semester---</option>
                            <option value="1st Semester">1st Semester</option>
                            <option value="2nd Semester">2nd Semester</option>
                            <option value="3rd Semester">3rd Semester</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <button type="submit" class="save-btn" id="save">Save</button>
                    </div>
                </form>
            </div>

            <!--=============== COURSE LIST (Table) ===============-->
            <div class="course-list-container">
                <h2>Course List</h2>
                
            <!-- Search Bar -->
                <div class="search-wrapper">
                    <input type="text" id="search-course" placeholder="Search by Course Name, Section, Semester," class="search-input">
                </div>
                <!-- Scrollable Table Wrapper -->
                <div class="table-wrapper">
                    <table class="course-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Name</th>
                                <th>Section</th>
                                <th>Semester</th>
                                <th>Created At</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($courses)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; font-weight: bold;">No courses available</td>
                                    </tr>
                                <?php else: ?>
                                <?php foreach ($courses as $course): ?>
                                    <tr data-course-id="<?php echo htmlspecialchars($course['course_id']); ?>">
                                        <td><?php echo htmlspecialchars($course['course_id']); ?></td>
                                        <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                        <td><?php echo htmlspecialchars($course['section']); ?></td>
                                        <td><?php echo htmlspecialchars($course['semester']); ?></td>
                                        <td><?php echo date("Y-m-d H:i:s", strtotime($course['created_at'])); ?></td>
                                        <td>
                                            <button class="delete-btn" data-course-id="<?php echo $course['course_id']; ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>      
            </div>
        </div>
    </main>

    <!--=============== MAIN JS ===============-->
    <script src="../assets/js/admin.js"></script>
</body>
</html>

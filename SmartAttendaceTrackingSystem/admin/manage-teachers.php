<?php
session_start();
include '../config/db.php';

// Fetch assigned courses and join with teachers & courses tables
$sql = "SELECT ac.assigned_course_id, t.teacher_name, t.school_teacher_id, c.course_name, ac.section, ac.assigned_at
        FROM assigned_courses AS ac
        JOIN teachers AS t ON ac.school_teacher_id = t.school_teacher_id
        JOIN courses AS c ON ac.course_id = c.course_id
        ORDER BY ac.assigned_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$assigned_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch courses for the dropdown
$sqlCourses = "SELECT course_id, course_name, section FROM courses";
$stmtCourses = $conn->prepare($sqlCourses);
$stmtCourses->execute();
$courseOptions = $stmtCourses->fetchAll(PDO::FETCH_ASSOC);


$selectedCourseSection = '';
if (isset($_POST['course_id'])) {
    $courseId = $_POST['course_id'];
    $stmtSection = $conn->prepare("SELECT section FROM courses WHERE course_id = ?");
    $stmtSection->execute([$courseId]);
    $selectedCourse = $stmtSection->fetch(PDO::FETCH_ASSOC);
    $selectedCourseSection = $selectedCourse['section'];
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'admin-head.php'; ?>
<body>

<!-- Sidebar -->
<?php include 'admin-sidebar.php'; ?>

<!-- Main Content -->
<main class="main container" id="main">
    <h1>Manage Teacher</h1>

    <!-- Assign Course Section -->
    <div class="assignCourse">
        <h2>Assign Course</h2>

        <form action="/admin/scripts/assigned-course.php" method="post" class="assignCourse-form" id="assigncourse">
            <!-- Teacher ID Input -->
            <div class="input-field">
                <label for="school_teacher_id">Teacher ID</label>
                <input type="text" name="school_teacher_id" id="school_teacher_id" required>
            </div>

            
            <!-- Course Selection Dropdown -->
            <div class="input-field">
                <label for="course_id">Course</label>
                <select name="course_id" id="course_id" required onchange="updateSection()">
                    <option value="" disabled selected>Select Course</option>
                    <?php foreach ($courseOptions as $option): ?>
                        <option value="<?php echo htmlspecialchars($option['course_id']); ?>"
                            <?php echo (isset($_POST['course_id']) && $_POST['course_id'] == $option['course_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($option['course_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Section Input Field (Auto-filled based on course selection) -->
            <div class="input-field">
                <label for="section">Section</label>
                <input type="text" name="section" id="section" value="<?php echo htmlspecialchars($selectedCourseSection); ?>" readonly>
            </div>

            <!-- Submit Button -->
            <div class="input-field">
                <button type="submit" class="save-btn">Assign Course</button>
            </div>
        </form>
        
    </div>

    <!-- Assigned Courses List -->
    <div class="assigned-teacher-list-container">
        <h2>All Assigned Courses</h2>
                    
        
            <!-- Search Bar -->
            <div class="search-wrapper">
                    <input type="text" id="search-assigned" placeholder="Search by School ID, Name, Section, or Course" class="search-input">
                </div>
        <div class="table-wrapper">
            <table class="assigned-teacher-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Teacher ID</th>
                        <th>Name</th>
                        <th>Section</th>
                        <th>Course</th>
                        <th>Assigned At</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="assigned-teacher-list">
                    <?php if (empty($assigned_courses)): ?>
                        <tr>
                            <td colspan="8" style="text-align: center; font-weight: bold;">No assigned courses found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($assigned_courses as $course): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($course['assigned_course_id']); ?></td>
                                <td><?php echo htmlspecialchars($course['school_teacher_id']); ?></td>
                                <td><?php echo htmlspecialchars($course['teacher_name']); ?></td>
                                <td><?php echo htmlspecialchars($course['section']); ?></td>
                                <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                <td><?php echo date("Y-m-d H:i:s", strtotime($course['assigned_at'])); ?></td>
                                <td><button type="button" class="edit-btn" data-id="<?php echo $course['assigned_course_id']; ?>">Edit</button></td>
                                <td><button type="button" class="delete-btn" data-id="<?php echo $course['assigned_course_id']; ?>">Delete</button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="../assets/js/admin.js"></script>
</body>
</html>

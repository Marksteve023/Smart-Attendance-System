<?php

session_start();
include '../config/db.php';


// Validate
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit();
}


// Fetch students from the database
$sql = "SELECT * FROM students ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<?php include 'admin-head.php'; ?>
</head>
<body>

    <!-- Sidebar -->
    <?php include 'admin-sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main container" id="main">
        <h1>Manage Student</h1>

        <div class="students-container">
            
            <!-- Add Student Form -->   
            <div class="addStudent">

                <h2>Add Student</h2>
                
                <form action="process_student.php" method="post" class="addStudent-form" id="addstudent" autocomplete="off">
                    
                    <!-- Student ID -->
                    <div class="input-field">
                        <label for="student_id">Student ID</label>
                        <input type="text" name="student_id" id="student_id" required>
                    </div>

                    <!-- Student Name -->
                    <div class="input-field">
                        <label for="student_name">Full Name</label>
                        <input type="text" name="student_name" id="student_name" required>
                    </div>

                    <!-- RFID ID -->
                    <div class="input-field">
                        <label for="rfid_tag">RFID</label>
                        <input type="text" name="rfid_tag" id="rfid_tag" required pattern="\d{10}" title="Enter a 10-digit RFID ID">
                    </div>

                    <!-- Program Selection -->
                    <div class="input-field">
                        <label for="program">Program</label>
                        <input type="text" id="program" name="program" required>
                    </div>

                    <!-- Year Level -->
                    <div class="input-field">
                        <label for="year_level">Year Level</label>
                        <select name="year_level" id="year_level" required>
                            <option value="" disabled selected>Select Year Level</option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                    </div>

                    <!-- Section Selection -->
                    <div class="input-field">
                        <label for="section">Section</label>
                        <select name="section" id="section" required>
                            <option value="" disabled selected>Select Section</option>
                            <option value="A">Section A</option>
                            <option value="B">Section B</option>
                            <option value="C">Section C</option>
                            <option value="D">Section D</option>
                        </select>
                    </div>

                    <button type="submit" class="save-btn" id="add">Save</button>
                </form>
            </div>

            <!-- Student List -->
            <div class="student-list-container">
                <h2>Student List</h2> 

                <!-- Search Bar -->
                <div class="search-wrapper">
                    <input type="text" id="search-student" placeholder="Search by Name, RFID, Student ID, or Section" class="search-input">
                </div>

                <div class="table-wrapper">
                    <table class="student-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>RFID ID</th>
                                <th>Program</th>
                                <th>Year Level</th>
                                <th>Section</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="student-list">
                            <?php if (empty($students)): ?>
                                <tr>
                                    <td colspan="9" style="text-align: center; font-weight: bold;">No students found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($students as $index => $student): ?>
                                    <tr data-id="<?php echo htmlspecialchars($student['student_id']); ?>">
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                        <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                                        <td><?php echo htmlspecialchars($student['rfid_tag']); ?></td>
                                        <td><?php echo htmlspecialchars($student['program']); ?></td>
                                        <td><?php echo htmlspecialchars($student['year_level']); ?></td>
                                        <td><?php echo htmlspecialchars($student['section']); ?></td>
                                        <td><button type="button" class="edit-btn" onclick="editStudent('<?php echo $student['student_id']; ?>')">Edit</button></td>
                                        <td><button type="button" class="delete-btn" onclick="deleteStudent('<?php echo $student['student_id']; ?>')">Delete</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- JavaScript -->
    <script src="../assets/js/admin.js"></script>
   
    
</body>
</html>

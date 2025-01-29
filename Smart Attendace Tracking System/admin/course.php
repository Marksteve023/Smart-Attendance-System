<!-- course.php -->
<!DOCTYPE html>
   <?php include'admin-head.php';?>
</head>

<body>
    
   <!--=============== SIDEBAR ===============-->
   <?php include'admin-sidebar.php';?>


   
    <!--=============== MAIN ===============-->
   <main class="main container" id="main">
      <h1>Course </h1>

      <div class="createCourse">
        <span>Create Course</span>

        <form action="" method="post"  class="createCourse-form" id="createcourse">
            
            <!-- Course Field -->
            <div class="input-field">
                <label for="course">Course Name</label>
                <input type="text" name="course" id="course" required>
            </div>

            <!--Program-->
            <div class="input-field">
                <label for="program">Program</label>
                <input type="text" name="program" id="program" required>
            </div>

            <!--Section-->
            <div class="input-field">
                <label for="program">Section</label>
                <input type="text" name="program" id="program" required>
            </div>

            <button type="submit" class="save-btn" id="save">Save</button>
        </form>
    </div>



      </div>
      
   </main>
      
   <!--=============== MAIN JS ===============-->
   <script src="/assets/js/admin.js"></script>

   </body>
</html>
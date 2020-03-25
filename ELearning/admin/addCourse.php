<!DOCTYPE html>
<html>
<head>
    <title>Admin Home</title>
</head>

<Link rel="stylesheet" href="../css/bootstrap.min.css"></Link>
<Link rel="stylesheet" href="../css/dashboard.css"></Link>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery1.js"></script>

<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elearning";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection faild" . $conn->connect_error);
}

$sql_programs = "SELECT * FROM Programs WHERE id = $_SESSION[program_id]";
$programs = $conn->query($sql_programs);
if($programs != TRUE){
    echo "Unable to query from table Programs" . $conn->error;
}

$sql_lecturers = "SELECT * FROM Lecturers WHERE program_id = $_SESSION[program_id]";
$lecturers = $conn->query($sql_lecturers);
if($lecturers != TRUE) {
    echo "Unable to query Lecturers table!";
}


$course_nameErr = $programErr = $yearErr = $semesterErr = $lecErr = "";

if(isset($_POST["submit"])){

    if(empty($_POST["course_name"])){
        $course_nameErr = "Course is required!";
    }
    else {
        $course_name = testInput($_POST["course_name"]);
    }
    
    if(empty($_POST["program"])){
        $programErr = "Program is required!";
    }
    else {
        $program = testInput($_POST["program"]);
    }

    if(empty($_POST["year"])){
        $yearErr = "Year is required!";
    }
    else {
        $year = testInput($_POST["year"]);
    }

    if(empty($_POST["semester"])){
        $semesterErr = "Semester is required!";
    }
    else {
        $semester = testInput($_POST["semester"]);
    }

    if(empty($_POST["lecturer"])){
        $lecErr = "Lecture is required!";
    }
    else {
        $lec = testInput($_POST["lecturer"]);
    }

    $sql = "INSERT INTO Courses(course_name, program_id, year, semester, lec_id)
        VALUES('$course_name', '$program', '$year', '$semester', '$lec')";
    $addCourse = $conn->query($sql);
    if($addCourse != TRUE){
        echo "Unable to add course:" . $conn->error;
    }
    else{
        echo "<div class='alert alert-success pull-right' style='width:30%' align='center'>
        Course added successfully!!
        </div>";
    }
}

function testInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<body>

    

    <?php require "adminLayout.php" ?>

    <div class="container-fluid">
      <div class="row">
        <?php require "adminSidebar.php" ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Add Course</h1>
            <div class="form">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-group">
                    <div class="form-group">
                        <label for="course_name">Name of course</label>
                        <input type="text" name="course_name" id="course_name" class="form-control" required
                        placeholder="Course Name">
                    </div>
                    <div class="form-group">
                        <label for="program">Program</label>
                        <select name="program" id="program" class="form-control">
                            <?php 
                                foreach($programs as $program){
                                    echo "<option value='" .$program['id']. "'>
                                        " . $program['program_name'] . "
                                    </option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lecturer">Lecturer</label>
                        <select name="lecturer" id="lecturer" class="form-control">
                            <?php 
                                foreach($lecturers as $lecturer){
                                    echo "<option value='" .$lecturer['id']. "'>
                                        " . $lecturer['title']. " " . $lecturer['firstname'] ." ". $lecturer['lastname'] . "
                                    </option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">Year</label>
                        <select name="year" id="year" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select name="semester" id="semester" class="form-control">
                            <option value="1">One</option>
                            <option value="2">Two</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary" value="Add Course">
                    </div>
                </form>
            </div>
          
        </div>
      </div>
    </div>


    <script>
        if(window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  

</body>
</html>
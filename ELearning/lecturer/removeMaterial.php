<!DOCTYPE html>
<html>
<head>
    <title>Lecturer Home</title>
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

$sql = "SELECT * FROM Course_materials WHERE lec_id=$_SESSION[id]";
$course_materials = $conn->query($sql);
if($course_materials != TRUE){
    echo "Unable to query from table Course_materials" . $conn->error;
}



?>


<body>

    

    <?php require "lecturerLayout.php" ?>

    <div class="container-fluid">
      <div class="row">
        <?php require "lecturerSidebar.php" ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Remove Course Material</h1>
            <div>
                <table class="table table-striped">
                    <thead>
                        <th>Course</th>
                        <th>Material Name</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php

                            if(isset($_POST["remove"])){
                                $material_id = $_POST['material_id'];
                                $sql1 = "DELETE FROM Course_materials WHERE id='$material_id'";
                                $delete_material = $conn->query($sql1);
                                if($delete_material != TRUE){
                                    echo "Unable to delete material!";
                                }
                            }

                            foreach($course_materials as $material){
                                $sql_course = "SELECT * FROM Courses WHERE id=$material[course_id]";
                                $course = $conn->query($sql_course);
                                $course = mysqli_fetch_assoc($course);
                                if($course != TRUE){
                                    echo "Unable to query for course!";
                                }
                                echo "
                                    <tr>
                                        <td>$course[course_name]</td>
                                        <td>$material[material_name]</td>
                                        <td>
                                            <form method='post'>
                                                <button type='submit' name='remove' class='btn btn-danger'>
                                                    <span class='glyphicon glyphicon-trash'></span>
                                                </button>
                                                <input type='hidden' name='material_id' value='$material[id]'/>
                                            </form>
                                        </td>
                                    </tr>
                                ";
                            }
                        ?>
                    </tbody>
                </table>
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
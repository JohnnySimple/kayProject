<!DOCTYPE html>
<html>
<head>
    <title>Student Home</title>

    <Link rel="stylesheet" src="../css/bootstrap.min.css"></Link>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery1.js"></script>
</head>
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elearning";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed:" . $conn->connect_error);
}

$sql = "SELECT * FROM Course_materials WHERE year=$_SESSION[year]";
$slides = $conn->query($sql);

if($slides != TRUE){
    echo "Unable to query course materials!";
}

if(isset($_POST['read_material'])){
    $filePath =  '../courseMaterials/' . $_POST['material'];
    if(!file_exists($filePath)) {
        echo "The file $filePath does not exist!";
        die();
    }

    $filename = $_POST['material'];
    $FileType = pathinfo($filePath, PATHINFO_EXTENSION);
    

    header('Content-type:application/pdf');
    header('Content-Disposition: inline; filename="' .$filename. '"');
    header('Content-Transfer-Encoding:binary');
    header('Accept-Ranges:bytes');
    @readfile($filePath);
}

?>
<body>
    <?php require "studentLayout.php"; ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
        <?php require "studentSidebar.php" ?>
        </div>
        
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>
            <div>
                <?php 
                    // foreach($slides as $slide) {
                    //     $sql_program = "SELECT program_id, course_name FROM Courses WHERE id=$slide[course_id]";
                    //     $program = $conn->query($sql_program);
                    //     $program = $program->fetch_assoc();
                    //     if($program != TRUE) {
                    //         echo "Unable to query Courses table!";
                    //     }

                    //     if($program['program_id'] == $_SESSION['program_id']) {
                    //         echo "
                    //         <p>$program[course_name]<p>
                    //         <p>$slide[material_name]</p>";
                    //     }
                        
                    // }
                ?>
            </div>
            <div>
                <ul class="nav nav-tabs nav-justified">
                    <li><a data-toggle="tab" href="#home">1st Sem</a></li>
                    <li><a data-toggle="tab" href="#menu">2nd Sem</a></li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                    <table class="table table-striped">
                        <thead>
                            <th>Course</th>
                            <th>Material</th>
                            <th>Action</th>
                        </thead>
                        <?php 

                            foreach($slides as $slide) {
                                $sql_program = "SELECT program_id, course_name, semester FROM
                                 Courses WHERE id=$slide[course_id]";
                                $program = $conn->query($sql_program);
                                $program = $program->fetch_assoc();
                                if($program != TRUE) {
                                    echo "Unable to query Courses table!";
                                }


                                if($program['program_id'] == $_SESSION['program_id'] && $program['semester'] == 1) {
                                    echo "
                                    <tr>
                                        <td>$program[course_name]</td>
                                        <td>$slide[material_name]</td>
                                        <td>
                                            <a href='../courseMaterials/$slide[material_name]'>
                                                <button name='download' class='btn btn-success'>
                                                    <span class='glyphicon glyphicon-download-alt'></span>
                                                </button>
                                            </a>
                                            <form method='post'>
                                            <button name='read_material' class='btn btn-primary'>
                                                <span>view</span>
                                            </button>
                                            <input type='hidden' name='material' value='$slide[material_name]' />
                                            </form>
                                        </td>
                                    </tr>
                                        ";
                                }
                                
                            }
                        ?>
                    </table>
                    </div>
                    <div id="menu" class="tab-pane fade">
                    <table class="table table-striped">
                        <thead>
                            <th>Course</th>
                            <th>Material</th>
                            <th>Action</th>
                        </thead>
                        <?php 
                                foreach($slides as $slide) {
                                    $sql_program = "SELECT program_id, course_name, semester FROM
                                    Courses WHERE id=$slide[course_id]";
                                    $program = $conn->query($sql_program);
                                    $program = $program->fetch_assoc();
                                    if($program != TRUE) {
                                        echo "Unable to query Courses table!";
                                    }

                                    if($program['program_id'] == $_SESSION['program_id'] && $program['semester'] == 2) {
                                        echo "
                                        <tr>
                                            <td>$program[course_name]</td>
                                            <td>$slide[material_name]</td>
                                            <td>
                                                <a href='../courseMaterials/$slide[material_name]'>
                                                    <button name='download2' class='btn btn-success'>
                                                        <span class='glyphicon glyphicon-download-alt'></span>
                                                    </button>
                                                </a>
                                                <button class='btn btn-primary'>
                                                    <span>view</span>
                                                </button>
                                            </td>
                                        </tr>
                                        ";
                                    }
                                    
                                }
                            ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

    <script>
        if(window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>
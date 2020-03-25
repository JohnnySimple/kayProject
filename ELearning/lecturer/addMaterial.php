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

$sql_courses = "SELECT * FROM Courses WHERE lec_id = $_SESSION[id]";
$courses = $conn->query($sql_courses);
if($courses != TRUE){
    echo "Unable to query from table Courses" . $conn->error;
}

$yearErr = $courseErr = $fileErr = "";

if(isset($_POST["submit"])) {
    $target_dir = "../courseMaterials/";
    $target_dir = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $FileType = pathinfo($target_dir, PATHINFO_EXTENSION);

    if(empty($_POST["year"])) {
        $yearErr = "Year is required";
    } else {
        $year = $_POST["year"];
    }

    if(empty($_POST["course"])) {
        $courseErr = "Course is required";
    } else {
        $course = $_POST["course"];
    }


    // check if image file is a real image or not
    // $check = getimagesize($_FILES["file"]["tmp_name"]);
    // if($check !== false){
    //     // echo "File is an image - " . $check["mime"] . ".";
    //     $uploadOk = 1;
    // } else {
    //     // echo "File is not an image.";
    //     $uploadOk = 0;
    // }

    // check if file already exists
    // if(file_exists($target_file)){
    //     echo "Sorry, file already exist!";
    //     $uploadOk = 0;
    // }

    // check file size
    // if(filesize($_FILES["file"]["size"] > 5000000)){
    //     echo "Sorry, your file is too large!";
    //     $uploadOk = 0;
    // }

    // allow certain file formats
    if($FileType != "pdf" && $FileType != "docx" && $FileType != "txt"
        && $FileType != "pptx" && $FileType != "ppt" && $FileType != "jpg"
        && $FileType != "png" && $FileType != "jpeg" && $FileType != "xlsx"){
            echo "Sorry, only pdf, docx, txt, pptx, ppt, jpg, png, jpeg & xlxs are allowed!";
            $uploadOk = 0;
    }

    // check if uplaodOk is set to 0 by an error
    // if($uploadOk == 0){
    //     echo "Sorry, your file was not uploaded!";
    //     // try to upload the file if everything is ok
    // }
    //  else {
    //     if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    //         echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded!";
    //     } else {
    //         echo "Sorry, there was an error uploading your file!";
    //     }
    // }

    if($uploadOk == 0){
        echo "Sorry, your file was not uploaded!";
    }
    else {
        if(move_uploaded_file($_FILES['file']['tmp_name'], $target_dir)){
            echo "The file " . basename($_FILES['file']['name']) . " is uploaded";
        }
        else {
            echo "Problem uploading file";
        }

        // $fileName = $_FILES["file"]["name"]."\n";
        $fileName = basename($_FILES['file']['name']);



        $sql = "INSERT INTO Course_materials(material_name, year, lec_id, course_id)
        VALUES('$fileName', '$year', '$_SESSION[id]', '$course')";

        if($conn->query($sql) == true) {
            echo "<div class='alert alert-success pull-right' style='width:30%' align='center'>
            Course material added successfully!
            </div>";
        } else {
            echo "Unable to add course material: " . $conn->error;
        }
    }
    
    

    
}

?>


<body>

    

    <?php require "lecturerLayout.php" ?>

    <div class="container-fluid">
      <div class="row">
        <?php require "lecturerSidebar.php" ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Add Course Material</h1>
          <div class="form">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                 class="form-group" enctype="multipart/form-data">
                    
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
                        <label for="course">Course</label>
                        <select name="course" id="course" class="form-control">
                            <?php 
                            foreach($courses as $course){
                                echo "<option value='" .$course['id']. "'>
                                    " . $course['course_name'] . "
                                </option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary" value="Upload File">
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
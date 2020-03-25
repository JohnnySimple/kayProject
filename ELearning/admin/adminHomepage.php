<!DOCTYPE html>
<html>
<head>
    <title>Admin Home</title>
</head>

<Link rel="stylesheet" href="../css/bootstrap.min.css"></Link>
<Link rel="stylesheet" href="../css/dashboard.css"></Link>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery1.js"></script>

<style>
  .placeholder {
    /* border:1px solid #ccc; */
    background-color: #1a6bd4;
    height: 100px;
    border-radius: 10px;
    margin: 0px 10px 0px 10px;
    color: #fff;
  }
  .num-of-items {
    margin-top: 15px;
  }
</style>
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


$sql = "SELECT * FROM Lecturers WHERE admin=0 AND program_id = $_SESSION[program_id]";
$lecturers = $conn->query($sql);

$count_lecturers = mysqli_num_rows($lecturers);

if($lecturers != TRUE){
    echo "Unable to query Lecturers!";
}

// querying for students of logged in lecturer
$sql2 = "SELECT * FROM Students WHERE program_id = $_SESSION[program_id]";
$students = $conn->query($sql2);

$count_students = mysqli_num_rows($students);

if($students != TRUE){
  echo "Unable to query Students!";
}

?>


<body>

    

    <?php require "adminLayout.php" ?>

    <div class="container-fluid">
      <div class="row">
        <?php require "adminSidebar.php" ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>

          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">
              <div class="num-of-items">
                <?php echo $count_lecturers; ?>
              </div>
              <h4>Lecturers</h4>
              <!-- <span class="text-muted">Something else</span> -->
            </div>
            <div class="col-xs-6 col-sm-3 placeholder" style="background-color: #f3e504;">
              <div class="num-of-items">
                <?php echo $count_students; ?>
              </div>
              <h4>Students</h4>
              <!-- <span class="text-muted">Something else</span> -->
            </div>
          </div>

        </div>
      </div>
    </div>

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
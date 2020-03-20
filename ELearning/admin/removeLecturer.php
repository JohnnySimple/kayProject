<!DOCTYPE html>
<html>
<head>
    <title>Admin Home</title>
</head>

<Link rel="stylesheet" href="../css/bootstrap.min.css"></Link>
<Link rel="stylesheet" href="../css/dashboard.css"></Link>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery1.js"></script>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elearning";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection faild" . $conn->connect_error);
}

$sql = "SELECT * FROM Lecturers WHERE admin=0";
$lecturers = $conn->query($sql);

if($lecturers != TRUE){
    echo "Unable to query Lecturers!";
}


?>


<body>

    

    <?php require "adminLayout.php" ?>

    <div class="container-fluid">
      <div class="row">
        <?php require "adminSidebar.php" ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Remove Lecturer</h1>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            if(isset($_POST["remove"])){
                                $lecturer_id = $_POST['lecturer_id'];
                                $sql1 = "DELETE FROM Lecturers WHERE id='$lecturer_id'";
                                $delete_lecturer = $conn->query($sql1);
                                if($delete_lecturer != TRUE){
                                    echo "Unable to delete lecturer!";
                                }
                            }

                            foreach($lecturers as $lecturer){
                                echo "
                                    <tr>
                                        <td>$lecturer[title]</td>
                                        <td>$lecturer[firstname]</td>
                                        <td>$lecturer[lastname]</td>
                                        <td>$lecturer[email]</td>
                                        <td>$lecturer[course]</td>
                                        <td>
                                            <form method='post'>
                                                <button type='submit' name='remove' class='btn btn-danger'>
                                                    <span class='glyphicon glyphicon-trash'></span>
                                                </button>
                                                <input type='hidden' name='lecturer_id' value='$lecturer[id]'/>
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
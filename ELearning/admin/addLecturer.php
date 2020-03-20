<!DOCTYPE html>
<html>
<head>
    <title>Admin Home</title>
</head>

<Link rel="stylesheet" href="../css/bootstrap.min.css"></Link>
<Link rel="stylesheet" href="../css/dashboard.css"></Link>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery1.js"></script>

<style>

/* form .form-group{
    float:left;
} */
/* .form-group{
    width:50%;
    border:1px solid #ccc;
}
.form {
    border:1px solid #ccc;
} */


</style>


<?php
// session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elearning";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed:" . $conn->connect_error);
}

$isadmin = "";

$titleErr = $firstnameErr = $lastnameErr = $usernameErr = $emailErr =
 $passwordErr = $confirm_passwordErr = $programErr = $courseErr = $adminErr = "";

$sql_programs = "SELECT * FROM Programs";
$programs = $conn->query($sql_programs);
if($programs != TRUE){
    echo "Unable to query from table Programs" . $conn->error;
}


if(isset($_POST["submit"])){
    
    if(empty($_POST["title"])){
        $titleErr = "Title is required!";
    }
    else {
        $title = test_input($_POST["title"]);
    }

    if(empty($_POST["firstname"])){
        $firstnameErr = "First name is required!";
    }
    else {
        $firstname = test_input($_POST["firstname"]);
    }

    if(empty($_POST["lastname"])){
        $lastnameErr = "Last name is required!";
    }
    else {
        $lastname = test_input($_POST["lastname"]);
    }

    if(empty($_POST["username"])){
        $usernameErr = "Username is required!";
    }
    else {
        $username = test_input($_POST["username"]);
    }

    if(empty($_POST["program"])){
        $programErr = "Program is required!";
    }
    else {
        $program = test_input($_POST["program"]);
    }

    if(empty($_POST["email"])) {
        $emailErr = "Email is required!";
    } else {
        $email = test_input($_POST["email"]);
    }

    if(empty($_POST["course"])){
        $courseErr = "Course is required!";
    }
    else {
        $course = test_input($_POST["course"]);
    }

    if(empty($_POST["admin"])){
        $adminErr = "Admin is required!";
    }
    else {
        $isadmin = test_input($_POST["admin"]);
    }

    if(empty($_POST["password"])) {
        $passwordErr = "Password is required!";
    } else {
        $password = test_input($_POST["password"]);
    }

    if(empty($_POST["confirm_password"])) {
        $confirm_passwordErr = "Confirm password is required!";
    } elseif($_POST["confirm_password"] !== $password) {
        $confirm_passwordErr = "Your password is not matching!";
    } else {
        $confirm_pass = test_input($_POST["confirm_password"]);
        
        $sql = "INSERT INTO Lecturers (title, firstname, lastname, username, email, password, program_id, course, admin)
        VALUES('$title', '$firstname', '$lastname', '$username', '$email', '$password', '$program', '$course', '$isadmin')";

        if($conn->query($sql)) {
            echo "<div class='alert alert-success pull-right' style='width:30%' align='center'>
            Account created for " . $firstname ." " . $lastname . " successfully!!
            </div>";
        } else {
            echo "Unable to create account:" . $conn->error;
        }
    }
}

function test_input($data) {
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
          <h1 class="page-header">Add Lecturer</h1><?php echo $isadmin; ?>
          <div class="form">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-group">
                    <div class="form-group col-md-6">
                        <label for="title">Title</label>
                        <select name="title" id="title" class="form-control">
                            <option value="Mr.">Mr.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Mad.">Mad.</option>
                            <option value="Dr.">Dr.</option>
                            <option value="Prof.">Prof.</option>
                            <option value="Emeritus.">Emeritus.</option>

                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fname">First Name</label>
                        <input type="text" name="firstname" id="fname" class="form-control"
                        required placeholder="First Name">
                        <span class="error"><?php echo $firstnameErr; ?></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lastname" id="lname" class="form-control"
                        required placeholder="Last Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control"
                        required placeholder="Username">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                        required placeholder="Email">
                    </div>
                    <div class="form-group col-md-6">
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
                    <div class="form-group col-md-6">
                        <label for="course">Course</label>
                        <select name="course" id="course" class="form-control">
                            <option value="Circuit Theory">Circuit Theory</option>
                            <option value="Introduction to c++">Introduction to c++</option>
                            <option value="Assembly language">Assembly language</option>
                            <option value="Information systems">Information systems</option>
                            
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="admin">Admin</label>
                        <select name="admin" id="admin" class="form-control">
                            <option value="0">NO</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                        required placeholder="Password">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                        required placeholder="Confirm Password">
                    </div>
                    <br>
                    <div class="form-group col-md-6">
                        <input type="submit" name="submit" class="btn btn-primary" value="Add">
                    </div>
                </form>
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
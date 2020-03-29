<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<Link rel="stylesheet" href="../css/bootstrap.min.css"></Link>
<Link rel="stylesheet" href="css/styles.css"></Link>
<Link rel="stylesheet" href="css/animate.css"></Link>
<Link rel="stylesheet" href="css/all.css"></Link>
<Link rel="stylesheet" href="css/fontawesome.css"></Link>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery1.js"></script>
<script src="js/brands.js"></script>
<script src="js/solid.js"></script>

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

$usernameErr = $passwordErr = "";

if(isset($_POST["submit"])){
    if(empty($_POST["username"])){
        $usernameErr = "Username is required!";
    } else {
        $username = $_POST["username"];
    }
    if(empty($_POST["password"])){
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }

    
    $sql = "SELECT * FROM Students WHERE username='$username' AND password='$password'";
    $student = $conn->query($sql);
    $stud_count = mysqli_num_rows($student);

    $sql1 = "SELECT * FROM Lecturers WHERE username='$username' AND password='$password'";
    $lecturer = $conn->query($sql1);
    $lec_count = mysqli_num_rows($lecturer);

    if($stud_count){
        $sql2 = "SELECT * FROM Students WHERE username='$username'";
        $isstudent = $conn->query($sql2);
        $isstudent_res = mysqli_fetch_assoc($isstudent);
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $isstudent_res['id'];
        $_SESSION["firstname"] = $isstudent_res['firstname'];
        $_SESSION["lastname"] = $isstudent_res['lastname'];
        $_SESSION["username"] = $username;
        $_SESSION['program_id'] = $isstudent_res['program_id'];
        $_SESSION['course'] = $isstudent_res['course'];
        $_SESSION['year'] = $isstudent_res['year'];
        header("location: student/studentHomepage.php");
    }
    elseif($lec_count){
        $sql3 = "SELECT * FROM Lecturers WHERE username='$username'";
        $isadmin = $conn->query($sql3);
        $isadmin_res = mysqli_fetch_assoc($isadmin);
        if($isadmin_res['admin'] == 1){
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $isadmin_res['id'];
            $_SESSION["username"] = $username;
            $_SESSION["title"] = $isadmin_res['title'];
            $_SESSION["firstname"] = $isadmin_res['firstname'];
            $_SESSION["lastname"] = $isadmin_res['lastname'];
            $_SESSION["program_id"] = $isadmin_res['program_id'];
            $_SESSION["course"] = $isadmin_res['course'];
            header("location: admin/adminHomepage.php");
        }
        else{
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $isadmin_res['id'];
            $_SESSION["username"] = $username;
            $_SESSION["title"] = $isadmin_res['title'];
            $_SESSION["firstname"] = $isadmin_res['firstname'];
            $_SESSION["lastname"] = $isadmin_res['lastname'];
            $_SESSION["program_id"] = $isadmin_res['program_id'];
            $_SESSION["course"] = $isadmin_res['course'];
            header("location: lecturer/lecturerHomepage.php");
        }
    }
    else {
        echo "<div class='container alert alert-danger' align='center' style='width:30%'>
                    Username or password incorrect!
                </div>";
    }
}

?>
<style>
    .form {
        color: #fff;
        margin-top: 150px;
    }
</style>
<body>
<?php require "homeNavbar.php" ?>

<div class="container home-banner">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-3">
            <div class="form">
                <h2 align="center">Login</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required
                        placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required
                        placeholder="Password">
                    </div>
                    <div class="form-group" align="center">
                        <input type="submit" name="submit" class="btn btn-success" value="Submit">
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-5"></div>
    </div>
</div>
<script>
if(window.history.replaceState){
    window.history.replaceState(null, null, window.location.href);
}
</script>
</body>
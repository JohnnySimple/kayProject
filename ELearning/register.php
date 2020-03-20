<!DOCTYPE html>
<html>
<head>
    <title>Register Page</title>
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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elearning";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed:" . $conn->connect_error);
}

$firstnameErr = $lastnameErr = $usernameErr = $referenceErr = $emailErr =
 $passwordErr = $confirm_passwordErr = $programErr = $yearErr = "";

if(isset($_POST["submit"])){

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

    if(empty($_POST["reference"])){
        $referenceErr = "Reference number is required!";
    }
    else {
        $reference = test_input($_POST["reference"]);
    }

    if(empty($_POST["program"])){
        $programErr = "Program is required!";
    }
    else {
        $program = test_input($_POST["program"]);
    }

    if(empty($_POST["year"])){
        $yearErr = "Year is required!";
    }
    else {
        $year = test_input($_POST["year"]);
    }

    if(empty($_POST["email"])) {
        $emailErr = "Email is required!";
    } else {
        $email = test_input($_POST["email"]);
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
        
        $sql = "INSERT INTO Students (firstname, lastname, username, reference, email, password, program_id, year)
        VALUES('$firstname', '$lastname', '$username', '$reference', '$email', '$password', '$program', '$year')";

        if($conn->query($sql)) {
            echo "<div class='alert alert-success' style='width:30%' align='center'>
            Account created for " . $firstname ." " . $lastname . " successfully!!
            </div>";
        } else {
            echo "Unable to create account:" . $conn->error;
        }
    }
}

$sql_programs = "SELECT * FROM Programs";
$programs = $conn->query($sql_programs);
if($programs != TRUE){
    echo "Unable to query from table Programs" . $conn->error;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>


<body>
    
<?php require "homeNavbar.php" ?>

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="form">
                <h2>Register</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-group">
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
                        <label for="reference">Reference No.</label>
                        <input type="text" name="reference" id="reference" class="form-control"
                        required placeholder="Reference Number">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                        required placeholder="Email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="program">Program of study</label>
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
                   
                    <div class="form-group col-md-6">
                        <input type="submit" name="submit" class="btn btn-primary">
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
</body>
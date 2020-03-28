<!DOCTYPE html>
<html>
<head>
    <title>Admin Home</title>

    <Link rel="stylesheet" src="../css/bootstrap.min.css"></Link>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery1.js"></script>
</head>
<style>
.error {
    color:red;
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
    die("Connection failed:" . $conn->connect_error);
}

// query for details of logged in user
$sql_user = "SELECT * FROM Lecturers WHERE id=$_SESSION[id]";
$loggedin_user = $conn->query($sql_user);
if($loggedin_user != TRUE) {
    echo "Unable to query Students table: " . $conn->error;
}
$loggedin_user = $loggedin_user->fetch_assoc();


$firstnameErr = $lastnameErr = $usernameErr = $emailErr = $titleErr =
 $old_passwordErr = $new_passwordErr = $confirm_passwordErr = $programErr = "";



// querying for all programs in database
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

    if(empty($_POST["old_password"])) {
        $old_passwordErr = "Password is required!";
    } else {
        $old_password = test_input($_POST["old_password"]);
    }

    if(empty($_POST["new_password"])) {
        $new_passwordErr = "Please enter new password!";
    } else {
        $new_password = test_input($_POST["new_password"]);
    }

    if($_POST["old_password"] !== $loggedin_user["password"]) {
        $old_passwordErr = "Your old password is incorrect!!";
    } else {
        if(empty($_POST["confirm_password"])) {
            $confirm_passwordErr = "Confirm password is required!";
        } elseif($_POST["confirm_password"] !== $new_password) {
            $confirm_passwordErr = "Your password is not matching!";
        } else {
            $confirm_pass = test_input($_POST["confirm_password"]);

            $sql = "UPDATE Lecturers SET title='$title', firstname='$firstname', lastname='$lastname', username='$username', 
             email='$email', password='$new_password', program_id='$program'
            WHERE id=$loggedin_user[id]";
            if($conn->query($sql)) {
                echo "<div class='alert alert-success pull-right' style='width:30%' align='center'>
                Account has been updated successfully!! Please logout and log back in with your new credentials.
                </div>";
            } else {
                echo "Unable to update account:" . $conn->error;
            }
        }
    }

    

}

?>
<body>
    <?php require "adminLayout.php"; ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
        <?php require "adminSidebar.php" ?>
        </div>
        
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Edit Account</h1>    
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
                        required placeholder="First Name" value=<?php echo $loggedin_user['firstname'] ?>>
                        <span class="error"><?php echo $firstnameErr; ?></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lastname" id="lname" class="form-control"
                        required placeholder="Last Name" value=<?php echo $loggedin_user['lastname'] ?>>
                        <span class="error"><?php echo $old_passwordErr; ?></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control"
                        required placeholder="Username" value=<?php echo $loggedin_user['username'] ?>>
                        <span class="error"><?php echo $old_passwordErr; ?></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                        required placeholder="Email" value=<?php echo $loggedin_user['email'] ?>>
                        <span class="error"><?php echo $old_passwordErr; ?></span>
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
                        <label for="old_password">Old Password</label>
                        <input type="password" name="old_password" id="old_password" class="form-control"
                        required placeholder="Old Password">
                        <span class="error"><?php echo $old_passwordErr; ?></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control"
                        required placeholder="New Password">
                        <span class="error"><?php echo $old_passwordErr; ?></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                        required placeholder="Confirm New Password">
                        <span class="error"><?php echo $old_passwordErr; ?></span>
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
</html>
<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elearning";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed:" . $conn->connect_error);
}


$sql1 = "CREATE TABLE Programs(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    program_name VARCHAR(60) NOT NULL
)";

$sql2 = "INSERT INTO Programs(program_name)
    VALUES('Bsc.Computer Science')";

$sql3 = "CREATE TABLE Lecturers(
    id Int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(10) NOT NULL,
    firstname VARCHAR(60) NOT NULL, 
    lastname VARCHAR(60) NOT NULL,
    username VARCHAR(60) NOT NULL,
    email VARCHAR(60),
    password VARCHAR(60) NOT NULL,
    program_id INT(10) UNSIGNED NOT NULL,
    course VARCHAR(60),
    admin BOOLEAN DEFAULT FALSE,
    reg_date TIMESTAMP,
    FOREIGN KEY(program_id) REFERENCES Programs(id)
)";

$sql4 = "CREATE TABLE Students(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(60) NOT NULL,
    lastname VARCHAR(60) NOT NULL,
    username VARCHAR(60) NOT NULL,
    reference INT(10) NOT NULL,
    email VARCHAR(60),
    password VARCHAR(60) NOT NULL,
    program_id INT(10) UNSIGNED NOT NULL,
    year INT(10) UNSIGNED NOT NULL,
    reg_date TIMESTAMP,
    FOREIGN KEY(program_id) REFERENCES Programs(id)
)";

$sql5 = "CREATE TABLE Lecturer_Students(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lec_id INT(10) UNSIGNED NOT NULL,
    stud_id INT(10) UNSIGNED NOT NULL,
    FOREIGN KEY(lec_id) REFERENCES Lecturers(id),
    FOREIGN KEY(stud_id) REFERENCES Students(id)
)";


$sql6 = "CREATE TABLE Courses(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(60) NOT NULL,
    program_id INT(10) UNSIGNED NOT NULL,
    year INT(10) UNSIGNED NOT NULL,
    semester INT(10) UNSIGNED NOT NULL,
    FOREIGN KEY(program_id) REFERENCES Programs(id)
)";

$sql7 = "CREATE TABLE Course_materials(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    material_name VARCHAR(60) NOT NULL,
    year INT(10) UNSIGNED NOT NULL,
    lec_id INT(10) UNSIGNED NOT NULL,
    course_id INT(10) UNSIGNED NOT NULL,
    FOREIGN KEY(lec_id) REFERENCES Lecturers(id),
    FOREIGN KEY(course_id) REFERENCES Courses(id)
)";

$sql8 = "INSERT INTO Lecturers(title, firstname, lastname, username, email, password, program_id, admin)
    VALUES('Dr.', 'Amoabeng', 'Yeboah', 'kay', 'kay@gmail.com', 'kay', 1, 1)";


if($conn->query($sql1) && $conn->query($sql2) && $conn->query($sql3) && $conn->query($sql4) &&
    $conn->query($sql5) && $conn->query($sql6) && $conn->query($sql7) && $conn->query($sql8) === TRUE){
        echo "Tables created successfully";
    }
else {
    echo "Error creating tables:" . $conn->error;
}

?>
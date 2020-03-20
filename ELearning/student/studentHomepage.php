<!DOCTYPE html>
<html>
<head>
    <title>Student Home</title>
</head>
<?php
session_start();
?>
<body>
    welcome student: <?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Lecturer Home</title>
</head>
<?php
session_start();
?>
<body>
    welcome lecturer: <?php echo $_SESSION["title"] ." ". $_SESSION["firstname"] ." ". $_SESSION["lastname"]; ?>
</body>
</html>
<!DOCTYPE html>
<!-- Kevin -->
<html>
<title>Logout</title>

<?php
session_start();
session_destroy();
echo "You have logged out";
  header("refresh: 2; homepage.php");
?>

</html>



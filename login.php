<!DOCTYPE html>
<html>
<!--Kevin Li-->
<?php
session_start();
include "connectdb.php";

if(isset($_SESSION["UserID"])) {
	echo "You are already logged in. You will be redirected in 3 seconds \n";
	  header("refresh: 3; homepage.php");
}
else if ($stmt = $mysqli->prepare("select pid,fname from person where pid= ? and passwd = ?")) {
	 $UID = $_POST["id"];
	 $UPass = md5($_POST["pass"]);
      $stmt->bind_param("ss", $UID, $UPass);
	  $stmt->execute();
	  $stmt->bind_result($userPID,$userName);
	  
	  if($stmt->fetch()){
		  $_SESSION["UserID"] = $userPID;
		 $_SESSION["REMOTE_ADDR"] = $_SERVER["REMOTE_ADDR"];
		  
		  echo "You have successfully logged in. You will be redirected in 3 seconds";
		   
			$_SESSION["error"] = 0;
		   header("refresh: 3; homepage.php");
	  }
	
	else{
		echo "Either the ID or password was incorrect. Try again";

			$_SESSION["error"] = 1;	
	header("refresh: 2; login_html.php");
	
	}
	  $stmt->close(); 

}
	  $mysqli->close(); 
 

 
?>

</html>
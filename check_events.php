<!DOCTYPE html>
<html>
<!--Kevin Li-->


<!-- Check club events -->
<html>
<body>

<h1>Checking club events</h1><br>


<?php
session_start();
include "connectdb.php";

if(!isset($_SESSION["UserID"])) {
	echo "You are not logged in. You must be signed in to sign up for an event. Redirecting to login... \n";
	  header("refresh: 3; login_html.php");
}

else{
if($stmt = $mysqli->prepare("select pid,clubid from role_in where pid = ? and role = ?")){
	
	$myID = $_SESSION["UserID"];
	$Crole = "Admin"; 
	$stmt->bind_param("ss",$myID,$Crole);
	$stmt->execute();
	$stmt->bind_result($Member,$club);
	if($stmt->fetch()){
		echo "You are an admin therefore you can view this page <br>";
		$stmt->close();
			if($stmt = $mysqli->prepare("select event.eid,event.ename,event.sponsored_by 
				from role_in join event where pid = ? and role = ? and role_in.clubid = event.sponsored_by")){
	
				$stmt->bind_param("ss",$myID,$Crole);
				$stmt->execute();
				$stmt->bind_result($eid,$ename,$spon);
				$eventArray = array();
	
	// Found all the eid in which user is the admin of the club
	while($stmt->fetch()){
		$eventArray[$ename] = $eid;
		echo "<br>Person with id:$myID is an admin for event: $eid ";
	}
	echo "<br><br>";
	$stmt->close();
	}
	
foreach($eventArray as $x => $x_value) {
	if($stmt = $mysqli->prepare("select count(pid) from sign_up where eid = ? ")){
	$stmt->bind_param("i",$x_value);
	$stmt->execute();
	$stmt->bind_result($count);
	$stmt->fetch();
	$stmt->close();
	}
	echo "<br>The name of the event that you are an admin for is: " . $x . ", with event id = " . $x_value . " and a total count = " . $count;
    echo "<br>";
}
		
		}
	
	else{
		echo "This page is for admin's only";
		echo "You will be redirected to the homepage...";
		$stmt->close();
		$_SESSION["error"] = 1;
		header("refresh: 3; homepage.php");
		}		
		}
}
	$_SESSION["error"] = 0;
  $mysqli->close();
 ?>

</body>
<p>	Return to <a href="homepage.php">Homepage <a/>
</p>
</html>
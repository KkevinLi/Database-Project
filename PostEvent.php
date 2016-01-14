<!DOCTYPE html>
<html>
<!--Kevin Li-->
<!-- Post new events -->
<html>
<body>

<h1>Posting New Club Events</h1><br>


<?php
include "connectdb.php";

if(!isset($_SESSION["UserID"])) {
	echo "You are not logged in. You must be signed in to sign up for an event. Redirecting to login... \n";
	  header("refresh: 3; login.php");
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
		
		$a = $_POST["EName"];
		$b = $_POST["EDate"];
		$d = $_POST["EDes"];
		$e = $_POST["ELoc"];
		$f = $_POST["ESpon"];
		$g = $_POST["EPub"];
		$MaxE = 1;	
	if(!isset($a,$d,$b,$e,$g,$f)) {
		echo "Some inputed values are not allowed. Redirecting you to the input page...";
		 header("refresh: 3; PostEvent_html.php");
	}
	else{
		
	if ($stmt = $mysqli->prepare("select max(eid) from event")) {
		$stmt->execute();
		$stmt->bind_result($temp);
		if($stmt->fetch()){
			$MaxE = ($temp + 1);
		//	echo "<br> Your event number is $MaxE<br>";
			}
	$stmt->close();
	}
	if ($stmt = $mysqli->prepare("select ename from event where ename = ?")) {
		$stmt->bind_param("s",$a);
		$stmt->execute();
		if($stmt->fetch()){
			echo "This event name already exists";
			echo "<br> Redirecting you to the event insert page... <br>";
				header("refresh: 3; PostEvent_html.php");	  
		}
		else{
			$stmt->close();
			if ($stmt = $mysqli->prepare("insert into event (eid,ename,description,edatetime,location,is_public_e,sponsored_by)
				values (?,?,?,?,?,?,?)")) {
				$stmt->bind_param("issisii",$MaxE,$a,$d,$b,$e,$g,$f);
				if($stmt->execute()){
					echo "<br>Success!<br>";
					$stmt->close();
					}
				else{
					echo "Insert failed. The sponsoring club does not exists ... ";			
					$stmt->close();
			
			}
			}
			}
			}
			}
	}
	else{
		echo "This page is for admin's only ";
		echo "You will be redirected to the homepage...";
		$_SESSION["error"] = 1;
		header("refresh: 3; homepage.php");
		$stmt->close();
		}		

$_SESSION["error"] = 0; 
 $mysqli->close();
 
}
}
 ?>

</body>
<p>	Return to <a href="homepage.php">Homepage <a/>
</p>
</html>
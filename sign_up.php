<!DOCTYPE html>
<html>
<!--Kevin Li-->


<!-- Redirect to profile page when its done -->

<?php
include "connectdb.php";

if(!isset($_SESSION["UserID"])) {
	echo "You are not logged in. You must be signed in to sign up for an event. Redirecting to login... \n";
	  header("refresh: 3; login.php");
}
else{
	
$evName = $_GET["EventName"];

echo " Signing up for the $evName event!!<br>";

 if ($stmt = $mysqli->prepare("select eid,is_public_e from event where ename = ? ")) {
		
		$stmt->bind_param("s", $evName);
		$stmt->execute();
		$stmt->bind_result($evID,$isPub);
		$stmt->fetch();
		$stmt->close();		
	}
	if($isPub == 0){
		echo "$evName is a private event <br>";
		}
	else{
		echo "$evName is a public event <br>";
		}
		
 if ($stmt = $mysqli->prepare("select pid from member_of join event where pid= ? and clubid = sponsored_by and event.ename = ?")) {
	 $UID = $_SESSION["UserID"];
      $stmt->bind_param("ss", $UID, $evName);
	  $stmt->execute();
	  if($stmt->fetch()){
		 $isMember = 1;
		  echo "You are a member of this club allowing you to register for private events <br>";
	  }
	  else{$isMember= 0; echo "<br>You are not part of the club hosting the event: $evName. <br>  As such you may be unable to sign up if the club is private <br>";}
		$stmt->close();	
	}
 
 echo "<br>  Signing up for $evName.... <br><br>";
 
if ($stmt = $mysqli->prepare("select pid from sign_up natural join event where ename = ? and pid = ?")) {
	 
		$stmt->bind_param("ss",$evName,$UID);
		$stmt->execute();
		if($stmt->fetch()){
			echo "You are already in this event";
			echo "<br> Redirecting you to the upcoming events page... <br>";
				header("refresh: 3; event_viewer.php");	  
		}
		else{
			$stmt->close();
			if ($stmt = $mysqli->prepare("insert into sign_up (pid,eid) values (?,?)")) {
				$stmt->bind_param("si", $UID,$evID);
				if($isPub == 1 or ($isPub == 0 and $isMember == 1)){
					echo "User with ID: $UID has successfully signed up for $evName ";
					$stmt->execute();
	//				$stmt->close();
					}
				else{
					echo "Sign up failed. The event is private and you are not a member of the club sponsoring it";			
					$stmt->close();
					}
			}
		}
	
	}

	$mysqli->close();  
	$_SESSION["error"] = 0;
	 header("refresh: 3; homepage.php");
}
 
?>

</html>
<!DOCTYPE html>
<html>
<!--Kevin Li-->
<!-- Delete Person; Any advisor is allowed to do this -->
<body>

<h1 style="color:blue; font-size:40px;">Delete Page For Advisors</h1><br>

<?php
include "connectdb.php";

if(!isset($_SESSION["UserID"])) {
	echo "You are not logged in. You must be signed in to sign up for an event. Redirecting to login... \n";
	  header("refresh: 3; login.php");
	  }

	  else if(!(isset($_POST["delete-id"]))){  ?>
	  
<div class="login">
	<h2>Delete a User</h2>
		<ul>
   <form method="post" action="delete.php">
       <p><label for="login">Username </label><input type="text" name="delete-id" value="" placeholder="Person ID" required></p>
      </p>
    <p class="submit">
     <input type="submit" name="commit" value="submit">
    </p>
   </ul>
</div>
</form>
		  
<?php }

	  else{
		  
	  if($stmt = $mysqli->prepare("select pid from advisor where pid = ? ")){
	
	$myID = $_SESSION["UserID"];
	$stmt->bind_param("s",$myID);
	$stmt->execute();
	if($stmt->fetch()){
		echo "You are an advisor therefore you can delete students <br>";

	$stmt->close();
 
 $UID = $_POST["delete-id"];
 	 
	 $mysqli->query("SET FOREIGN_KEY_CHECKS=0");
 if (($stmt = $mysqli->prepare("delete club_comment, event_comment,comment, sign_up, role_in, member_of, interested_in, advisor_of, student, person  
 from person left join student 
 on student.pid = person.pid
 left join interested_in 
 on interested_in.pid = person.pid
 left join member_of 
  on member_of.pid = person.pid
 left join role_in 
  on role_in.pid = person.pid
 left join advisor_of 
  on advisor_of.pid = person.pid
 left join sign_up 
  on sign_up.pid = person.pid
 left join comment 
  on comment.commenter = person.pid
   left join event_comment 
   on `comment`.comment_id = event_comment.comment_id 
   left join club_comment 
   on `comment`.comment_id = club_comment.comment_id
 where person.pid = ? "))) {
	 
$stmt->bind_param("s",$UID);	
if($stmt->execute()){
echo "Person was deleted....";
}
else{
	echo "failed...";
	}
//		$stmt->close();		
	}
	 $mysqli->query("SET FOREIGN_KEY_CHECKS=1");	
		}

	else{
		echo "This page is for advisor's only <br>";
		echo "You will be redirected to the homepage...";
		$_SESSION["error"] = 1;
		header("refresh: 3; index.php");	
	//	$stmt->close();

		}		
	$stmt->close();
		}
	 $mysqli->close();  
	$_SESSION["error"] = 0;
	echo "<br>Redirecting in 3 seconds...." ;
	header("refresh: 3; index.php");
}
?>
</body>
</html>
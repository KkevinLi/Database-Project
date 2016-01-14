<?php
include "connectdb.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title> Comment Page </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php

	if(!isset($_SESSION["UserID"])) {
		echo "You are not logged in. You must be logged in to comment. Redirecting to login... \n";
		header("refresh: 3; login_html.php");
		'<br/><p>You will be redirected in 3 seconds or click <a href="homepage.php">here</a>.</p>';
	}	
	
	?>
	<h1> Comments </h1> <br/>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<center><select name="cluby" id="options">
	  <option value=6>Theater Club</option>
	  <option value=7>Frisbee Club</option>
	  <option value=8>Oxford Blues Club</option>
	  <option value=9>Robotics Club</option>
	</select></center>
	<center><input type="submit" /></center>
	</form>
	<br/>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<!-- <?php
		if(isset($_POST['submit']))
		{
		    $name = $_POST['name'];
		    echo "User Has submitted the form and entered this name : <b> $name </b>";
		    echo "<br>You can use the following form again to enter a new name.";
		}
		?> -->
	<center><input id="newcom" type="text" name="ctext"></center><br/>
	<center><input type="submit" value="Submit"></center>
	</form>

	<?php
	$clubtype = $_POST['cluby'];
		$users_comment = $_POST['newcom'];
		$users_comment = mysql_real_escape_string($users_comment);

    if($stmt= $mysqli->prepare("SELECT max(comment_id) FROM comment")){
   		$stmt->execute();
   		$stmt->bind_result($numcom);
   		while ($stmt->fetch()){
   			echo $numcom;
   		}
		$stmt->close();
	}
	$next = $numcom + 1;
	$pid=$_SESSION["UserID"];
	$pub = 1; 
	// $newData = "INSERT INTO comment (comment_id, commenter, ctext, is_public_c) VALUES ($next, '$pid', '$users_comment', '$pub')";
    if($stmt= $mysqli->prepare("INSERT INTO comment (comment_id, commenter, ctext, is_public_c) VALUES (?, ?, ?, ?)")){
	    $stmt->bind_param("iisi",$next, $pid, $users_comment, $pub);
   		$stmt->execute();
		$stmt->close();
	}
	// header("refresh: 3; comment.php");
	?>
	
	<h1> Added Comments </h1>
	<p id="comments">
	<?php
	
	echo "<b>Commented on Clubs</b> <br/>";
	if($stmt= $mysqli->prepare("SELECT cname FROM club, club_comment, comment  
								WHERE club.clubid = club_comment.clubid 
								AND club_comment.comment_id=comment.comment_id")){
	   		$stmt->execute();
	   		$stmt->bind_result($cName);
	   		while ($stmt->fetch()){
				echo $cName;
				echo " ";
			}
			$stmt->close();
		}
	echo "<br/><br/>";
		
	echo "<b>Commented on Events</b> <br/>";
	if($stmt= $mysqli->prepare("SELECT ename FROM event, event_comment, comment  
								WHERE event.eid = event_comment.eid 
								AND event_comment.comment_id=comment.comment_id")){
	  		$stmt->execute();
	   		$stmt->bind_result($eName);
	   		while ($stmt->fetch()){
				echo $eName;
				echo " ";
			}
			$stmt->close();
		}
		echo "<br/><br/>";
		
    if($stmt= $mysqli->prepare("SELECT comment_id, commenter, ctext FROM comment")){
   		$stmt->execute();
   		$stmt->bind_result($comNum, $comPID, $comText);
   		while ($stmt->fetch()){
			echo "<b>Comment Number: </b> ";
   			echo $comNum;
			echo "<br/>";
			echo "<b>Commenter's ID: </b> ";
			echo $comPID;
			echo "<br/>";
			echo "<b>Comment: </b> ";
			echo $comText;
			echo "<br/><br/>";
   		}
		$stmt->close();
	}
 
	
	// $comm = $mysqli->query("SELECT * FROM comment;");
	// $c = $comm->fetch_assoc();
	// foreach($comm as $key => $c){
	// 	echo "<b>Comment Number:</b> ";
	// 	echo $c['comment_id'];
	// 	echo "<b>Commenter's ID:</b> ";
	// 	echo $c['commenter'];
	// 	echo "<b>Comment:</b> ";
	// 	echo $c['ctext'];
	// }
	$mysqli->close();
	?>	</p><br/>
	<button id="button"><a href="homepage.php">Homepage</a></button>
</body>
</html>
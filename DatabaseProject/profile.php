<?php
	include "connectdb.php";
// 	include "login.php";
?> 
<!DOCTYPE html>
<html>
<head>
	<title> Profile Page </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class = "container">
<div class = "row">	
	<ul class = "nav nav-tabs">
	<li><a href="index.php">HomePage</a></li>
	<li><a href="sign_up.php">Sign Up</a></li>
	<li><a href="PostEvent_html.php">Post Event</a></li>
	<li><a href="event_veiwer.php">View Event</a></li>
	<li><a href="check_events.php">Check Event</a></li>
	<li><a href="delete.php">Delete Comment</a></li>
	<li><a href="comment.php">Post Comment</a></li>
<?php
	if(isset($_SESSION["UserID"]))
	 echo "<li class ='navbar-right'><a href='logout.php'>Logout</a> </li>";
	else
		echo "<li class ='navbar-right'><a href='login.php'>Login</a></li>";
?>
	</ul>
</div>
</div>
	<?php
	// require_once("connectdb.php");
	// $id=$_SESSION["UserID"];
	// $result = mysql_query("SELECT * FROM person where pid='$id'");
	// while($row = mysql_fetch_array($result))
	// {
	// $fname=$row['fname'];
	// $lname=$row['lname'];
	// }
	// echo $_SESSION["UserID"];
	if(!isset($_SESSION["UserID"])) {
		echo "<br>You are not logged in. You must be logged in to continue. Redirecting to login... \n";
		header("refresh: 3; login.php");
		'<br/><p>You will be redirected in 3 seconds or click <a href="index.php">here</a>.</p>';
	}	
	else{
	$pid=$_SESSION["UserID"];
    if($stmt= $mysqli->prepare("SELECT fname, lname FROM person WHERE pid = ?")){
	    $stmt->bind_param("s",$pid);
   		$stmt->execute();
   		$stmt->bind_result($fname,$lname);
   		while ($stmt->fetch()){
   			echo "<br><br><h1>Welcome {$fname} {$lname}!!</h1>";
   		}
		$stmt->close();
	}
    if($stmt= $mysqli->prepare("SELECT gender, class FROM student WHERE pid = ?")){
	    $stmt->bind_param("s",$pid);
   		$stmt->execute();
   		$stmt->bind_result($gender,$class);
		while($stmt->fetch()){
			// echo $gender;
			// echo $class;
			// echo "";
		}
		$stmt->close();
 	}
	
	if($gender == "Male"){
	?>
	<div id="prologo">
		<center>
			<img src="propic.jpg" alt="TEMP PROFILE PIC" width="300" height="300">
		</center>
	</div>
	<?php
	}
	else if($gender == "Female"){
	?>
	<div id="prologo">
		<center>
			<img src="fpropic.png" alt="TEMP PROFILE PIC" width="400" height="400">
		</center>
	</div>
		
	<?php 
	}
	?>
	
	<table width="500" border="0" align="center" cellpadding="5">
		<tr>
	    	<td id="introPro" height="26" colspan="2"><b>Your Profile Information</b> </td>

		</tr>
		<tr>
	    	<td width="82" valign="top"><div align="left">FirstName:</div></td>
	    	<td width="165" valign="top"><?php echo $fname; ?></td>
		</tr>
		<tr>
	    	<td valign="top"><div align="left">LastName:</div></td>
	    	<td valign="top"><?php echo $lname; ?></td>
		</tr>
		<tr>
	    	<td valign="top"><div align="left">Pid: </div></td>
	    	<td valign="top"><?php echo $_SESSION["UserID"]; ?></td>
		</tr>
		<tr>
	    	<td valign="top"><div align="left">Gender: </div></td>
	    	<td valign="top"><?php echo $gender; ?></td>
		</tr>
		<tr>
	    	<td valign="top"><div align="left">Class: </div></td>
	    	<td valign="top"><?php echo $class; ?></td>
		</tr>
		<tr>
	    	<td valign="top"><div align="left">Interested In Topics: </div></td>
	    	<td valign="top"><?php
				if($stmt= $mysqli->prepare("SELECT topic FROM interested_in WHERE pid = ?")){
				    $stmt->bind_param("s",$pid);
				   	$stmt->execute();
				   	$stmt->bind_result($topic);
					while($stmt->fetch()){
						echo $topic;
						?><br/>
						<?php
					}
					$stmt->close();
				}
	    	?></td>
		</tr>
		<tr>
	    	<td valign="top"><div align="left"> Joined Clubs: </div></td>
	    	<td valign="top"><?php
				if($stmt= $mysqli->prepare("SELECT cname FROM member_of NATURAL JOIN club WHERE pid = ? AND member_of.clubid = club.clubid")){
				    $stmt->bind_param("s",$pid);
				   	$stmt->execute();
				   	$stmt->bind_result($club);
					while($stmt->fetch()){
						echo $club;?>
						<br/><?php
					}
					$stmt->close();
				}
	    	?></td>
		</tr>
		<tr>
	    	<td valign="top"><div align="left"> Role: </div></td>
	    	<td valign="top"><?php
				if($stmt= $mysqli->prepare("SELECT role FROM role_in WHERE pid = ?")){
				    $stmt->bind_param("s",$pid);
				   	$stmt->execute();
				   	$stmt->bind_result($role);
					while($stmt->fetch()){
						echo $role;
						?><br/><?php
					}
					$stmt->close();
				}
				$mysqli->close();
	}?></td>
		</tr>
	</table>
	
	<!-- <p align="center"><a href="login.php"></a></p> -->
	
</body>
</html>
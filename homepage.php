<?php
include "connectdb.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title> Home Page </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php
	if(isset($_SESSION["error"]) && $_SESSION["error"] == 1) {
		echo "You were redirected here because of an error";
	}
	$events = $mysqli->query("SELECT ename FROM event WHERE is_public_e = 1 AND edatetime >= NOW() AND edatetime <= NOW() + INTERVAL 7 DAY;");
	$e = $events->fetch_assoc();
	$printy = $mysqli->query("SELECT cname, descr, topic FROM club_topics NATURAL JOIN club;");
	$p = $printy->fetch_assoc();
	
	?>
	<!-- <h1> WELCOME </h1> <br/> -->
<?php
if(isset($_SESSION["UserID"])){
$pid=$_SESSION["UserID"];
if($stmt= $mysqli->prepare("SELECT fname, lname FROM person WHERE pid = ?")){
    $stmt->bind_param("s",$pid);
	$stmt->execute();
	$stmt->bind_result($fname,$lname);
	while ($stmt->fetch()){
		echo "<h1>Welcome {$fname} {$lname}!!</h1>";
	}
	$stmt->close(); 
}
?>
	<h2>Click For More Options</h2>
	<button id="button"><a href="logout.php">logout</a></button>
	<button id="button"><a href="profile.php">View Profile</a></button>
	<button id="button"><a href="sign_up.php">Sign Up</a></button>
	<button id="button"><a href="PostEvent_html.php">Post Event</a></button>
	<button id="button"><a href="event_veiwer.php">View Event</a></button>
	<button id="button"><a href="check_events.php">Check Event</a></button>
	<button id="button"><a href="delete_html.php">Delete</a></button>
	<button id="button"><a href="comment.php">Comment</a></button>
<?php } ?>
	<div id="Nyulogo">
		<center>
			<img src="NYUPoly.jpg" alt="NYU POLYTECHNIC UNIVERSITY" width="750" height="300">
		</center>
	</div>
	
	<h2> OFFERED CLUBS </h2>
	<p> Displayed By Topics </p>
	
	<ul id="topiclist">
		<?php

			foreach ($printy as $key => $p) { 
		?>
				<li> <?php echo "Topic: "; echo $p['topic']; ?></br>
					<?php echo "Name of Club: "; echo $p['cname']; ?> <br/>
					<?php echo "Description: "; echo $p['descr'];?> <br/> <br/></li>
		<?php } ?>
	</ul>
	
	<h2>UPCOMING EVENTS FOR THE GENERAL PUBLIC</h2>
	<ul>
		<?php
		foreach($events as $ke => $e){ ?>
			<li>
				<?php echo "Upcoming Public Events: "; echo $e['ename'];?>
			</li>
		<?php	
		}
			  $mysqli->close(); 
		?>
	</ul>
</body>
</html>
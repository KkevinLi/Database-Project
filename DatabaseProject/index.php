<?php
include "connectdb.php";
?>
<!DOCTYPE html>
<html>
<style>
    .bs-example{
    	margin: 20px;
    }
</style>
<head>
	<title> Home Page </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class = "container-fluid ">
<div class = "row">	
<nav class = "navbar navbar-default transparent  navbar-fixed-top">
<a class = "navbar-brand pull-left" href="#"> POLY Club
		</a>
		<div class = "collapse navbar-collapse">
	<ul class = "nav navbar-nav pull-right ">
	<li class="active"><a href="#">Home</a></li>
	<li><a href="profile.php">Profile</a></li>
	<li><a href="PostEvent_html.php">Post Event</a></li>
	<li><a href="event_veiwer.php">View Event</a></li>
	<li><a href="check_events.php">Check Event</a></li>
	<li><a href="delete.php">Delete Comment</a></li>
	<li><a href="comment.php">Post Comment</a></li>

<?php
	if(isset($_SESSION["UserID"]))
	 echo "<li><a href='logout.php'>Logout</a> </li>";
	else
		echo "<li><a  href='login.php'>Login</a></li>";
?>
	</ul>
		</nav>
		</div>
</div>
</div>

	<?php
	if(isset($_SESSION["error"]) && $_SESSION["error"] == 1) {
		echo "You were redirected here because of an error";
	}
	$events = $mysqli->query("SELECT ename FROM event WHERE is_public_e = 1 AND edatetime >= NOW();");
	$e = $events->fetch_assoc();
	$printy = $mysqli->query("SELECT cname, descr, topic FROM club_topics NATURAL JOIN club;");
	$p = $printy->fetch_assoc();
	
	?>
	
<?php
if(isset($_SESSION["UserID"])){
$pid=$_SESSION["UserID"];
if($stmt= $mysqli->prepare("SELECT fname, lname FROM person WHERE pid = ?")){
    $stmt->bind_param("s",$pid);
	$stmt->execute();
	$stmt->bind_result($fname,$lname);
	while ($stmt->fetch()){
		echo "<h1 class='text-primary'>Welcome {$fname} {$lname}!!</h1>";
	}
	$stmt->close(); 
}
?>
<?php } ?>

<div id="Nyulogo">
		<center>
			<img src="NYUPoly.jpg" alt="NYU POLYTECHNIC UNIVERSITY" width="750" height="250">
		</center>
	</div>
	
	<h2 class="text-primary text-center" style="font-size:35px;"> <br><br>Clubs and Topics </h2>
	
	
	<div class = "container-fluid">
	<ul  id="topiclist">
<div class = "row">
		<?php	foreach ($printy as $key => $p) {	?>	
		
			<div class = "col-md-4">
			
				<li>
					<?php echo "<span style='font-size:18px;'>Topic: </span>"; echo $p['topic']; ?></br> 
					<?php echo "Name of Club: "; echo $p['cname']; ?> <br/> 
					<?php echo "Description: "; echo $p['descr'];?> <br/> <br/>
				</li> 
				
			</div>
			
		<?php } ?>

		</div>
	</ul>
	</div>
	<h2 class="text-primary text-center">UPCOMING EVENTS FOR THE GENERAL PUBLIC</h2>
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
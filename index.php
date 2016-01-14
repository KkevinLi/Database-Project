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
	// $topic = $mysqli->query("SELECT * FROM club_topics;");
// 	$t = $topic->fetch_assoc();
// 	$club = $mysqli->query("SELECT * FROM club;");
// 	$c = $club->fetch_assoc();
	$events = $mysqli->query("SELECT ename FROM event WHERE is_public_e = 1 AND edatetime >= NOW() AND edatetime <= NOW() + INTERVAL 7 DAY;"); //Checks for a week
	$e = $events->fetch_assoc();
	$printy = $mysqli->query("SELECT cname, descr, topic FROM club_topics NATURAL JOIN club;");
	$p = $printy->fetch_assoc();
	?>
	<h1> WELCOME TO THE CLUB HUB </h1> <br/>

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
	<button id="button"><a href="login.php">login</a></button>

</body>
</html>
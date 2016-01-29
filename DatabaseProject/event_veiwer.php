<!DOCTYPE html>
<!--Kevin Li-->
<!--Shows all upcoming events in the next 3 days and includes a sign up button with all upcoming events excluding past events-->
<html>
	<body>
		<div class = "container-fluid">
			<h1>The Upcoming Events For the Next Three Days</h1>
			<br>

				<?php
include "connectdb.php";

 if (!($stmt = $mysqli->prepare("select * FROM event where edatetime >= NOW() AND edatetime <= NOW() + INTERVAL ? DAY;"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	  }

	$range= 50;
	$stmt->bind_param("i", $range);  
 if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
	$stmt->bind_result($eid,$ename,$descrip,$dateTime,$location,$public,$sponsered);

?>

				<table class = "table table-striped">
					<thead>
						<tr>
							<th>EID</th>
							<th>EName</th>
							<th>Description</th>
							<th>Date and Time</th>
							<th>Location</th>
							<th>Is It Public?</th>
							<th>Sponsored by: </th>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($stmt->fetch()){
							echo "<tr>";
							echo "<td>$eid</td> 	
								<td>$ename</td> 
								<td>$descrip</td>
								<td>$dateTime</td>  
								<td>$location</td> 
								<td>$public</td>			
								<td>$sponsered</td>";
							echo "</tr>";	
							}
							 $stmt->close();
						?>
					</tbody>
				</table>


				<?php

echo "<form action = sign_up.php method=GET>";
echo "<br>Sign Up For An Upcoming Event<br>";
echo "<select name=EventName>";

if ($stmt = $mysqli->prepare("select ename from event where edatetime >= NOW() ")) {
	
//	 we can bind columns too!  $funt = is_public_e + 1;
//	$stmt->bind_param("ii", $funt);
 
 $stmt->execute();
  $stmt->bind_result($EventName);
  while($stmt->fetch()) {
	$EventName = htmlspecialchars($EventName);
	echo "<option value='$EventName'>$EventName</option>\n";	
  }
  
  $stmt->close();
  $mysqli->close();
}

?>

			</select>
			<input type = "submit" value = "Sign Up ">
			</form>


			<p>
				<br>
	Click <a href="Event Information Page"> Event Page </a> for information on all events
					<br>
	Return to <a href="index.php">Homepage </a>
					</p>

				</body>
			</div>
		</html>
		
<!DOCTYPE html>
<!--Kevin Li-->
<!--Shows all upcoming events in the next 3 days and includes a sign up button with all upcoming events excluding past events-->
<html>
<body>

<h1>The Upcoming Events For the Next Three Days</h1><br>

<?php
include "connectdb.php";

 if (!($stmt = $mysqli->prepare("select * FROM event where edatetime between curdate() and curdate() + ? "))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	  }
	$x = 1800;
	$stmt->bind_param("i", $x);  
 if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
	$stmt->bind_result($a,$b,$c,$d,$e,$f,$g);
//	$counter = 0;
 echo "<table border = '1'>\n";
 echo "<tr>";
echo	"<th>EID</th>";
echo    "<th>EName</th>";
   echo "<th>Description</th>";
    echo"<th>Date and Time</th>";
   echo "<th>Location</th>";
   echo "<th>Is It Public?</th>";
   echo "<th>Sponsored by: </th>";
 	        echo "</tr>\n";
			 echo "</table>\n";


while ($stmt->fetch()) {
//	$counter++;
//echo $_SESSION["UserID"];
//echo "$out_id2  test";
//echo nl2br("\r\n");
 echo "<table border = '1'>\n";
    echo "<tr>";

//$kev = "login_html";
            echo "<td>$a</td><td>$b</td><td>$c</td><td>$d</td><td>$e</td><td>$f</td><td>$g</td>";
//			echo "Click the link to sign up for event: <a href= $b.php> Login</a>";
	        echo "</tr>\n";
			 echo "</table>\n";
//  Use get and send info throguh url						echo "<a href= $b.php> Sign Up For </a>";

//echo "$b <br> $c"; 
//echo "\r\n";
}

//echo "$counter  HIIIIIIIIIIIIIIIIIIIIII";
  $stmt->close();


echo "<form action = sign_up.php method=GET>";
echo "<br>Sign Up For An Upcoming Event<br>";
echo "<select name=EventName>";

if ($stmt = $mysqli->prepare("select ename from event where edatetime >= NOW() ")) {
	
//	 we can bind columns too!  $funt = is_public_e + 1;
//	$stmt->bind_param("i,i", $funt);
 
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
	
</select><input type = "submit" value = "Sign Up ">
</form>


<p>
	<br>
	Click <a href="Event Information Page"> Event Page <a/> for information on all events
	<br>
	Return to <a href="homepage.php">Homepage <a/>
</p>
</body>
</html>

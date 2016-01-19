
<!DOCTYPE html>
<!--Kevin Li -->
<html>
<body>
  <form action="PostEvent.php" method = "post">
  
  Fill Out The Form To Enter A New Event....
  <br><br>
Event name:<br>
<input type="text" name="EName" required>
<br>
Date&Time (Eg. 2015-05-18 00:00:00):<br>
<input type="text" name="EDate" required>
<br>
Description:<br>
<input type="text" name="EDes" required >
<br>
Location:<br>
<input type="text" name="ELoc" required>
<br>
Sponsoring Club:<br>
<input type="text" name="ESpon" required >
<br>
Event is Public (1 or 0):<br>
<input type="text" name="EPub" required >
<br>

<br><br>
<input type="submit" value="Submit">
</form> 
</body>
</html>


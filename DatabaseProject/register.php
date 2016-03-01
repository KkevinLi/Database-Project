<?php
include "connectdb.php";

if(isset($_SESSION["UserID"])) {
	echo "You are already logged in. You will be redirected in 3 seconds \n";
	  header("refresh: 3; index.php");
}
// Show form only if user is not signed in. Prevent signed in users from seeing form
else if(!(isset($_POST["id"]) && isset($_POST["pass"]))){ 
?>

<!DOCTYPE html>
<html>
	<head>
		<title> Register Page </title>
		<body>

			<h1> Registration Page</h1>
			<p> Please fill out the form to register as a student </p>

			<form>

			<div class = "col-md-3">
				First Name</div><div class = "form-control-label"><input type="text" name="firstname" required>
					 </div>
					<div class = "form-group row">
					 Last Name<input type="text" name="lastname" required>
						 </div>
					
		
					</form>
		</body>
				
				
				
<?php }
				?>
			</html>
			
<?php
include "connectdb.php";

if(!(isset($_POST["id"]) && isset($_POST["pass"]))){ ?>
<!DOCTYPE html>
<html>
<!--Kevin Li-->

<body>
 <div class="login">
   <h2>Login to view clubs</h2>
   <ul>
   <form method="post" action="login.php">
       <p><label for="login">Username </label><input type="text" name="id" value="" placeholder="Person ID" required></p>
       <p><label for="password">Password </label><input type="password" name="pass" value="" placeholder="Password" required></p>
    <p class="remember_me">
     <label>
         <input type="checkbox" name="remember_me" id="remember_me">
             Remember me on this computer
        </label>
    </p>
    <p class="submit">
     <input type="submit" name="commit" value="Login">
    </p>
   </ul>
  </div>
</form>
</body>
<?php
}
else if(isset($_SESSION["UserID"])) {
	echo "You are already logged in. You will be redirected in 3 seconds \n";
	  header("refresh: 3; homepage.php");
}
else if ($stmt = $mysqli->prepare("select pid,fname from person where pid= ? and passwd = ?")) {
	 $UID = $_POST["id"];
	 $UPass = md5($_POST["pass"]);
      $stmt->bind_param("ss", $UID, $UPass);
	  $stmt->execute();
	  $stmt->bind_result($userPID,$userName);
	  if($stmt->fetch()){
		  $_SESSION["UserID"] = $userPID;
		 $_SESSION["REMOTE_ADDR"] = $_SERVER["REMOTE_ADDR"];
		  
		  echo "You have successfully logged in. You will be redirected in 3 seconds";
		   
			$_SESSION["error"] = 0;
		   header("refresh: 3; homepage.php");
	  }
	
	else{
		echo "Either the ID or password was incorrect. Try again";

			$_SESSION["error"] = 1;	
	header("refresh: 2; login.php");
	
	}
	  $stmt->close(); 

}
	  $mysqli->close(); 
 

 
?>

</html>
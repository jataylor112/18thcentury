<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>The Long 18th Century</title>
	<link rel="stylesheet" href="/18thcentury/styles/normalize.css">
	<link rel="stylesheet" href="/18thcentury/styles/build.css">
	<link rel="shortcut icon" href="/18thcentury/images/favicon.ico">
</head>

<body>
  <header>
		<p><nav id="topbar">
		<ul>
		<li><a href="/18thcentury/nations.php">Nations</a></li>
		<li><a href="/18thcentury/conflicts.php">Conflicts</a></li>
		<li><a href="/18thcentury/index.php">Long 18th Century</a></li>
		<li><a href="/18thcentury/science.php">Science</a></li>
		<li><a href="/18thcentury/profile.php" class="current">Profile</a><br></li>
		</ul></nav></p><br><br><br> <!-- <br> is needed to keep topbar visible -->
	 <script>
	 window.onscroll = function() {scrollFunction()};
	 function scrollFunction() {
		 if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
			 if (window.screen.availWidth < 400) {
				 document.getElementById("topbar").style.fontSize = "70%";
			 } else if (window.screen.availWidth < 615) {
				 document.getElementById("topbar").style.fontSize = "100%";
			 } else if (window.screen.availWidth < 640) {
				 document.getElementById("topbar").style.fontSize = "115%";
			 } else if (window.screen.availWidth < 1000) {
				 document.getElementById("topbar").style.fontSize = "130%";
			 } else if (window.screen.availWidth < 1200) {
				 document.getElementById("topbar").style.fontSize = "150%";
			 } else {
				 document.getElementById("topbar").style.fontSize = "150%";
			 }
		 }
		 else {
			 if (window.screen.availWidth < 400) {
				 document.getElementById("topbar").style.fontSize = "80%";
			 } else if (window.screen.availWidth < 615) {
				 document.getElementById("topbar").style.fontSize = "110%";
			 } else if (window.screen.availWidth < 640) {
				 document.getElementById("topbar").style.fontSize = "130%";
			 } else if (window.screen.availWidth < 1000) {
				 document.getElementById("topbar").style.fontSize = "135%";
			 } else if (window.screen.availWidth < 1200) {
				 document.getElementById("topbar").style.fontSize = "160%";
			 } else {
				 document.getElementById("topbar").style.fontSize = "160%";
			 }
		 }
	 }
	function fadeOutEffect() {
	  var fadeTarget = document.getElementById("cookie_banner");
	  var fadeEffect = setInterval(function () {
	    if (!fadeTarget.style.opacity) {
	      fadeTarget.style.opacity = 1;
	    }
	    if (fadeTarget.style.opacity > 0) {
	      fadeTarget.style.opacity -= 0.1;
	    } else {
	      clearInterval(fadeEffect);
	    }
	  }, 100);
	  document.cookie = 'acknowledgement = 1';
	}
	</script>
	<h3 id="europeanSentence">The European Era of <a href="/18thcentury/nations.php">Empire</a> and <a href="/18thcentury/science.php">Enlightenment</a></h3>
	</header>
<?php
	if(!isset($_COOKIE["acknowledgement"])){
		echo("<div class='cookie_banner' id='cookie_banner'>");
		echo("<p style='color: black'>By using our website, you agree to our <a href='cookie_policy.html' style='color: red'>cookie policy</a>.</p>");
		echo("<button class='close' id='cookie_button' name='cookie_button' onclick='fadeOutEffect()'>&times;</button>");
		echo("</div>");
		if(array_key_exists('cookie_button', $_POST)) {
			setcookie("acknowledgement", 1, time() + (86400 * 30), "/"); // 86400 = 1 day
		}
	}
	if(!isset($_COOKIE["username"])){
		header('location: profile.php');
	}
	if (isset($_POST['submitEdit'])){
		header('location: edit_my_profile.php');
	}
	if (isset($_POST['submit'])){
		setcookie("username", $resUsername, time() - 3600, "/"); // Deletes cookie
		header('location: profile.php');
	}
?>
  <main>
  <h1>My Profile</h1>
	<h1></h1>
	  <title>Profile Description</title>
		<figure>
		<img src="images/mailsnow.png" height="200" width="200" id="mailsnow">
		<figcaption>The Mail Coach in a Drift of Snow</figcaption>
		</figure>
		<figure id="quicksilver">
		<img src="images/quicksilver.jpg" height="200" width="200" id="quicksilver">
		<figcaption>Mail Coaches on the Road: "Quicksilver"</figcaption>
		</figure>
	    <form name="login" onsubmit="__" method="post">
		  <table width="230" border="0" cellpadding="2" cellspacing="0" id="profile_table">
		    <tbody>
			  <tr>
			    <td>
				  <div align="right" id="bold">Username:</div>
				</td>
				<?php
					echo("<td id='bold'>" . $_COOKIE['username'] . "</td>");
				?>
			  </tr>
			  <tr>
			    <td>
				  <div align="right" id="bold">First Name:</div>
				</td>
				<?php
				function openConnection() // Opens connection to server
				{
					try
					{
						include 'connection.php';
						$connectionOptions = array("Database"=>$databaseName,
							"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
						$conn = sqlsrv_connect($serverName, $connectionOptions);
						if($conn == false)
							die("<h1>Could not connect to database!</h1>");
						if($conn == true)
							try
							{
								$username = $_COOKIE["username"];
								$checksql = "EXEC selectUsers";
								$params = array();
								$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
								$sqlStatement = sqlsrv_query($conn, $checksql , $params, $options);
								$row_count = sqlsrv_num_rows($sqlStatement);
								if ($row_count === false)
									echo("<p>Error in retreiving row count!</p>");

									if ($row_count > 0) {
									$selectSQL = "EXEC selectUserFName $username";
									$selectQuery = sqlsrv_query($conn, $selectSQL);
									if(sqlsrv_fetch($selectQuery) === false) {
										die( print_r( sqlsrv_errors(), true));
									}
									else
									{
										$fname = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
										echo("<td id='bold'>" . $fname . "</td>");
									}
								}
								else { // If no usernames are in USER_ACCOUNT, this function activates!
									echo("<script> alert ('No users are in the database!'); </script>");
									header('location: registration.php');
									die();
								}
								sqlsrv_close($conn);
							}
							catch(Exception $e)
							{
								echo("Error!");
								sqlsrv_close($conn);
							};
					}
					catch(Exception $e)
					{
						echo("Error!");
						sqlsrv_close($conn);
					}
				}
				openConnection();
				?>
			  </tr>
			  <tr>
			    <td>
				  <div align="right" id="bold">Last Name:</div>
				</td>
				<?php
					function openConnectionLName() // Opens connection to server
					{
						try
						{
							include 'connection.php';
							$connectionOptions = array("Database"=>$databaseName,
								"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
							$conn = sqlsrv_connect($serverName, $connectionOptions);
							if($conn == false)
								die("<h1>Could not connect to database!</h1>");
							if($conn == true)
								try
								{
									$username = $_COOKIE["username"];
									$checksql = "EXEC selectUsers";
									$params = array();
									$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
									$sqlStatement = sqlsrv_query($conn, $checksql, $params, $options);
									$row_count = sqlsrv_num_rows($sqlStatement);
									if ($row_count === false)
										echo("<p>Error in retreiving row count!</p>");

										if ($row_count > 0) {
										$selectSQL = "EXEC selectUserLName $username";
										$selectQuery = sqlsrv_query($conn, $selectSQL);
										if(sqlsrv_fetch($selectQuery) === false) {
											die( print_r( sqlsrv_errors(), true));
										}
										else
										{
											$lname = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
											echo("<td id='bold'>" . $lname . "</td>");
										}
									}
									else { // If no usernames are in USER_ACCOUNT, this function activates!
										echo("<script> alert ('No users are in the database!'); </script>");
									}
									sqlsrv_close($conn);
								}
								catch(Exception $e)
								{
									echo("Error!");
									sqlsrv_close($conn);
								};
						}
						catch(Exception $e)
						{
							echo("Error!");
							sqlsrv_close($conn);
						}
					}
					openConnectionLName();
				?>
			  </tr>
			  <tr>
			    <td>
				  <div align="right" id="bold">Email:</div>
				</td>
				<?php
					function openConnectionEmail() // Opens connection to server
					{
						try
						{
							include 'connection.php';
							$connectionOptions = array("Database"=>$databaseName,
								"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
							$conn = sqlsrv_connect($serverName, $connectionOptions);
							if($conn == false)
								die("<h1>Could not connect to database!</h1>");
							if($conn == true)
								try
								{
									$username = $_COOKIE["username"];
									$checksql = "EXEC selectUsers";
									$params = array();
									$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
									$sqlStatement = sqlsrv_query($conn, $checksql , $params, $options);
									$row_count = sqlsrv_num_rows($sqlStatement);
									if ($row_count === false)
										echo("<p>Error in retreiving row count!</p>");

										if ($row_count > 0) {
										$selectSQL = "EXEC selectUserEmail $username";
										$selectQuery = sqlsrv_query($conn, $selectSQL);
										if(sqlsrv_fetch($selectQuery) === false) {
											die( print_r( sqlsrv_errors(), true));
										}
										else
										{
											$email = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
											echo("<td id='bold'>" . $email . "</td>");
										}
									}
									else { // If no usernames are in USER_ACCOUNT, this function activates!
										echo("<script> alert ('No users are in the database!'); </script>");
									}
									sqlsrv_close($conn);
								}
								catch(Exception $e)
								{
									echo("Error!");
									sqlsrv_close($conn);
								};
						}
						catch(Exception $e)
						{
							echo("Error!");
							sqlsrv_close($conn);
						}
					}
					openConnectionEmail();
				?>
			  </tr>
			</tbody>
		  </table>
	    </form>
	&nbsp; <!-- Empty Space -->
	<form action="my_profile.php" method="post">
		<input type="submit" value="Edit Profile" class="button" id="edit_button" name="submitEdit" >
	</form>
	<form action="my_profile.php" method="post">
	  <input type="submit" value="Logout" class="button" id="logout_button" name="submit">
	</form>
  </main>

  <footer>
	<p></p>
  </footer>
</body>
</html>

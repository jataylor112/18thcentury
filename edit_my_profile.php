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
	<h3 style="text-align: center">The European Era of</h3>
	<h3 style="text-align: center"><a href="/18thcentury/nations.php">Empire</a> and <a href="/18thcentury/science.php">Enlightenment</a></h3>
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
	if (isset($_POST['submit'])){
		$fname = $_POST["firstname"];
		$lname = $_POST["lastname"];
		$email = $_POST["email"];
		if ($fname == "" OR $lname == "" OR $email == "") {
			echo("Error! Blank Fields!");
		}
		else if ($fname == " " OR $lname == " " OR $email == " ") {
			echo("Error! Only Spaces Detected!");
		}
		else {
			function openConnection() // Opens connection to server
			{
				try
				{
					include 'C:/xampp/htdocs/18thcentury/connection.php';
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
								//////////////////////////////////////////////////////////////////
								function insertData() // Use this function to insert user details into user table!
								{
									try
									{
										include 'C:/xampp/htdocs/18thcentury/connection.php';
										$connectionOptions = array("Database"=>$databaseName,
											"Uid"=>$uid, "PWD"=>$pwd);
										$conn = sqlsrv_connect($serverName, $connectionOptions);
										$originalUsername = $_COOKIE["username"];
										$fname = $_POST["firstname"];
										$lname = $_POST["lastname"];
										$email = $_POST["email"];
										$resFname = preg_replace("/[^a-zA-Z0-9_]{1,}$/", "", $fname);
										$resLname = preg_replace("/[^a-zA-Z0-9_]{1,}$/", "", $lname);
										///////////////////////////////////////////////////////////////////////////////////////////
										$sql = "USE $databaseName EXEC updateUser ?, ?, ?, ?";
										$preparedStatement = sqlsrv_prepare($conn, $sql, array(&$originalUsername, &$resFname, &$resLname, &$email));
										if(!$preparedStatement) {
											die(print_r(sqlsrv_errors(), true));
										}
										sqlsrv_execute($preparedStatement);
										sqlsrv_close($conn);
										header('location: my_profile.php');
									}
									catch(Exception $e)
									{
										echo("Error!");
									}
								}
								die(insertData());
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
				};
				sqlsrv_close($conn);
			}
			openConnection();
		}
	}
?>
  <main>
    <h1>Editing Your Profile</h1>
	<h1></h1>
	  <title>Editing Profile</title>
	    <form name="login" action="edit_my_profile.php" onsubmit="submit_button" method="post">
		  <table width="230" border="0" cellpadding="2" cellspacing="0" id="edit_profile_table">
		    <tbody>
			  <tr>
			    <td width="95">
				  <div align="right" id="bold">Username:</div>
				</td>
				<?php
					$username = $_COOKIE['username'];
					echo("<td id='bold' width='171'>$username</td>");
				?>
			  </tr>
			  <tr>
			    <td width="95">
				  <div align="right" id="bold">First Name:</div>
				</td>
				<?php
				function openConnectionFName() // Opens connection to server
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
										echo("<td id='bold' width='171'><input type='text' name='firstname' id='firstname' value='$fname'></td>");
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
				openConnectionFName();
				?>
			  </tr>
			  <tr>
			    <td width="95">
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
									$sqlStatement = sqlsrv_query($conn, $checksql , $params, $options);
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
											echo("<td id='bold' width='171'><input type='text' name='lastname' id='lastname' value='$lname'></td>");
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
			    <td width="95">
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
											echo("<td id='bold' width='171'><input type='text' name='email' id='email' value='$email'></td>");
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
		  <input type="submit" value="Submit" class="button" id="submit_button" name="submit">
	    </form>
	&nbsp; <!-- Empty Space -->
  </main>

	<footer>
		<table style="margin-left: auto; margin-right: auto; border-spacing: 10px; border-collapse: separate">
			<tr><td><a href="/18thcentury/cookie_policy.html">Cookie Policy</a></td>
			<td><a href="/18thcentury/contact.php">Contact</a></td></tr>
		</table>
  </footer>
</body>
</html>

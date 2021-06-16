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
		function blankFields() {
	        var username = document.getElementById("username").value;
	        var firstName = document.getElementById("firstname").value;
					var lastName = document.getElementById("lastname").value;
					var email = document.getElementById("email").value;
					var passwordFirst = document.getElementById("password").value;
	        var passwordConfirm = document.getElementById("confirm_password").value;

					if ((passwordFirst.length < 4) || (passwordConfirm.length < 4)) {
						if ((username.length >= 1) && (firstName.length >= 1) && (lastName.length >= 1) && (email.length >= 1)) {
							alert ("Your password needs at least 4 characters!");
						}
					}

	        if ((username == '') && (firstName == '') && (lastName == '') && (email == '') && (passwordFirst == '') && (passwordConfirm == '')) {
	          alert ("Please enter input in the blank fields!");
					}
					else if (username == '') {
	          alert ("Please enter your username!");
					}
					else if (firstName == '') {
						alert ("Please enter your first name!");
					}
					else if (lastName == '') {
						alert ("Please enter your last name!");
					}
					else if (email == '') {
						alert ("Please enter your email!");
					}
	        else if (passwordFirst == '') {
	          alert ("Please enter your password!");
					}
	        else if (passwordConfirm == '') {
	          alert ("Please confirm your password!");
					}
					else if (passwordFirst != '' && passwordConfirm != '' && passwordFirst != passwordConfirm) {
						alert ("\nPasswords do not match! Please try again!");
					}
					else if (username.contains(" ") || firstName.contains(" ") || lastName.contains(" ") ||
					email.conains(" ") || passwordFirst.contains(" ") || passwordConfirm.contains(" ")) {
						alert ("Error! Spaces Detected!");
					}
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
	if(isset($_COOKIE["username"])){
		header('location: my_profile.php');
		die();
	}
		if (isset($_POST['register'])){
			$username = $_POST["username"];
			$fname = $_POST["firstname"];
			$lname = $_POST["lastname"];
			$email = $_POST["email"];
			$password = $_POST["password"];
			$confirmPassword = $_POST["confirm_password"];
			if ($password != $confirmPassword) {
				header('location: registration.php');
			}
			else if (strlen($password) < 4) {
				header('location: registration.php');
				}
			else
			{
				if ($username == "" OR $fname == "" OR $lname == "" OR $email == "") {
					header('location: registration.php');
				}
				else if ($username == " " OR $fname == " " OR $lname == " " OR $email == " ") {
					header('location: registration.php');
				}
				else {
					function openConnection() // Opens connection to server
					{
						try
						{
							include 'C:/xampp/htdocs/connection.php';
							$connectionOptions = array("Database"=>$databaseName,
								"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
							$conn = sqlsrv_connect($serverName, $connectionOptions);
							if($conn == false)
								die("<h1>Could not connect to database!</h1>");
							if($conn == true)
								try
								{
									$username = $_POST["username"];
									$resUsername = preg_replace("/[^a-zA-Z0-9_]{1,}$]/", "", $username);
									$checksql = "EXEC selectUsers";
									$params = array();
									$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
									$sqlStatement = sqlsrv_query($conn, $checksql , $params, $options);
									$row_count = sqlsrv_num_rows($sqlStatement);
									if ($row_count === false)
									   echo("<p>Error in retreiving row count!</p>");

									if ($row_count > 0) {
										$selectSQL = "EXEC checkUsername $resUsername";
										$selectPreparedStatement = sqlsrv_prepare($conn, $selectSQL);
										$selectUsername = sqlsrv_execute($selectPreparedStatement);
										if($selectUsername == $resUsername) {
											die("<h2>Username is already taken! Input a different username to continue.</h2>");
											//die(FormatErrors(sqlsrv_errors()));
										}
										else
										{
											//////////////////////////////////////////////////////////////////
											function insertData() // Inserts user details into user table!
											{
												try
												{
													include 'C:/xampp/htdocs/connection.php';
													$connectionOptions = array("Database"=>$databaseName,
														"Uid"=>$uid, "PWD"=>$pwd);
													$conn = sqlsrv_connect($serverName, $connectionOptions);
													$username = $_POST["username"];
													$fname = $_POST["firstname"];
													$lname = $_POST["lastname"];
													$email = $_POST["email"];
													$password = $_POST["password"];
													$resUsername = preg_replace("/[^a-zA-Z0-9_]{1,}$]/", "", $username);
													$resFname = preg_replace("/[^a-zA-Z0-9_]{1,}$/", "", $fname);
													$resLname = preg_replace("/[^a-zA-Z0-9_]{1,}$/", "", $lname);
													$resPassword = preg_replace("/[^a-zA-Z0-9_]{1,}$/", "", $password);

													$sql = "EXEC insertUser ?, ?, ?, ?, ?";
													$preparedStatement = sqlsrv_prepare($conn, $sql, array(&$resUsername, &$resFname, &$resLname, &$email, &$resPassword)); // $procedure_params
													if(!$preparedStatement) {
														die(print_r(sqlsrv_errors(), true));
													}
													sqlsrv_execute($preparedStatement);
													setcookie("username", $resUsername, time() + (86400 * 30), "/"); // 86400 = 1 day
													echo("<script>
													alert ('Success! Your username is: $resUsername. Your password is: $resPassword')
													</script>");
													header('location: my_profile.php');
													sqlsrv_close($conn);
												}
												catch(Exception $e)
												{
													echo("Error!");
												}
											}
											die(insertData());
										}
									}
									else { // If no usernames are in USER_ACCOUNT, this function activates!
										function insertData() // Use this function to insert user details into user table!
										{
											try
											{
												include 'C:/xampp/htdocs/connection.php';
												$connectionOptions = array("Database"=>$databaseName,
													"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
												$conn = sqlsrv_connect($serverName, $connectionOptions);
												$username = $_POST["username"];
												$fname = $_POST["firstname"];
												$lname = $_POST["lastname"];
												$email = $_POST["email"];
												$password = $_POST["password"];
												$resUsername = preg_replace("/[^a-zA-Z0-9]/", "", $username);
												$resFname = preg_replace("/[^a-zA-Z0-9]/", "", $fname);
												$resLname = preg_replace("/[^a-zA-Z0-9]/", "", $lname);
												$resPassword = preg_replace("/[^a-zA-Z0-9]/", "", $password);

												$sql = "EXEC insertUser ?, ?, ?, ?, ?";
												$preparedStatement = sqlsrv_prepare($conn, $sql, array(&$resUsername, &$resFname, &$resLname, &$email, &$resPassword)); // $procedure_params
												if(!$preparedStatement) {
													echo("<p>ERROR!</p>");
													die(print_r(sqlsrv_errors(), true));
												}
												sqlsrv_execute($preparedStatement);
												setcookie("username", $resUsername, time() + (86400 * 30), "/"); // 86400 = 1 day
												echo("<script>
												if (confirm('Success! Your username is: $resUsername. Your password is: $resPassword')) {
												  window.location.href = 'index.php';
												} else {
												  window.location.href = 'my_profile.php';
												}
												</script>");
												sqlsrv_close($conn);
											}
											catch(Exception $e)
											{
												echo("Error!");
											}
										}
										die(insertData());
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
				}
			}
		}
  ?>
  <main>
  <h1>Registration</h1>
	<h3>Only letters and numbers can be submited - Any special characters will be removed in submission</h3>
	<h3>Passwords need to be 4 characters or more!</h3>
	<figure>
	<img src="images/mailsnow.png" height="200" width="200" id="mailsnow">
	<figcaption>The Mail Coach in a Drift of Snow</figcaption>
	</figure>
	<figure id="quicksilver">
	<img src="images/quicksilver.jpg" height="200" width="200" id="quicksilver">
	<figcaption>Mail Coaches on the Road: "Quicksilver"</figcaption>
	</figure>
	  <title>Registration</title>
		<form name="registration" action="registration.php" onsubmit="register_new_button" method="post" id="registration_form">
		  <table width="500" border="0" cellpadding="2" cellspacing="0" id="registration_table">
			<tbody>
			  <tr>
				<td width="200">
				  <div align="right" id="bold" style="margin-bottom: 5px;">Username:</div>
				</td>
				<td width="171">
				  <input type="text" name="username" id="username" required="">
				</td>
			  </tr>
			  <tr>
				<td width="200">
				  <div align="right" id="bold" style="margin-bottom: 5px;">First Name:</div>
				</td>
				<td width="171">
				  <input type="text" name="firstname" id="firstname" required="">
				</td>
			  </tr>
			  <tr>
				<td width="200">
				  <div align="right" id="bold" style="margin-bottom: 5px;">Last Name:</div>
				</td>
				<td width="171">
				  <input type="text" name="lastname" id="lastname" required="">
				</td>
			  </tr>
			  <tr>
				<td width="200">
				  <div align="right" id="bold" style="margin-bottom: 5px;">Email:</div>
				</td>
				<td width="171">
				  <input type="email" name="email" id="email" required="">
				</td>
			  </tr>
			  <tr>
				<td width="200">
				  <div align="right" id="bold" style="margin-bottom: 5px;">Password:</div>
				</td>
				<td width="171">
				  <input type="password" name="password" id="password" required="">
				</td>
			  </tr>
			  <tr>
				<td width="200">
				  <div align="right" id="bold" style="margin-bottom: 5px;">Confirm Password:</div>
				</td>
				<td width="171">
				  <input type="password" name="confirm_password" id="confirm_password">
				</td>
			  </tr>
			</tbody>
		  </table>
			<h2></h2> <!-- Empty Space -->
		  <input type="submit" value="Submit" class="button" id="register_new_button" name="register" onclick="blankFields()">
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

<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>The Long 18th Century</title>
	<link rel="stylesheet" href="styles/normalize.css">
	<link rel="stylesheet" href="styles/profile.css">
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" type="text/css" media="print" href="styles/print.css">
</head>

<body>
  <header>
    <h2 id="header"><a href="index.php"><center>The Long 18th Century<center></a></h2>
	<script>
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
		document.getElementById("header").style.fontSize = "30px";
	} else {
		document.getElementById("header").style.fontSize = "70px";
	}
	}
	function blankFields() {
        var username = document.getElementById("username").value;
        var firstName = document.getElementById("firstname").value;
				var lastName = document.getElementById("lastname").value;
				var email = document.getElementById("email").value;
				var passwordFirst = document.getElementById("password").value;
        var passwordConfirm = document.getElementById("confirm_password").value;

				if (passwordFirst.length < 4) {
					alert ("Your password needs at least 4 characters!");
				}

        if ((username == '') && (firstName == '') && (lastName == '') && (email == '') && (passwordFirst == '') && (passwordConfirm == '')) {
          alert ("Please enter input in the blank fields!");
				}
				else if (username == '') {
          alert ("Please enter your username!");
				}
				else if (firstName == '') {\
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
		document.cookie = 'acknowledgement=1';
	}
	</script>
	<h3><center>The European Era of <a href="/project/nations_empires.php">Empire</a> and <a href="/project/science_movements.php">Enlightenment</a></center></h3>
  </header>
 <p>
  <nav id="topbar">
  <ul>
	<li><a href="index.php">Home - Introduction</a></li>
	<li><a href="nations_empires.php">Nations | Empires</a></li>
	<li><a href="piracy_conflicts.php">Piracy | Conflicts</a></li>
	<li><a href="science_movements.php">Science | Movements</a></li>
	<li><a href="profile.php" class="current">Profile</a><br></li>
  </ul></p><br><br><br>
  </nav>
  <?php
    if(!isset($_COOKIE["acknowledgement"])){
		echo("<div class='cookie_banner'>");
		echo("<p style='color: green'>By using our website, you agree to our <a href='cookie_policy.html' style='color: red'>cookie policy</a>.</p>");
		echo("<button class='close' id='cookie_button' name='cookie_button' onclick='fadeOutEffect()'>&times;</button>");
		echo("</div>");
		if(array_key_exists('cookie_button', $_POST)) {
			setcookie("acknowledgement", 1, time() + (86400 * 30), "/"); // 86400 = 1 day
		}
	}
	if(isset($_COOKIE["username"])){
		header('location: my_profile.php');
	}
		if (isset($_POST['register'])){
			$username = $_POST["username"];
			$fname = $_POST["firstname"];
			$lname = $_POST["lastname"];
			$email = $_POST["email"];
			$password = $_POST["password"];
			$confirmPassword = $_POST["confirm_password"];
			if ($password != $confirmPassword) {
				echo("Error! Passwords do not match!");
			}
			else if (strlen($password) < 4) {
					echo("Error! Password is less than 4 characters!");
				}
			else
			{
				if ($username == "" OR $fname == "" OR $lname == "" OR $email == "") {
					echo("Error! Blank Fields!");
				}
				else if ($username == " " OR $fname == " " OR $lname == " " OR $email == " ") {
					echo("Error! Only Spaces Detected!");
				}
				else {
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
													include 'connection.php';
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
													if (confirm('Success! Your username is: $resUsername. Your password is: $resPassword')) {
													  window.location.href = 'index.php#home';
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
									}
									else { // If no usernames are in USER_ACCOUNT, this function activates!
										function insertData() // Use this function to insert user details into user table!
										{
											try
											{
												include 'connection.php';
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
													echo("<p>ERROR AT LINE 216!</p>");
													die(print_r(sqlsrv_errors(), true));
												}
												sqlsrv_execute($preparedStatement);
												setcookie("username", $resUsername, time() + (86400 * 30), "/"); // 86400 = 1 day
													echo("<script>
													if (confirm('Success! Your username is: $resUsername. Your password is: $resPassword')) {
													  window.location.href = 'index.php#home';
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
		  <table width="230" border="0" cellpadding="2" cellspacing="0" id="registration_form">
			<tbody>
			  <tr>
				<td width="95">
				  <div align="right" id="bold">Username:</div>
				</td>
				<td width="171">
				  <input type="text" name="username" id="username" required="">
				</td>
			  </tr>
			  <tr>
				<td width="95">
				  <div align="right" id="bold">First Name:</div>
				</td>
				<td width="171">
				  <input type="text" name="firstname" id="firstname" required="">
				</td>
			  </tr>
			  <tr>
				<td width="95">
				  <div align="right" id="bold">Last Name:</div>
				</td>
				<td width="171">
				  <input type="text" name="lastname" id="lastname" required="">
				</td>
			  </tr>
			  <tr>
				<td width="95">
				  <div align="right" id="bold">Email:</div>
				</td>
				<td width="171">
				  <input type="email" name="email" id="email" required="">
				</td>
			  </tr>
			  <tr>
				<td width="95">
				  <div align="right" id="bold">Password:</div>
				</td>
				<td width="171">
				  <input type="password" name="password" id="password" required="">
				</td>
			  </tr>
			  <tr>
				<td width="95">
				  <div align="right" id="bold">Confirm_Password:</div>
				</td>
				<td width="171">
				  <input type="password" name="confirm_password" id="confirm_password">
				</td>
			  </tr>
			</tbody>
		  </table>
		  <input type="submit" value="Submit" class="button" id="register_new_button" name="register" onclick="blankFields()">
		</form>
	<h1></h1>
  </main>

  <footer>
	<p></p>
  </footer>
</body>
</html>

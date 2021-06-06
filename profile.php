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
				var password = document.getElementById("password").value;

        if ((username == '') && (password == '')) {
          alert ("Please enter input in the blank fields!");
				}
				else if (username == '') {
          alert ("Please enter your username!");
				}
        else if (password == '') {
					alert ("Please enter your password!");
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
	if (isset($_POST['loginButton'])){
		$username = $_POST["username"];
		$password = $_POST["password"];
		if ($username == "" OR $password == "") {
			echo("Error! Blank Fields!");
		}
		else
			{
				if ($username == " " OR $password == " ") {
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
									$password = $_POST["password"];
									$resUsername = preg_replace("/[^a-zA-Z0-9]/", "", $username);
									$resPassword = preg_replace("/[^a-zA-Z0-9]/", "", $password);
									$checksql = "EXEC selectUsers";
									$params = array();
									$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
									$sqlStatement = sqlsrv_query($conn, $checksql , $params, $options);
									$row_count = sqlsrv_num_rows($sqlStatement);
									if ($row_count === false)
									   echo("<p>Error in retreiving row count!</p>");

									if ($row_count > 0) {
										$selectSQL = "EXEC selectUsername $resUsername";
										$selectQuery = sqlsrv_query($conn, $selectSQL);
										if(sqlsrv_fetch($selectQuery) === false) {
											die( print_r( sqlsrv_errors(), true));
										}
										else
										{
											$selectUsername = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
											if($selectUsername == $resUsername)
												sqlsrv_execute($selectQuery);
												if(sqlsrv_fetch($selectQuery) === false) {
													echo("<script> alert ('Incorrect username!'); </script>");
													die( print_r( sqlsrv_errors(), true));
												}
												else
												{
													$password = $_POST["password"];
													$resPassword = preg_replace("/[^a-zA-Z0-9]/", "", $password);
													$selectSQL = "DECLARE @returnNumber INT;
														EXEC @returnNumber = selectPassword $resPassword;
														SELECT @returnNumber;";
													$selectQuery = sqlsrv_query($conn, $selectSQL);
													$selectPassword = sqlsrv_has_rows($selectQuery);
													if($selectPassword == True)
													{
														setcookie("username", $resUsername, time() + (86400 * 30), "/"); // 86400 = 1 day
														header('location: my_profile.php');
													}
													else
													{
														echo("<script> alert ('Incorrect password!'); </script>");
													}
												}
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
					openConnection();
				}
			}
		}
   ?>
  <main>
    <h1>Login</h1>
	<figure>
	<img src="images/mailsnow.png" height="200" width="200" id="mailsnow">
	<figcaption>The Mail Coach in a Drift of Snow</figcaption>
	</figure>
	<figure id="quicksilver">
	<img src="images/quicksilver.jpg" height="200" width="200" id="quicksilver">
	<figcaption>Mail Coaches on the Road: "Quicksilver"</figcaption>
	</figure>
	  <title>Login</title>
	    <form name="loginType" action="profile.php" onsubmit="login_button" method="post" id="loginForm">
		  <table width="230" border="0" cellpadding="2" cellspacing="0" id="loginForm">
			<tbody>
			  <tr>
				<td width="95">
				  <div align="right" id="bold">Username:</div>
				</td>
				<td width="171">
				  <input type="text" name="username" id="username">
				</td>
			  </tr>
			  <tr>
				<td width="95">
				  <div align="right" id="bold">Password:</div>
				</td>
				<td width="171">
				  <input type="password" name="password" id="password">
				</td>
			  </tr>
			</tbody>
		  </table>
		  <input type="submit" value="Submit" class="button" id="login_button" name="loginButton" onclick="blankFields()">
		</form>
	<!-- <button class="button">Login</button> -->
	<h2 id="profile_register_question">Need to register?</h2>
	<a href="registration.php" class="button" role="button">
	  <button class="button" id="register_button">Register</button>
	</a>
<!--	<form name="feedback_form" action="mailto:jataylor978@gmail.com" method="post">
		<textarea name="feedback" required></textarea><br><br>
		<input type="submit" name="submit" id="button" value="Submit">
	</form>
-->
	<h1></h1> <!-- Adds space before footer -->
  </main>

  <footer>
	<p></p>
  </footer>
</body>
</html>

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
			else if (username.contains(" ") || password.contains(" ")) {
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
	if (isset($_POST['registerButton'])){
		header('location: registration.php');
		die();
	}
	if (isset($_POST['loginButton'])){
		$username = $_POST["username"];
		$password = $_POST["password"];
		if ($username == "" OR $password == "") {
			header('location: profile.php');
		}
		else
			{
				if ($username == " " OR $password == " ") {
					header('location: profile.php');
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
	  <form name="loginType" action="profile.php" onsubmit="login_button" method="post">
		  <table id="login_table" width="230" border="0" cellpadding="2" cellspacing="0">
			<tbody>
			  <tr>
				<td width="95">
				  <div align="right" id="bold" style="margin-bottom: 5px;">Username:</div>
				</td>
				<td width="171">
				  <input type="text" name="username" id="username">
				</td>
			  </tr>
			  <tr>
				<td width="95">
				  <div align="right" id="bold" style="margin-bottom: 5px;">Password:</div>
				</td>
				<td width="171">
				  <input type="password" name="password" id="password">
				</td>
			  </tr>
			</tbody>
		  </table>
			<h2></h2> <!-- Empty Space -->
		  <input type="submit" value="Login" class="button" id="login_button" name="loginButton" onclick="blankFields()">
			<h2>Don't have an account? Sign up below!</h2>
			<h2></h2> <!-- Empty Space -->
			<input type="submit" value="Register" class="button" id="register_button" name="registerButton" onclick="redirectRegister()">
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

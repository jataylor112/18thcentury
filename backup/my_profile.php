<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>The Long 18th Century</title>
	<link rel="stylesheet" href="styles/normalize.css">
	<link rel="stylesheet" href="styles/profile.css">
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="icon" type="image/gif" href="images/animated_favicon1.gif">
</head>

<body>
  <header>
    <h2 id="header"><a href="index.php"><center>The Long 18th Century<center></a></h2>
	<script type="text/javascript" src="my_profile.js"></script>
	<h3><center>The European Era of <a href="/project/nations_empires.php">Empire</a> and <a href="/project/science_movements.php">Enlightenment</a></center></h3>
  </header>
 <p>
  <nav id="topbar">
  <ul>
	<li><a href="index.php">Home - Introduction</a></li>
	<li><a href="nations_empires.php">Nations | Empires</a></li>
	<li><a href="piracy_conflicts.php">Piracy | Conflicts</a></li>
	<li><a href="science_movements.php">Science | Movements</a></li>
	<li><a href="my_profile.php" class="current">Profile</a><br></li>
  </ul></p><br><br><br>
  </nav>
<?php
	if(!isset($_COOKIE["acknowledgement"])){
		echo("<div class='cookie_banner' id='cookie_banner'>");
		echo("<p>By using our website, you agree to our <a href='cookie_policy.html' style='color: red'>cookie policy</a>.</p>");
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
	    <form name="login" action="__.php" onsubmit="__" method="post" id="">
		  <table width="230" border="0" cellpadding="2" cellspacing="0" id="login_form">
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
	<h1></h1>
	<form action="my_profile.php" method="post">
		<input type="submit" value="Edit Profile" class="button" id="edit_button" name="submitEdit" style="text-align: center">
	</form>
	<form action="my_profile.php" method="post">
	  <input type="submit" value="Logout" class="button" id="logout_button" name="submit">
	</form>
<!--
	<a href="my_profile_edit.php" class="button" role="button">
	  <button class="button" id="edit_button">Edit Profile</button>
	</a>
-->
  </main>

  <footer>
	<p></p>
  </footer>
</body>
</html>

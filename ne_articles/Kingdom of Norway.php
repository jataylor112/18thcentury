<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>The Long 18th Century</title>
	<link rel="stylesheet" href="/project/styles/normalize.css">
	<link rel="stylesheet" href="/project/styles/main.css">
	<link rel="shortcut icon" href="/project/images/favicon.ico">
</head>

<body>
  <header>
    <h2 id="header"><a href="/project/index.php"><center>The Long 18th Century<center></a></h2>
	<script>
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
		document.getElementById("header").style.fontSize = "30px";
	} else {
		document.getElementById("header").style.fontSize = "70px";
	}
	}
	function redirect() {
        window.location.replace('editArticle.php');
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
	<h3><center>The European Era of <a href="/project/nations_empires.php">Empire</a> and <a href="/project/science_movements.php#science_movements_home">Enlightenment</a></center></h3>
  </header>
 <p>
  <nav id="topbar">
  <ul>
	<li><a href="/project/index.php">Home - Introduction</a></li>
	<li><a href="/project/nations_empires.php">Nations | Empires</a></li>
	<li><a href="/project/piracy_conflicts.php">Piracy | Conflicts</a></li>
	<li><a href="/project/science_movements.php">Science | Movements</a></li>
	<li><a href="/project/my_profile.php">Profile</a><br></li>
  </ul></p><br><br><br>
  </nav>
<?php
	if(!isset($_COOKIE["acknowledgement"])){
		echo("<div class='cookie_banner' id='cookie_banner'>");
		echo("<p style='color: green'>By using our website, you agree to our <a href='cookie_policy.html' style='color: red'>cookie policy</a>.</p>");
		echo("<button class='close' id='cookie_button' name='cookie_button' onclick='fadeOutEffect()'>&times;</button>");
		echo("</div>");
		if(array_key_exists('cookie_button', $_POST)) {
			setcookie("acknowledgement", 1, time() + (86400 * 30), "/"); // 86400 = 1 day
		}
	}
?>
  <main>
	  <title>Article Description</title>
	    <form name="article">
		  <table width="80%" border="0" cellpadding="2" cellspacing="0" style="margin-left:auto;margin-right:auto;">
		    <tbody>
			  <tr>
				<?php
				function openConnection() // Opens connection to server
				{
					try
					{
						include 'C:/xampp/htdocs/project/connection.php';
						$connectionOptions = array("Database"=>$databaseName,
							"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
						$conn = sqlsrv_connect($serverName, $connectionOptions);
						if($conn == false)
							die("<h1>Could not connect to database!</h1>");
						if($conn == true)
							try
							{
								$article_ID = "1";
								$selectSQL = "EXEC selectArticle $article_ID";
								$selectQuery = sqlsrv_query($conn, $selectSQL);
								if(sqlsrv_fetch($selectQuery) === false) {
									die( print_r( sqlsrv_errors(), true));
								}
								else
								{
									$aname = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
									echo("<td><h1>" . $aname . "</h1></td>");
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
			  <tr><td><h1></h1></td></tr> <!-- Empty space between title and body -->
			  <tr>
				<?php
				function openConnectionEntry() // Opens connection to server
				{
					try
					{
						include 'C:/xampp/htdocs/project/connection.php';
						$connectionOptions = array("Database"=>$databaseName,
							"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
						$conn = sqlsrv_connect($serverName, $connectionOptions);
						if($conn == false)
							die("<h1>Could not connect to database!</h1>");
						if($conn == true)
							try
							{
								$article_ID = "1";
								$selectSQL = "EXEC selectEntry $article_ID";
								$selectQueryEntry = sqlsrv_query($conn, $selectSQL);
								echo("<td>");
								while($row = sqlsrv_fetch_array($selectQueryEntry, SQLSRV_FETCH_NUMERIC)) {
										echo("<p>" . $row[0] . "</p><br>");
								}
								echo("</td>");
								sqlsrv_free_stmt($selectQueryEntry);
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
				openConnectionEntry();
				?>
			  </tr>
			  <tr><td><h2>References</h3></td></tr>
			  <tr>
				<?php
					function openConnectionReference() // Opens connection to server
					{
						try
						{
							include 'C:/xampp/htdocs/project/connection.php';
							$connectionOptions = array("Database"=>$databaseName,
								"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
							$conn = sqlsrv_connect($serverName, $connectionOptions);
							if($conn == false)
								die("<h1>Could not connect to database!</h1>");
							if($conn == true)
								try
								{
									$article_ID = "1";
									$selectSQL = "EXEC selectReference $article_ID";
									$selectQueryReference = sqlsrv_query($conn, $selectSQL);
									echo("<td>");
									while($row = sqlsrv_fetch_array($selectQueryReference, SQLSRV_FETCH_NUMERIC)) {
										echo("<p>" . $row[0] . "</p><br>");
									}
									echo("</td>");
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
					openConnectionReference();
				?>
			  </tr>
			  <tr>   <!-- Displays author of the article -->
				<?php
					function openConnectionUser() // Opens connection to server
					{
						try
						{
							include 'C:/xampp/htdocs/project/connection.php';
							$connectionOptions = array("Database"=>$databaseName,
								"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
							$conn = sqlsrv_connect($serverName, $connectionOptions);
							if($conn == false)
								die("<h1>Could not connect to database!</h1>");
							if($conn == true)
								try
								{
									$article_ID = "1";
									$selectSQL = "EXEC selectUserCreator $article_ID";
									$selectQuery = sqlsrv_query($conn, $selectSQL);
									if(sqlsrv_fetch($selectQuery) === false) {
										die( print_r( sqlsrv_errors(), true));
									}
									else
									{
										$creator = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
										echo("<td style='font-weight:bold'>This article was originally created by ".$creator.".</td>");
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
					openConnectionUser();
				?>
			  </tr>
			</tbody>
		  </table>
	    </form>

	<?php
		if (isset($_POST['submit'])){
			if(!isset($_COOKIE["username"])){
				echo("<script> if (confirm('You are not registered to edit an article! Would you like to go to the login page where you can register?')) {
					window.location.replace('/project/profile.php');
				} else {
					window.location.replace('/project/index.php');
				} </script>");
			}
			else
			{
				function openConnectionEditLink() // Opens connection to server
				{
					try
					{
						include 'C:/xampp/htdocs/project/connection.php';
						$connectionOptions = array("Database"=>$databaseName,
							"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
						$conn = sqlsrv_connect($serverName, $connectionOptions);
						if($conn == false)
							die("<h1>Could not connect to database!</h1>");
						if($conn == true)
							try
							{
								$article_ID = "1";
								$selectSQL = "EXEC selectArticle $article_ID";
								$selectQuery = sqlsrv_query($conn, $selectSQL);
								if(sqlsrv_fetch($selectQuery) === false) {
									die( print_r( sqlsrv_errors(), true));
								}
								else
								{
									$articleTitleResult = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
									$selectSQL = "EXEC selectEntry $article_ID";
									$selectQueryEntry = sqlsrv_query($conn, $selectSQL);
									$entriesResult = "";
									while($row = sqlsrv_fetch_array($selectQueryEntry, SQLSRV_FETCH_NUMERIC)) {
											$entriesResult = $entriesResult . $row[0];
									}
									sqlsrv_free_stmt($selectQueryEntry);
									$selectSQL = "EXEC selectSpecificReferences $article_ID";
									$selectQuery = sqlsrv_query($conn, $selectSQL);
									if(sqlsrv_fetch($selectQuery) === false) {
										die( print_r( sqlsrv_errors(), true));
									}
									else
									{
										$selectSQL = "EXEC selectReference $article_ID";
										$selectQueryReference = sqlsrv_query($conn, $selectSQL);
										$referencesResult = "";
										while($row = sqlsrv_fetch_array($selectQueryReference, SQLSRV_FETCH_NUMERIC)) {
											$referencesResult = $referencesResult . $row[0];
										}
										$selectSQL = "EXEC selectUserCreator $article_ID";
										$selectQuery = sqlsrv_query($conn, $selectSQL);
										if(sqlsrv_fetch($selectQuery) === false) {
											die( print_r( sqlsrv_errors(), true));
										}
										else
										{
											$creatorResult = sqlsrv_get_field($selectQuery, 0);
											$filename = "variables.php";
											$articleIDResult = '$articleIDResult';
											$articleTitle = '$articleTitleResult';
											$entries = '$entries';
											$references = '$references';
											$author = '$author';
											$data = ("<!DOCTYPE html>;
											<html lang='en'>
											  <?php
												$articleIDResult = '$article_ID';
												$articleTitle = '$articleTitleResult';
												$entries = '$entriesResult';
												$references = '$referencesResult';
												$author = '$creatorResult';
											   ?>
											</html>");
											file_put_contents($filename, $data);
											header("location: editArticle.php");
										}
									}
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
				openConnectionEditLink();
			}
		}
	?>
	<form onsubmit="submit_button" method="post">
	<aside>
    <ul>
    	<li style="background-color: black; border-color: #228B22; border-width: 4px;"><input type="submit" value="Want to edit this article?" class="button" id="submit_button" name="submit"></li>
    </ul>
	</aside>
	</form>
	<h1></h1>
  </main>

  <footer>
	<p></p>
  </footer>
</body>
</html>

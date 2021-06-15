<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>The Long 18th Century</title>
	<link rel="stylesheet" href="/18thcentury/styles/normalize.css">
	<link rel="stylesheet" href="/18thcentury/styles/main.css">
	<link rel="shortcut icon" href="/18thcentury/images/favicon.ico">
</head>

<body>
  <header>
		<p><nav id="topbar">
		<ul>
		<li><a href="/18thcentury/nations.php">Nations</a></li>
		<li><a href="/18thcentury/conflicts.php">Conflicts</a></li>
		<li><a href="/18thcentury/index.php" class="current">Long 18th Century</a></li>
		<li><a href="/18thcentury/science.php">Science</a></li>
		<li><a href="/18thcentury/profile.php">Profile</a><br></li>
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
						include 'C:/xampp/htdocs/18thcentury/connection.php';
						$connectionOptions = array("Database"=>$databaseName,
							"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
						$conn = sqlsrv_connect($serverName, $connectionOptions);
						if($conn == false)
							die("<h1>Could not connect to database!</h1>");
						if($conn == true)
							try
							{
								$article_ID = "{article_ID}";
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
						include 'C:/xampp/htdocs/18thcentury/connection.php';
						$connectionOptions = array("Database"=>$databaseName,
							"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
						$conn = sqlsrv_connect($serverName, $connectionOptions);
						if($conn == false)
							die("<h1>Could not connect to database!</h1>");
						if($conn == true)
							try
							{
								$article_ID = "{article_ID}";
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
							include 'C:/xampp/htdocs/18thcentury/connection.php';
							$connectionOptions = array("Database"=>$databaseName,
								"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
							$conn = sqlsrv_connect($serverName, $connectionOptions);
							if($conn == false)
								die("<h1>Could not connect to database!</h1>");
							if($conn == true)
								try
								{
									$article_ID = "{article_ID}";
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
							include 'C:/xampp/htdocs/18thcentury/connection.php';
							$connectionOptions = array("Database"=>$databaseName,
								"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
							$conn = sqlsrv_connect($serverName, $connectionOptions);
							if($conn == false)
								die("<h1>Could not connect to database!</h1>");
							if($conn == true)
								try
								{
									$article_ID = "{article_ID}";
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
					window.location.replace('/18thcentury/profile.php');
				} else {
					window.location.replace('/18thcentury/index.php');
				} </script>");
			}
			else
			{
				function openConnectionEditLink() // Opens connection to server
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
								$article_ID = "{article_ID}";
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
	&nbsp; <!-- Empty Space -->
	<form onsubmit="submit_button" method="post">
	<input type="submit" value="Want to edit this article?" class="button" id="createArticle" onclick="redirect()" id="submit_button" name="submit"
				style="float: left">
				&nbsp; <!-- Empty Space -->
				&nbsp; <!-- Empty Space -->
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

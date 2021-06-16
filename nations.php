<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>The Long 18th Century</title>
	<link rel="stylesheet" href="/18thcentury/styles/normalize.css">
	<link rel="stylesheet" href="/18thcentury/styles/main.css">
	<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
	<link rel="shortcut icon" href="/18thcentury/images/favicon.ico">
</head>

<body>
  <header>
		<p><nav id="topbar">
		<ul>
		<li><a href="/18thcentury/nations.php" class="current">Nations</a></li>
		<li><a href="/18thcentury/conflicts.php">Conflicts</a></li>
		<li><a href="/18thcentury/index.php">Long 18th Century</a></li>
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
	function redirectCheck() {
		if (confirm('You are not registered to make an article! Would you like to go to the login page where you can register?')) {
			window.location.replace('/18thcentury/profile.php');
		} else {
			window.location.replace('nations.php');
		}
	}
	function redirectSuccess() {
		window.location = "creation.php";
	}
	</script>
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
	<h3 id="europeanSentence">The European Era of <a href="/18thcentury/nations.php">Empire</a> and <a href="/18thcentury/science.php">Enlightenment</a></h3>
	</header>

  <main>
  <h1 id="nations_home" >Nations</h1>
	<?php
	if(isset($_COOKIE["username"])){
		echo("<input type='submit' value='Want to create a new article?' class='button' id='createArticle' onclick='redirectSuccess()' id='link'>");
	}
	else {
		echo("<input type='submit' value='Want to create a new article?' class='button' id='createArticle' onclick='redirectCheck()' id='link'>");
	}
	?>
	<!-- <input type="submit" value="Want to create a new article?" class="button" id="createArticle" onclick="redirectCheck()" id="link"> -->
	<table width="230" border="0" cellpadding="2" cellspacing="0" style="margin-left:auto; margin-right:auto;">
	  <tbody>
	<?php
	function openConnection() // Opens connection to server
	{
		try
		{
			include 'C:/xampp/htdocs/connection.php';
			$connectionOptions = array("Database"=>$databaseName,
				"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
			$conn = sqlsrv_connect($serverName, $connectionOptions);
			if($conn == false) {
				die("<h1>Could not connect to database!</h1>");
			}
			if($conn == true) {
				try
				{
						$categoryPage = 'nations';
						$selectSQL = "EXEC selectArticleLinks $categoryPage";
						$selectQuery = sqlsrv_query($conn, $selectSQL);
						if(sqlsrv_fetch($selectQuery) === false) {
							die( print_r( sqlsrv_errors(), true));
						}
						else
						{
							$selectSQLTotal = "EXEC selectTotalArticleLinks $categoryPage";
							$selectQueryTotal = sqlsrv_query($conn, $selectSQLTotal);
							if(sqlsrv_fetch($selectQueryTotal) === false) {
								die( print_r( sqlsrv_errors(), true));
							}
							else
							{
								$x = 0;
								$row_count = sqlsrv_get_field($selectQueryTotal, 0);
								while ($x < $row_count) {
									if ($x == 0) {
										$link = sqlsrv_get_field($selectQuery, $x); // 0 is the first row in result set
										$linkFormatted = "'" . $link . "'";
										$selectArticle = "EXEC selectArticleTitle $linkFormatted";
										$selectTitleQuery = sqlsrv_query($conn, $selectArticle);
										if(sqlsrv_fetch($selectTitleQuery) === false) {
											die( print_r( sqlsrv_errors(), true));
										}
										else {
											$articleTitle = sqlsrv_get_field($selectTitleQuery, 0); // 0 is the first row in result set
											echo("<tr><td><h2><a href='" . $link . "' style='color: #000000; font-family: Lucida Handwriting, Times New Roman;'>$articleTitle</a></h2></td></tr>");
										}
									}
									$link = "";
									while( $obj = sqlsrv_fetch_object( $selectQuery)) {
							      //$obj->link;
										$link = print_r($obj->link, 1);
										$linkFormatted = "'" . $link . "'";
										$selectArticle = "EXEC selectArticleTitle $linkFormatted";
										$selectTitleQuery = sqlsrv_query($conn, $selectArticle);
										if(sqlsrv_fetch($selectTitleQuery) === false) {
											die( print_r( sqlsrv_errors(), true));
										}
										else {
											$articleTitle = sqlsrv_get_field($selectTitleQuery, 0); // 0 is the first row in result set
											echo("<tr><td><h2><a href='" . $link . "' style='color: #000000; font-family: Lucida Handwriting, Times New Roman;'>$articleTitle</a></h2></td></tr>");
										}
									}
									$x += 1;
								}
							}
						}
					}
					catch(Exception $e)
					{
						echo("Error!");
						sqlsrv_close($conn);
					};
				}
				sqlsrv_close($conn);
			}
			catch(Exception $e)
			{
				echo("Error!");
				sqlsrv_close($conn);
			};
	}
	openConnection();
	?>
	  </tbody>
	</table>
  &nbsp; <!-- Space between articles and carousel slider -->
  </main>
	<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
	<div class="carousel" style="z-index: -1;"
  data-flickity='{ "imagesLoaded": true, "percentPosition": false, "autoPlay": 4500,
	"cellAlign": "left", "wrapAround": true, "pageDots": false, "prevNextButtons": false }'>
		<img src="./images/ne_slider/catherine_coronation.jpg" alt="Catherine the Great on the Throne of Russia" />
		<img src="./images/ne_slider/capricewithapalace.jpg" alt="The Battle of Poltava" />
		<img src="./images/ne_slider/frederick_the_second.jpg" alt="Frederick the Great of Prussia" />
		<img src="./images/ne_slider/forcing_the_hudson_river_passage.jpg" alt="Forcing a Passage of the Hudson" />
	</div>
	<footer>
		<table style="margin-left: auto; margin-right: auto; border-spacing: 10px; border-collapse: separate">
			<tr><td><a href="/18thcentury/cookie_policy.html">Cookie Policy</a></td>
			<td><a href="/18thcentury/contact.php">Contact</a></td></tr>
		</table>
  </footer>
</body>
</html>

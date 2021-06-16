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
		<li><a href="/18thcentury/nations.php">Nations</a></li>
		<li><a href="/18thcentury/conflicts.php" class="current">Conflicts</a></li>
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
			window.location.replace('conflicts.php');
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
  <h1 id="conflicts_home" >Conflicts</h1>
	<?php
	if(isset($_COOKIE["username"])){
		echo("<input type='submit' value='Want to create a new article?' class='button' id='createArticle' onclick='redirectSuccess()' id='link'>");
	}
	else {
		echo("<input type='submit' value='Want to create a new article?' class='button' id='createArticle' onclick='redirectCheck()' id='link'>");
	}
	?>
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
								$categoryPage = 'conflicts';
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
	<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
	<div class="carousel" style="z-index: -1;"
  data-flickity='{ "imagesLoaded": true, "percentPosition": false, "autoPlay": 4500,
"cellAlign": "left", "wrapAround": true, "pageDots": false, "prevNextButtons": false }'>
  <img src="./images/pc_slider/battle_denain_jean_alaux.jpg" alt="The Battle of Denain" />
  <img src="./images/pc_slider/battlepoltava.jpg" alt="The Battle of Poltava" />
  <img src="./images/pc_slider/captureblackbeard.jpg" alt="The Battle for Blackbeard's Capture" />
	<img src="./images/pc_slider/bombardment_of_algiers.jpg" alt="The Bombardment of Algiers in 1816" />
<!--
    <p style="text-align: center">The 18th century was home to various amounts of ramphage and engagements that shaped the foundation of the post-modern world.
	From the continental shifts of warring powers to reform in battle formations, the globe was drastically altered!
	Never before in history have the ramifications of a monarch's command stretched to every corner of the globe; this was in large
	part due to the massive expansion of imperial possessions carved in the previous era.</p>
	<p style="text-align: center">In this section, all piracy and conflicts of inter-European affairs are discussed and analyized.
	For national conflicts, go to "<a href="nations.html" id="nations">Nations</a>" then click
	on your nation of choice!</p>
	<h2 id="wars"><a href="covered_what.html">Wars</a></h2>
	<h2><a href="email.html">Piracy</a></h2>
	<h2 id="rivalry"><a href="index.html">Rivalry</a></h2>
	<nav id="conflicts_list">
			<p id="wars">-</p>
			<p id="piracy">-</p>
			<p id="rivalry">-</p>
-->
  </main>

	<footer>
		<table style="margin-left: auto; margin-right: auto; border-spacing: 10px; border-collapse: separate">
			<tr><td><a href="/18thcentury/cookie_policy.html">Cookie Policy</a></td>
			<td><a href="/18thcentury/contact.php">Contact</a></td></tr>
		</table>
  </footer>
</body>
</html>

<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>The Long 18th Century</title>
	<link rel="stylesheet" href="styles/normalize.css">
	<link rel="stylesheet" href="styles/main.css">
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="icon" type="image/gif" href="images/animated_favicon1.gif">
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
	<h3><center>The European Era of <a href="/project/nations_empires.php">Empire</a> and <a href="/project/science_movements.php">Enlightenment</a></center></h3>
  </header>
 <p>
  <nav id="topbar">
  <ul>
	<li><a href="index.php">Home - Introduction</a></li>
	<li><a href="nations_empires.php">Nations | Empires</a></li>
	<li><a href="piracy_conflicts.php">Piracy | Conflicts</a></li>
	<li><a href="science_movements.php" class="current">Science | Movements</a></li>
	<li><a href="profile.php">Profile</a><br></li>
  </ul></p><br><br><br>
  </nav>

  <main>
    <h1 id="science_movements_home"><center>Science | Movements<center></h1>
	<table width="230" border="0" cellpadding="2" cellspacing="0" style="margin-left:auto;margin-right:auto;">
	  <tbody>

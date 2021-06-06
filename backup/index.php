<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>The Long 18th Century</title>
	<link rel="stylesheet" href="styles/normalize.css">
	<link rel="stylesheet" href="styles/main.css">
	<link rel="stylesheet" href="src/App.css">
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="icon" type="image/gif" href="images/animated_favicon1.gif">
</head>

<body>
  <header>
    <h2 id="header"><a href="index.php">The Long 18th Century</a></h2>
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
		  window.location.replace('/project/my_profile_edit.php');
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
	<li><a href="index.php" class="current">Home - Introduction</a></li>
	<li><a href="nations_empires.php">Nations | Empires</a></li>
	<li><a href="piracy_conflicts.php">Piracy | Conflicts</a></li>
	<li><a href="science_movements.php">Science | Movements</a></li>
	<li><a href="profile.php">Profile</a><br></li>
  </ul></p><br><br><br>
  </nav>

  <main>
		<div id="reactElement"></div>
		<div id="App"></div>
		<!-- <script id="App"></script> -->
    <h1><center id="home">What is the "Long 18th Century"?<center></h1>
	<h3>The term centers around the historical era of 1660-1830, originally coined by British historians
	regarding the timeline of Great Britain between 1688-1815.</h3>
	<h3>This website catalogs and analyzes the wider European era with in-depth analysis and records.</h3>
  </main>

  <footer>
	<p></p>
  </footer>
	<!-- Load React -->
  <!-- Note: when deploying, replace "development.js" with "production.min.js" -->
  <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>

  <!-- Load the React component -->
  <script src="main.js"></script>
	<script type="text/javascript" src="src/App.js"></script>
</body>
</html>

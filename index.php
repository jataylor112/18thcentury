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
  <h1 id="home">What is the "Long 18th Century"?</h1>
	<h3>The term centers around the historical era of 1660-1830, originally coined by British historians
	regarding the timeline of Great Britain between 1688-1815.</h3>
	<h3>This website catalogs and analyzes the wider European era across varous subjects.</h3>
	<h3 id="underline">This website is designed to exhibit various web and back-end technologies as a portfolio.</h3>
	&nbsp; <!-- Space between articles and carousel slider -->

	<!-- Flickity HTML init -->
	<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
	<!-- z-index represents the stack order of one element over the other. "-1" makes this element underlap the cookie popup for this situation if used! -->
	<div class="carousel" style="z-index: -1; width: 100%; height: 40%;"
  data-flickity='{ "imagesLoaded": true, "percentPosition": false, "autoPlay": 4500,
	"cellAlign": "left", "wrapAround": true, "pageDots": false, "prevNextButtons": false }'>
		<img src="./images/index_slider/marie_gabrielle_PORTRAIT.jpg" alt="Portrait of Marie Gabrielle" />
	  <img src="./images/index_slider/foundingofaustralia.jpg" alt="The first British colony of Australia" />
	  <img src="./images/index_slider/napoleon_bridge.jpg" alt="Napoleon at the Battle of Arcole" />
		<img src="./images/index_slider/the_proposal.jpg" alt="The Proposal" />
		<img src="./images/index_slider/siege_of_pensacola.jpg" alt="The Siege of Pensacola" />
	  <img src="./images/index_slider/hmscharlotte.jpg" alt="Lord Howe on the desk of HMS Queen Charlotte" />
	</div>
  </main>

  <footer>
		<table style="margin-left: auto; margin-right: auto; border-spacing: 10px; border-collapse: separate">
			<tr><td><a href="/18thcentury/cookie_policy.html">Cookie Policy</a></td>
			<td><a href="/18thcentury/contact.php">Contact</a></td></tr>
		</table>
  </footer>

</body>
</html>

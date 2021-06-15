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
			document.cookie = 'acknowledgement = 1';
		}
		function blankFields() {
			var firstname = document.getElementById("firstname").value;
			var lastname = document.getElementById("lastname").value;
			var email = document.getElementById("email").value;
			var message = document.getElementById("message").value;

			if ((firstname == '') && (lastname == '') && (email == '') && (message == '')) {
					alert ("Please enter input in the blank fields!");
			}
			else if (firstname == '') {
					alert ("Please enter your first name!");
			}
			else if (lastname == '') {
					alert ("Please enter your last name!");
			}
			else if (email == '') {
					alert ("Please enter your email!");
			}
			else if (message == '') {
					alert ("Please enter your message!");
			}
			else if (firstname.contains(" ") || lastname.contains(" ") || email.conains(" ")
			|| message.contains(" ")) {
				alert ("Error! Spaces Detected!");
			}
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
  <h1>Contact Me!</h1>
	<h3>Questions about the website? Interested in discussing web development?</h3>
	&nbsp; <!-- Empty Space -->
	<figure>
	<img src="images/mailsnow.png" height="200" width="200" id="mailsnow">
	<figcaption>The Mail Coach in a Drift of Snow</figcaption>
	</figure>
	<figure id="quicksilver">
	<img src="images/quicksilver.jpg" height="200" width="200" id="quicksilver">
	<figcaption>Mail Coaches on the Road: "Quicksilver"</figcaption>
	</figure>
	  <title>Contact</title>
		<form name="feedback_form" action="contact.php" method="post">
			<table width="320" border="0" cellpadding="2" cellspacing="0" id="contact_table">
				<tbody>
				  <tr>
					<td width="200">
					  <div align="right" id="bold" style="margin-bottom: 5px;">Name:</div>
					</td>
					<td width="171">Jarrett Taylor</td>
				  </tr>
				  <tr>
					<td width="200">
					  <div align="right" id="bold" style="margin-bottom: 5px;">Email:</div>
					</td>
					<td width="171">jataylor978@gmail.com</td>
				  </tr>
				</tbody>
			</table>
			<h1></h1> <!-- Empty Space -->
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

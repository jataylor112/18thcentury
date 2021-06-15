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
		<li><a href="/18thcentury/science.php" class="current">Science</a></li>
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
				var entry = document.getElementById("entry").value;
				var reference = document.getElementById("reference").value;

        if ((entry == '') && (reference == '')) {
          alert ("Please enter input in the blank fields!");
				}
				else if (entry == '') {
					alert ("Please enter the entry!");
				}
				else if (reference == '') {
					alert ("Please enter the reference!");
				}
	}
	</script>
	<h3 id="europeanSentence">The European Era of <a href="/18thcentury/nations.php">Empire</a> and <a href="/18thcentury/science.php">Enlightenment</a></h3>
  </header>
  <?php
		if(!isset($_COOKIE["username"])){
			echo("<script> if (confirm('You are not registered to make an article! Would you like to go to the login page where you can register?')) {
			  window.location.replace('/18thcentury/profile.php');
			} else {
			  window.location.replace('/18thcentury/index.php');
			} </script>");
		}
	for ($x = 0; $x <= 0; $x++) {
		if (isset($_POST['submit'])){
			$username = $_COOKIE["username"];
			$entry = $_POST["entry"];
			$reference = $_POST["reference"];
			if ($entry == "" OR $reference == "") {
				echo("Error! Blank Fields!");
			}
			else if ($entry == " " OR $reference == " ") {
				echo("Error! Only Spaces Detected!");
			}
			else {
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
								$username = $_COOKIE["username"];
								$checksql = "EXEC selectUsers";
								$params = array();
								$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
								$sqlStatement = sqlsrv_query($conn, $checksql , $params, $options);
								$row_count = sqlsrv_num_rows($sqlStatement);
								if ($row_count === false)
								   echo("<p>Error in retreiving row count!</p>");
									//////////////////////////////////////////////////////////////////
									function insertData() // Use this function to insert user details into user table!
									{
										try
										{
											include 'C:/xampp/htdocs/18thcentury/connection.php';
											include 'variables.php';
											$connectionOptions = array("Database"=>$databaseName,
												"Uid"=>$uid, "PWD"=>$pwd);
											$conn = sqlsrv_connect($serverName, $connectionOptions);
											$username = $_COOKIE["username"];
											$entry = $_POST["entry"];
											$reference = $_POST["reference"];
											$resEntry = preg_replace("/[^a-zA-Z0-9äöüÄÖÜ\s\,.!?&$\]]/", "", $entry);
											$patternsReference = ('@^(http\:\/\/|https\:\/\/)?([a-z0-9][a-z0-9\-]*\.)+[a-z0-9][a-z0-9\-]*$@i');
											$resReference = preg_replace($patterns, "", $reference);
											$resAname = $articleTitleResult;
											$category = "science";
											$currentTime = new DateTime();
											$articleID = $articleIDResult;
											$entryID = "0";

											///////////////////////////////////////////////////////////////////////////////////////////
											$sql = "USE $databaseName EXEC insertEntry ?, ?, ?";
											$preparedStatementEntry = sqlsrv_prepare($conn, $sql, array(&$articleID, &$resEntry, &$reference));
											sqlsrv_execute($preparedStatementEntry);
											///////////////////////////////////////////////////////////////////////////////////////////
											// This determines the correct Entry ID!
											$selectSQL = "EXEC selectLatestEntryID $articleID";
											$selectQuery = sqlsrv_query($conn, $selectSQL);
											if(sqlsrv_fetch($selectQuery) === false) {
												die( print_r( sqlsrv_errors(), true));
											}
											else
											{
												$entryID = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
											}
											///////////////////////////////////////////////////////////////////////////////////////////
											$sql = "USE $databaseName EXEC insertUserEntry ?, ?, ?";
											$preparedStatementUserEntry = sqlsrv_prepare($conn, $sql, array(&$username, &$entryID, &$currentTime));
											if(!$preparedStatementUserEntry) {
												echo("preparedStatementUserEntry isn't working!");
												die(print_r(sqlsrv_errors(), true));
											}
											sqlsrv_execute($preparedStatementUserEntry);
											if(!sqlsrv_execute($preparedStatementUserEntry)) {
												echo("preparedStatementUserEntry isn't working! Execution aborted! ");
												die(print_r(sqlsrv_errors(), true));
											}
											$nations = "nations";
											$conflicts = "conflicts";
											$science = "science";

											if ($category == $nations) {
												echo("<p>$category</p>");
												header("Location: /18thcentury/$nations.php");
												die();
											}
											else if ($category == $conflicts) {
												echo("<p>$category</p>");
												header("Location: /18thcentury/$conflicts.php");
												die();
											}
											else if ($category == $science) {
												echo("<p>$category</p>");
												header("Location: /18thcentury/$science.php");
												die();
											}
											sqlsrv_close($conn);
										}
										catch(Exception $e)
										{
											echo("Error!");
										}
									}
									die(insertData());
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
					};
					sqlsrv_close($conn);
				}
				openConnection();
			}
		}
	}
  ?>
  <main>
    <h1>Article Modification</h1>
	<h3>Only letters, numbers, and punctation marks can be submited in the article's content - Any special characters will be removed in submission!</h3>
	<figure>
	<img src="/18thcentury/images/mailsnow.png" height="200" width="200" id="mailsnow">
	<figcaption>The Mail Coach in a Drift of Snow</figcaption>
	</figure>
	<figure id="quicksilver">
	<img src="/18thcentury/images/quicksilver.jpg" height="200" width="200" id="quicksilver">
	<figcaption>Mail Coaches on the Road: "Quicksilver"</figcaption>
	</figure>
	  <title>New_Article</title>
		<form name="article" action="editArticle.php" onsubmit="article_new_button" method="post" id="article_form">
		  <table border="0" cellpadding="2" cellspacing="0" id="registration_form">
			<tbody id="article_create_table">
			  <tr>
				  <?php
					function openConnectionArticle() // Opens connection to server
					{
						try
						{
							include 'C:/xampp/htdocs/18thcentury/connection.php';
							include	'variables.php';
							$connectionOptions = array("Database"=>$databaseName,
								"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
							$conn = sqlsrv_connect($serverName, $connectionOptions);
							if($conn == false)
								die("<h1>Could not connect to database!</h1>");
							if($conn == true)
								try
								{
									$article_ID = $articleIDResult;
									$selectSQL = "EXEC selectArticle $article_ID";
									$selectQuery = sqlsrv_query($conn, $selectSQL);
									if(sqlsrv_fetch($selectQuery) === false) {
										die( print_r( sqlsrv_errors(), true));
									}
									else
									{
										$aname = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
										echo("<td width='171' style='margin:4 auto;width:90%;text-align:left'><h2>" . $aname . "</h2></td>");
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
					openConnectionArticle();
				  ?>
			  </tr>
			  <tr>
				<?php
					function openConnectionCategory() // Opens connection to server
					{
						try
						{
							include 'C:/xampp/htdocs/18thcentury/connection.php';
							include	'variables.php';
							$connectionOptions = array("Database"=>$databaseName,
								"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
							$conn = sqlsrv_connect($serverName, $connectionOptions);
							if($conn == false)
								die("<h1>Could not connect to database!</h1>");
							if($conn == true)
								try
								{
									$article_ID = $articleIDResult;
									$selectSQL = "EXEC selectCategory $article_ID";
									$selectQuery = sqlsrv_query($conn, $selectSQL);
									if(sqlsrv_fetch($selectQuery) === false) {
										die( print_r( sqlsrv_errors(), true));
									}
									else
									{
										$nations = "nations";
										$conflicts = "conflicts";
										$science = "science";
										$category = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
										if ($category == $nations) {
											echo("<td width='17' style='margin:4 auto;width:90%;text-align:left'><h2>Category: Nations</h2></td>");
										}
										else if ($category == $conflicts) {
											echo("<td width='17' style='margin:4 auto;width:90%;text-align:left'><h2>Category: Conflicts</h2></td>");
										}
										else if ($category == $science) {
											echo("<td width='17' style='margin:4 auto;width:90%;text-align:left'><h2>Category: Science</h2></td>");
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
					openConnectionCategory();
				  ?>
			  </tr>
			  <tr>
				<?php
					function openConnectionEntry() // Opens connection to server
					{
						try
						{
							include 'C:/xampp/htdocs/18thcentury/connection.php';
							include	'variables.php';
							$connectionOptions = array("Database"=>$databaseName,
								"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
							$conn = sqlsrv_connect($serverName, $connectionOptions);
							if($conn == false)
								die("<h1>Could not connect to database!</h1>");
							if($conn == true)
								try
								{
									$article_ID = $articleIDResult;
									$selectSQL = "EXEC selectEntry $article_ID";
									$selectQueryEntry = sqlsrv_query($conn, $selectSQL);
									echo("<td style='margin:0 auto;width:90%;text-align:left'>
									<textarea name='entry' id='entry' rows='60' cols='30'>");
									while($row = sqlsrv_fetch_array($selectQueryEntry, SQLSRV_FETCH_NUMERIC)) {
										foreach ($row as $value) {
											echo $value;
										}
									}
									echo("</textarea></td>");
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
			  <tr>
				<?php
					function openConnectionReference() // Opens connection to server
					{
						try
						{
							include 'C:/xampp/htdocs/18thcentury/connection.php';
							include	'variables.php';
							$connectionOptions = array("Database"=>$databaseName,
								"Uid"=>$uid, "PWD"=>$pwd, "ColumnEncryption"=>"Enabled");
							$conn = sqlsrv_connect($serverName, $connectionOptions);
							if($conn == false)
								die("<h1>Could not connect to database!</h1>");
							if($conn == true)
								try
								{
									$article_ID = $articleIDResult;
									$selectSQL = "EXEC selectReference $article_ID";
									$selectQueryReference = sqlsrv_query($conn, $selectSQL);
									echo("<td style='margin:0 auto;width:90%;text-align:left'>
											<textarea name='reference' id='reference' rows='60' cols='30'>");
									while($row = sqlsrv_fetch_array($selectQueryReference, SQLSRV_FETCH_NUMERIC)) {
										foreach ($row as $value) {
											echo $value;
										}
									}
									echo("</textarea></td>");
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
			</tbody>
		  </table>
		  &nbsp; <!-- Empty Space -->
		  <input type="submit" value="Submit" class="button" id="article_new_button" name="submit" onclick="blankFields()">
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

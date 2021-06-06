<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>The Long 18th Century</title>
	<link rel="stylesheet" href="/project/styles/normalize.css">
	<link rel="stylesheet" href="/project/styles/profile.css">
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
	<h3><center>The European Era of <a href="/project/nations_empires.php">Empire</a> and <a href="/project/science_movements.php#science_movements_home">Enlightenment</a></center></h3>
  </header>
 <p>
  <nav id="topbar">
  <ul>
	<li><a href="/project/index.php">Home - Introduction</a></li>
	<li><a href="/project/nations_empires.php">Nations | Empires</a></li>
	<li><a href="/project/piracy_conflicts.php">Piracy | Conflicts</a></li>
	<li><a href="/project/science_movements.php">Science | Movements</a></li>
	<li><a href="/project/my_profile.php" class="current">Profile</a><br></li>
  </ul></p><br><br><br>
  </nav>
  <?php
		if(!isset($_COOKIE["username"])){
			echo("<script> if (confirm('You are not registered to make an article! Would you like to go to the login page where you can register?')) {
			  window.location.replace('/project/profile.php');
			} else {
			  window.location.replace('/project/index.php');
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
						include 'C:/xampp/htdocs/project/connection.php';
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
											include 'C:/xampp/htdocs/project/connection.php';
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
											$category = "science_movements";
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
											$ne = "nations_empires";
											$pc = "piracy_conflicts";
											$sm = "science_movements";

											if ($category == $ne) {
												echo("<p>$category</p>");
												header("Location: /project/$ne.php");
												die();
											}
											else if ($category == $pc) {
												echo("<p>$category</p>");
												header("Location: /project/$pc.php");
												die();
											}
											else if ($category == $sm) {
												echo("<p>$category</p>");
												header("Location: /project/$sm.php");
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
	<h3>Only letters, numbers, and punctation marks can be submited - Any special characters will be removed in submission</h3>
	<figure>
	<img src="/project/images/mailsnow.png" height="200" width="200" id="mailsnow">
	<figcaption>The Mail Coach in a Drift of Snow</figcaption>
	</figure>
	<figure id="quicksilver">
	<img src="/project/images/quicksilver.jpg" height="200" width="200" id="quicksilver">
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
							include 'C:/xampp/htdocs/project/connection.php';
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
							include 'C:/xampp/htdocs/project/connection.php';
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
										$ne = "nations_empires";
										$pc = "piracy_conflicts";
										$sm = "science_movements";
										$category = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
										if ($category == $ne) {
											echo("<td width='17' style='margin:4 auto;width:90%;text-align:left'><h2>Category: Nations | Empires</h2></td>");
										}
										else if ($category == $pc) {
											echo("<td width='17' style='margin:4 auto;width:90%;text-align:left'><h2>Category: Piracy | Conflicts</h2></td>");
										}
										else if ($category == $sm) {
											echo("<td width='17' style='margin:4 auto;width:90%;text-align:left'><h2>Category: Science | Movements</h2></td>");
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
							include 'C:/xampp/htdocs/project/connection.php';
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
							include 'C:/xampp/htdocs/project/connection.php';
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
		  <h1></h1>
		  <input type="submit" value="Submit" class="button" id="article_new_button" name="submit" onclick="blankFields()">
		</form>
	<h1></h1> <!-- Empy Space -->
  </main>

  <footer>
	<p></p>
  </footer>
</body>
</html>

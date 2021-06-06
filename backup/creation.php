<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>The Long 18th Century</title>
	<link rel="stylesheet" href="styles/normalize.css">
	<link rel="stylesheet" href="styles/profile.css">
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
	function blankFields() {
                var username = document.getElementById("username").value;
                var articleName = document.getElementById("article_title").value;
				var entry = document.getElementById("entry").value;
				var reference = document.getElementById("reference").value;

                if ((username == '') && (articleName == '') && (entry == '') && (reference == '')) {
                    alert ("Please enter input in the blank fields!");
				}
				else if (username == '') {
                    alert ("Please enter your username!");
				}
				else if (articleName == '') {
					alert ("Please enter the name of the article!");
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
	<li><a href="index.php">Home - Introduction</a></li>
	<li><a href="nations_empires.php">Nations | Empires</a></li>
	<li><a href="piracy_conflicts.php">Piracy | Conflicts</a></li>
	<li><a href="science_movements.php">Science | Movements</a></li>
	<li><a href="profile.php">Profile</a><br></li>
  </ul></p><br><br><br>
  </nav>
  <?php
		if(!isset($_COOKIE["username"])){
			echo("<script> if (confirm('You are not registered to make an article! Would you like to go to the login page where you can register?')) {
			  window.location.replace('profile.php');
			} else {
			  window.location.replace('index.php');
			} </script>");
		}
	for ($x = 0; $x <= 0; $x++) {
		if (isset($_POST['submit'])){
			$username = $_COOKIE["username"];
			$aname = $_POST["article_title"];
			$category = $_POST["category"];
			$entry = $_POST["entry"];
			$reference = $_POST["reference"];
				if ($username == "" OR $aname == "" OR $entry == "" OR $reference == "") {
					echo("Error! Blank Fields!");
				}
				else if ($username == " " OR $aname == " " OR $entry == " " OR $reference == " ") {
					echo("Error! Only Spaces Detected!");
				}
				else {
					function openConnection() // Opens connection to server
					{
						try
						{
							include 'connection.php';
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
												include 'connection.php';
												$connectionOptions = array("Database"=>$databaseName,
													"Uid"=>$uid, "PWD"=>$pwd);
												$conn = sqlsrv_connect($serverName, $connectionOptions);
												$username = $_COOKIE["username"];
												$aname = $_POST["article_title"];
												$category = $_POST["category"];
												$entry = $_POST["entry"];
												$reference = $_POST["reference"];
												$resAname = preg_replace("/[^a-zA-Z0-9äöüÄÖÜ \.\]]/", "", $aname);
												$resEntry = preg_replace("/[^a-zA-Z0-9äöüÄÖÜ\s\.\]]/", "", $entry);
												$patterns = ('@^(http\:\/\/|https\:\/\/)?([a-z0-9][a-z0-9\-]*\.)+[a-z0-9][a-z0-9\-]*$@i');
												$resReference = preg_replace($patterns, "", $reference);
												$currentTime = new DateTime();
												$articleID = "0";
												$entryID = "0";

												$sql = "USE $databaseName EXEC insertArticle ?, ?";
												$preparedStatementArticle = sqlsrv_prepare($conn, $sql, array(&$resAname, &$category));
												if(!$preparedStatementArticle) {
													echo("Preparing preparedStatementArticle isn't working!");
													die(print_r(sqlsrv_errors(), true));
												}
												sqlsrv_execute($preparedStatementArticle);
												///////////////////////////////////////////////////////////////////////////////////////////
												// This determines the correct Article ID!
												$selectSQL = "EXEC selectArticleID ?";
												$selectQuery = sqlsrv_query($conn, $selectSQL, array(&$resAname));
												if(sqlsrv_fetch($selectQuery) === false) {
													die( print_r( sqlsrv_errors(), true));
												}
												else
												{
													$articleID = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
												}
												///////////////////////////////////////////////////////////////////////////////////////////
												$sql = "USE $databaseName EXEC insertUserArticle ?, ?, ?";
												$preparedStatementUserArticle = sqlsrv_prepare($conn, $sql, array(&$username, &$articleID, &$currentTime));
												if(!$preparedStatementUserArticle) {
													echo("Preparing preparedStatementUserArticle isn't working!");
													die(print_r(sqlsrv_errors(), true));
												}
												sqlsrv_execute($preparedStatementUserArticle);
												if(!sqlsrv_execute($preparedStatementUserArticle)) {
													echo("Executing preparedStatementUserArticle isn't working!");
													die(print_r(sqlsrv_errors(), true));
												}

												$sql = "USE $databaseName EXEC insertEntry ?, ?, ?";
												$preparedStatementEntry = sqlsrv_prepare($conn, $sql, array(&$articleID, &$resEntry, &$resReference));
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
													echo("Preparing preparedStatementUserEntry isn't working!");
													die(print_r(sqlsrv_errors(), true));
												}
												sqlsrv_execute($preparedStatementUserEntry);
												if(!sqlsrv_execute($preparedStatementUserEntry)) {
													echo("Executing preparedStatementUserEntry isn't working! Execution aborted! ");
													die(print_r(sqlsrv_errors(), true));
												}
												$ne = "nations_empires";
												$pc = "piracy_conflicts";
												$sm = "science_movements";
												//////////////////////////////////////////////////////////////////////////////////////////////////////////
												// This section generates a new article page!
												$templateFile = "template.php";
												$placeholder = "{article_ID}";
												$templateContent = file_get_contents($templateFile);
												$file = "$resAname.php";
												$filePathArticles = "";
												if ($category == $ne) {
													$filePathArticles = "C:/xampp/htdocs/project/ne_articles/";
												}
												else if ($category == $pc) {
													$filePathArticles = "C:/xampp/htdocs/project/pc_articles/";
												}
												else if ($category == $sm) {
													$filePathArticles = "C:/xampp/htdocs/project/sm_articles/";
												}
												$selectSQL = "EXEC selectArticleID ?";
												$selectQuery = sqlsrv_query($conn, $selectSQL, array(&$resAname));
												if(sqlsrv_fetch($selectQuery) === false) {
													die( print_r( sqlsrv_errors(), true));
												}
												else
												{
													$articleNewID = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
													$newArticleFile = str_replace($placeholder, $articleNewID, $templateContent);
													$fileName = $resAname.".php";
													$fp = fopen($filePathArticles.$fileName, "w");
													fwrite($fp, $newArticleFile);
													fclose($fp);
													//////////////////////////////////////////////////////////////////////
													$file = $category . "UPDATE.php";
													$filePath = "";
													if ($category == $ne) {
														$filePath = "/project/ne_articles/" . $fileName;
													}
													else if ($category == $pc) {
														$filePath = "/project/pc_articles/" . $fileName;
													}
													else if ($category == $sm) {
														$filePath = "/project/sm_articles/" . $fileName;
													}
													$data = "<tr><td><h2><a href='$filePath' style='color: #000000'>" . $resAname . "</a></h2></td></tr>";

													file_put_contents($file, $data, FILE_APPEND);


													// To output the final html file:
													if ($category == $ne) {
														$updatePage = file_get_contents('nations_empiresUPDATE.php');
														$filePathArticles = "C:/xampp/htdocs/project/ne_articles/";
													}
													else if ($category == $pc) {
														$updatePage = file_get_contents('piracy_conflictsUPDATE.php');
														$filePathArticles = "C:/xampp/htdocs/project/pc_articles/";
													}
													else if ($category == $sm) {
														$updatePage = file_get_contents('science_movementsUPDATE.php');
														$filePathArticles = "C:/xampp/htdocs/project/sm_articles/";
													}

													$fp = fopen('$category.php', 'w');
													if(!$fp)
													  die('Could not create or open text file for writing!');
													  if(fwrite($fp, $updatePage) === false)
													  die('Could not write to text file!');

													/*
													readfile('nations_empiresBASE.php');
													readfile('update.php');
													readfile('nations_empiresBOTTOM.php');
													*/
												}
												//////////////////////////////////////////////////////////////////////////////////////////////////////////

												if ($category == $ne) {
													echo("<p>$category</p>");
													header("Location: $ne.php");
													die();
												}
												else if ($category == $pc) {
													echo("<p>$category</p>");
													header("Location: $pc.php");
													die();
												}
												else if ($category == $sm) {
													echo("<p>$category</p>");
													header("Location: $sm.php");
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
    <h1>Article Creation</h1>
	<h3>Only letters, numbers, and punctation marks can be submited - Any special characters will be removed in submission</h3>
	<figure>
	<img src="images/mailsnow.png" height="200" width="200" id="mailsnow">
	<figcaption>The Mail Coach in a Drift of Snow</figcaption>
	</figure>
	<figure id="quicksilver">
	<img src="images/quicksilver.jpg" height="200" width="200" id="quicksilver">
	<figcaption>Mail Coaches on the Road: "Quicksilver"</figcaption>
	</figure>
	  <title>New_Article</title>
		<form name="article" action="creation.php" onsubmit="article_new_button" method="post" id="article_form">
		  <table border="0" cellpadding="2" cellspacing="0" id="registration_form">
			<tbody id="article_create_table">
			  <tr>
				<td width="171" style="margin:4 auto;width:90%;text-align:left">
				  <input type="text" name="article_title" placeholder="Name of Article" id="article_title">
				</td>
			  </tr>
			  <tr>
			    <td width="171" style="margin:4 auto;width:90%;text-align:left">
				  <select name="category" id="category">
					<option value="nations_empires" selected>Nations | Empires</option>
					<option value="piracy_conflicts">Piracy | Conflicts</option>
					<option value="science_movements">Science | Movements</option>
				  </select>
				</td>
			  </tr>
			  <tr>
			    <td style="margin:0 auto;width:90%;text-align:left"> <textarea name="entry" id="entry" rows="30" cols="30" placeholder="Article Content"></textarea> </td>
			  </tr>
			  <tr>
			    <td style="margin:0 auto;width:90%;text-align:left"> <textarea name="reference" id="reference" rows="30" cols="30" placeholder="Content References"></textarea> </td>
			  </tr>
			</tbody>
		  </table>
		  <h1></h1>
		  <input type="submit" value="Submit" class="button" id="register_new_button" name="submit" onclick="blankFields()">
		</form>
	<h1></h1> <!-- Empy Space -->
  </main>

  <footer>
	<p></p>
  </footer>
</body>
</html>

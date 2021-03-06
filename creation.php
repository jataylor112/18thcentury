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
        var articleName = document.getElementById("article_title").value;
				var entry = document.getElementById("entry").value;
				var reference = document.getElementById("reference").value;

        if ((articleName == '') && (entry == '') && (reference == '')) {
          alert ("Please enter input in the blank fields!");
				}
				else if ((articleName == " ") || (entry == " ") || (reference == " ")) {
					alert("Error! Only Spaces Detected!");
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
	<h3 id="europeanSentence">The European Era of <a href="/18thcentury/nations.php">Empire</a> and <a href="/18thcentury/science.php">Enlightenment</a></h3>
  </header>
  <?php
		if(!isset($_COOKIE["username"])) {
			echo("<script>
			if (confirm('You are not registered to make an article! Would you like to go to the login page where you can register?')) {
			  window.location.replace('/18thcentury/profile.php');
			} else {
			  window.location.replace('/18thcentury/index.php');
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
					header('location: creation.php');
				}
				else if ($username == " " OR $aname == " " OR $entry == " " OR $reference == " ") {
					header('location: creation.php');
				}
				else {
					function openConnection() // Opens connection to server
					{
						try
						{
							include 'C:/xampp/htdocs/connection.php';
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
												include 'C:/xampp/htdocs/connection.php';
												$connectionOptions = array("Database"=>$databaseName,
													"Uid"=>$uid, "PWD"=>$pwd);
												$conn = sqlsrv_connect($serverName, $connectionOptions);
												$username = $_COOKIE["username"];
												$aname = $_POST["article_title"];
												$category = $_POST["category"];
												$entry = $_POST["entry"];
												$reference = $_POST["reference"];
												$resAname = preg_replace("/[^a-zA-Z0-9????????????\s\,.!?&$\]]/", "", $aname);
												$resEntry = preg_replace("/[^a-zA-Z0-9????????????\s\,.!?&$\]]/", "", $entry);
												$patterns = ('@^(http\:\/\/|https\:\/\/)?([a-z0-9][a-z0-9\-]*\.)+[a-z0-9][a-z0-9\-]*$@i');
												$resReference = preg_replace($patterns, "", $reference);
												$currentTime = new DateTime();
												$articleID = "0";
												$entryID = "0";
												// Category Names
												$nations = "nations";
												$conflicts = "conflicts";
												$science = "science";

												$filePath = "";
												$fileName = $resAname.".php";
												if ($category == $nations) {
													$filePath = "/18thcentury/nations_articles/" . $fileName;
												}
												else if ($category == $conflicts) {
													$filePath = "/18thcentury/conflicts_articles/" . $fileName;
												}
												else if ($category == $science) {
													$filePath = "/18thcentury/science_articles/" . $fileName;
												}

												$sql = "USE $databaseName EXEC insertArticle ?, ?, ?";
												$preparedStatementArticle = sqlsrv_prepare($conn, $sql, array(&$resAname, &$category, &$filePath));
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
												//////////////////////////////////////////////////////////////////////////////////////////////////////////
												// This section generates a new article page!
												$templateFile = "template.php";
												$placeholder = "{article_ID}";
												$templateContent = file_get_contents($templateFile);
												$file = "$resAname.php";
												$filePathArticles = "";
												if ($category == $nations) {
													$filePathArticles = "C:/xampp/htdocs/18thcentury/nations_articles/";
												}
												else if ($category == $conflicts) {
													$filePathArticles = "C:/xampp/htdocs/18thcentury/conflicts_articles/";
												}
												else if ($category == $science) {
													$filePathArticles = "C:/xampp/htdocs/18thcentury/science_articles/";
												}
												$selectSQL = "EXEC selectArticleID ?";
												$selectQuery = sqlsrv_query($conn, $selectSQL, array(&$resAname));
												if(sqlsrv_fetch($selectQuery) === false) {
													die( print_r( sqlsrv_errors(), true));
												}
												else
												{

													$articleNewID = sqlsrv_get_field($selectQuery, 0); // 0 is the first row in result set
													$nationswArticleFile = str_replace($placeholder, $articleNewID, $templateContent);
													$fileName = $resAname.".php";
													$fp = fopen($filePathArticles.$fileName, "w");
													fwrite($fp, $nationswArticleFile);
													fclose($fp);
												}
												//////////////////////////////////////////////////////////////////////////////////////////////////////////

												if ($category == $nations) {
													echo("<p>$category</p>");
													header("Location: $nations.php");
												}
												else if ($category == $conflicts) {
													echo("<p>$category</p>");
													header("Location: $conflicts.php");
												}
												else if ($category == $science) {
													echo("<p>$category</p>");
													header("Location: $science.php");
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
	<h3>Only letters, numbers, and punctation marks can be submited in the article's content - Any special characters will be removed in submission!</h3>
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
		  <table border="0" cellpadding="2" cellspacing="0" id="article_table">
			<tbody id="article_create_table">
			  <tr>
				<td width="171">
				  <input type="text" name="article_title" placeholder="Name of Article" id="article_title">
				</td>
			  </tr>
			  <tr>
			    <td width="171">
				  <select name="category" id="category">
					<option value="nations" selected>Nations</option>
					<option value="conflicts">Conflicts</option>
					<option value="science">Science</option>
				  </select>
				</td>
			  </tr>
			  <tr>
			    <td> <textarea name="entry" id="entry" rows="30" cols="30" placeholder="Article Content"></textarea> </td>
			  </tr>
			  <tr>
			    <td> <textarea name="reference" id="reference" rows="30" cols="30" placeholder="Content References"></textarea> </td>
			  </tr>
			</tbody>
		  </table>
		  <h1></h1>
		  <input type="submit" value="Submit" class="button" name="submit" onclick="blankFields()">
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

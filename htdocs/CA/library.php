<?php
	session_start();

	if(!isset($_SESSION['uname']))
	{
		echo '<script type="text/javascript">
							function Redirect()
						{
							location = "error.html";
						}
						
						Redirect();
				</script>';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Libraray</title>
	<link rel="stylesheet" type="text/css" href="assets/styles.css">
	<meta charset="utf-8">
</head>
<body>

<?php
	$logout = isset($_POST['logout']) ? $_POST['logout'] : '';
	
	if($logout == "LOG OUT")
	{
		//session_destroy();

		echo '<script type="text/javascript">
						function Redirect()
					{
						location = "index.html";
					}
					
					Redirect();
			</script>';
			
	}
?>

<header><img src="assets/logo.png" width="50%"></header>



<div>
		<ul>
			<li><a class="active" href="library.php">Home</a></li>
			<li><a href="search.php">Search</a></li>
			<li><a href="reserved.php">View Reserved Books</a></li>
			<li style="float:right;">
				<form method="post" onsubmit="return confirm ('Are you sure you want to log out?')";>
				<button class="button" type="submit" value="LOG OUT" name="logout">Log out</botton>
				</form>
			</li>
		</ul>
</div>


<div id="home">

<?php
	echo ("<header> Hello" . " " . $_SESSION['uname'] . ", welcome to Povilas Library </header>");
?>
<br><br>

<img id="book" src="assets/book.png" width="30%">

<p>
	Here you can look at our book stock. 
	Search through our books, 
	reserve books to pick them up later to read.
</p>
<p>
	You can search and reserve books our books <a href="search.php">here</a>.
</p>
<p>
	You can check your reserevd books and remove them <a href="reserved.php">here</a>.
</p>

<p>
Here are all our avaible books
</p>

<?php

$db = mysqli_connect('localhost', 'root', '') or die(mysqli_error($db));
	mysqli_select_db($db, 'ca') or die(mysqli_error($db));


$result = mysqli_query($db, "SELECT * FROM books");

	if (mysqli_fetch_row($result) != NULL) 
	{

		echo '<table>' . '<br>';
		echo '<tr id="columnHeader">
				<td>ISBN</td>
				<td>Book Title</td>
				<td>Author</td>
				<td>Edition</td>
				<td>Year</td>
				<td>Category</td>
			</tr>';

		mysqli_data_seek($result, 0);
		while ($row = mysqli_fetch_row($result)) 
		{

			echo "<tr>";

			$category = mysqli_query($db, "SELECT CategoryDescription FROM categories WHERE CategoryID = '$row[5]' ");
			$category = mysqli_fetch_row($category);

				for ($i = 0; $i < sizeof($row) - 1; $i++) 
				{
						if ($i == 5) 
						{
						 	echo('<td>'.$category[0].'</td>');
						}
						else
						{ 
							echo('<td>'.$row[$i].'</td>');
						}
				}
			
			echo "</tr>";
		}
	}
	else
	{
		echo "<p>No Books Available</p>";
	}
mysqli_close($db);
?>
</div>


</body>
</html>
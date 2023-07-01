 <?php
	$servername = "eu-cdbr-west-03.cleardb.net";
	$username = "bc141934716a88";
	$password = "d35ee202";
	$dbname = "heroku_db82d00dcb69272";
	// $servername = "localhost";
	// $username = "root";
	// $password = "111";
	// $dbname = "online_recipes";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

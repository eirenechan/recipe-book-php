 <?php
	$servername = "localhost";
	$username = "root";
	$password = "111";
	$dbname = "online_recipes";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

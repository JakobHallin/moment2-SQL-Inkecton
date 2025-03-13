<?php
//
// Show errors
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//
//	Example php script using database connections and session control handling.
//	This script also shows vulnarabilities with sql injections.
//
//
//	DB Settings
//------------------------------------------------------------
//	Db name
//		test	
//	User
//		Username: test Password: frest
//	test:
//		users
//			| ID (int, autoincrement) | Username (varchar(100) | Password (varchar(50)) |
//		calls
//			| ID (int, autoincrement) | Timestamp (varchar(100) | Ip (varchar(50)) | Call (varchar(200))
//
//------------------------------------------------------------
//
// Start session control
	session_start();
// Present element for authentication as default
	if(!empty($_REQUEST["login"])){
// Check if correct username and password given
		$user = $_REQUEST["user"]; 
		$pass = $_REQUEST["pass"];
		if(strlen($pass) && strlen($user)){ // Check if username and password not empty
// Connect to the mysql database and check for user
			$conn = mysqli_connect("localhost", "root", "", "test") or die("Error connecting to database." . mysqli_error($conn));
			$IP = $_SERVER["REMOTE_ADDR"];
			$time = date("Y-m-d H:i:s");
			$request_method = $_SERVER["REQUEST_METHOD"];
			$request_url = $_SERVER["REQUEST_URI"];
			$headers = getallheaders();
			$host = $headers["Host"];
			$useragent = $headers["User-Agent"];
			$call = "method: $request_method URL: $request_url Host: $host useragent: $useragent";
			$sql2= "INSERT INTO calls (Timestamp, IP, Calls) VALUES ('$time', '$IP', '$call')";
			mysqli_query($conn, $sql2) or die(mysqli_error($conn)); 
			$sql = "SELECT * FROM users WHERE Username = '$user' AND Password = '$pass'"; // Create SQL statement
			$result = mysqli_query($conn, $sql) or die(mysqli_error($conn)); // Execute SQL statement => get resultset  
			if(mysqli_num_rows($result) == 1){ // If ONE username exists with the correct password take the user further		
				mysqli_close($conn); // Close database
				$_SESSION["username"] = $user; // Create session variable "username" if authenticated user (eg. exist in db)
	//
	// Transfer logged in user to another page ==> User is logged in ... we are ready to take off!!!
				header("Location: inside.php");

			 } // end of database user checkup
		} // end of empty string element check  
	} // end of "login" button pressed

?>	
	<!DOCTYPE html>
	<head>
	<title>SQL Injection Test</title>
	<meta charset='utf-8' />
	<style>
	</style>	
	</head>
	<body>
	<form method="post" action="">
	<p>
		Användarnamn <input type="text" name="user"/> <br/>
		Lösenord <input type="password" name="pass"/>
	</p>
	<p>
		<input type="submit" name="login" value="Sign In"/>	
	</p>
	</body>
	</html>


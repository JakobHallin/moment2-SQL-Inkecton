<?php
//
//	Example PHP script checking for authenticated user w the use of sessions.
//	written by Mikael Hasselmalm / Mid Sweden University
//
//
// Start session control
	session_start();
?>
	<!DOCTYPE html>
	<head>
	<title>Valid User</title>
	<meta charset="utf-8" />
	<style></style>	
	</head>
	<body>
<?php
//
// Check if user is authenticated => Session variable 'username' is used for authentication
	if(isset($_SESSION["username"])) print "<h2>Welcome " . $_SESSION["username"] . "!</h2>";
	else print "<h2>You dont belong here!</h2>";
?>
	</body>
	</html>

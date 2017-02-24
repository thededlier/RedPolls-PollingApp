<?php
	include './connect.php';
	
	session_start();
	// Get values and test
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$user_name 		= 	test_input($_POST["username"]);
		$password 		=	test_input($_POST["userPass"]);
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	$sql = "SELECT * from users where username = '$user_name' and password = '$password'";

	$result = $conn->query($sql);

	if($result->num_rows > 0) {
		$_SESSION["username"] = $user_name;
		header("Location: ../dash.php");
	} else {
		$_SESSION["ERR"] = "Invalid Username or Password. Please try again"; 
		header("Location: ../login.php");
	}
?>
<?php
	include './connect.php';
	
	// Get values and test
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$name 			= 	test_input($_POST["name"]);
		$user_name 		= 	test_input($_POST["username"]);
		$email 			= 	test_input($_POST["userEmail"]);
		$password 		=	test_input($_POST["userPass"]);
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	$topics = "";

	if(isset($_POST["interestPolitics"]))
		$topics .= $_POST["interestPolitics"] . ',';
	
	if(isset($_POST["interestBusiness"]))
		$topics .= $_POST["interestBusiness"] . ',';
	
	if(isset($_POST["interestEducation"]))
		$topics .= $_POST["interestEducation"];

    // [START SUBMISSION]
	$sql = "INSERT INTO users(username, name, email, password) 
			VALUES('$name', '$user_name', '$email', '$password')";

    	if ($conn->query($sql) === TRUE) {
			$sql = "INSERT INTO user_prefs(username, topics)
					VALUES('$user_name', '$topics')";
			
			if($conn->query($sql) === TRUE)
				header("Location: ../register-success.html");
	    } else {
	        echo "Error: " . $sql . "<br>" . $conn->error;
	    }
    // [END SUBMISSION]
?>
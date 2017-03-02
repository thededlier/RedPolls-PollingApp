<?php
	include './connect.php';
	
    session_start();
	// Get values and test
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title              =   test_input($_POST["pollTitle"]);
        $desc               =   test_input($_POST["pollDesc"]);
        $endDate            =   test_input($_POST["endDate"]);
        $topics             =   test_input($_POST["topics"]);
        
        $user = $_SESSION["username"];
        $errors = "";

        $sql = "SELECT title FROM polls where title = $title"; 

        if($conn->query($sql)) {
            $errors = "Title already exists";
            die(); 
        }

        // File Upload and verification
        $file_name = $_FILES["image"]['name'];
        $file_size = $_FILES["image"]['size'];
        $file_tmp  = $_FILES["image"]['tmp_name'];
        $file_type = $_FILES["image"]['type'];
        $file_ext=strtolower(end(explode('.',$_FILES["image"]['name'])));
        
        $expensions= array("jpeg","jpg","png");
        
        if(in_array($file_ext,$expensions)=== false){
            $errors="extension not allowed";
        }
      
        if($file_size > 2097152) {
            $errors='File size must be less than 2MB';
        }
      
        if($errors == "") {
            $cover_img = $title . "." . $file_ext;

            $sql = "INSERT INTO polls(title, description, endDate, coverImg, topics, createdBy)
                    VALUES('$title', '$desc', '$endDate', '$cover_img', '$topics', '$user')";

            if($conn->query($sql) === TRUE) {
                echo "Updated";
            }
            move_uploaded_file($file_tmp, "../polls/covers/".$title.".".$file_ext);
            echo "Success";
        }else{
            echo $errors;
        }
    }

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
    
?>
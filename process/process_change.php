<?php
    include './connect.php';

    session_start();
    // Get values and test
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $poll_id            =   $_POST["poll_id"];
        $title              =   test_input($_POST["pollTitle"]);
        $desc               =   test_input($_POST["pollDesc"]);

        $user = $_SESSION["username"];
        $errors = "";

        $sql = "SELECT title FROM polls where title = $title";

        if($conn->query($sql)) {
            $errors = "Title already exists";
            die();
        }

        $sql = "SELECT createdBy from polls where pollID = $poll_id";
        $result = $conn->query($sql);
        if($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if($row['createdBy'] != $user) {
                $errors = "User is not owner";
                die();
            }
        }
        if(isset($_FILES["newCoverImg"])) {
            $sql = "SELECT coverImg from polls where pollID = $poll_id";
            $result = $conn->query($sql);
            if($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $coverImg = $row['coverImg'];
                $path_parts = pathinfo('../polls/covers/' . $coverImg);
            }

            $sql = "UPDATE polls SET title = '$title', description = '$desc'
                    WHERE pollId = $poll_id";


            rename("../polls/covers/" . $coverImg, "../polls/covers/" . $title . $path_parts['extension']);

            if($conn->query($sql) != TRUE) {
                $errors = "Failed";
            }
        } else {
            // File Upload and verification

            $file_name = $_FILES["newCoverImg"]['name'];
            $file_size = $_FILES["newCoverImg"]['size'];
            $file_tmp  = $_FILES["newCoverImg"]['tmp_name'];
            $file_type = $_FILES["newCoverImg"]['type'];
            $file_ext  = strtolower(end(explode('.',$_FILES["newCoverImg"]['name'])));

            $expensions= array("jpeg","jpg","png");

            if(in_array($file_ext,$expensions)=== false){
                $errors="extension not allowed";
            }

            if($file_size > 2097152) {
                $errors='File size must be less than 2MB';
            }

            if($errors === "") {
                $cover_img = $title . "." . $file_ext;
                // Remove old image
                $sql = "SELECT coverImg from polls where pollID = $poll_id";
                $result = $conn->query($sql);
                if($result->num_rows === 1) {
                    $row = $result->fetch_assoc();
                    unlink("../polls/covers/" . $row['coverImg']);
                }

                $sql = "UPDATE polls SET title = '$title', description = '$desc', coverImg = '$cover_img'
                        WHERE pollId = $poll_id";

                if($conn->query($sql) === TRUE) {
                    echo "Updated";
                }
                move_uploaded_file($file_tmp, "../polls/covers/".$title.".".$file_ext);
                echo "Success";
            }
        }

        header('Location: ../events.php?poll_id=' . $poll_id . 'status=' . $errors);
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>

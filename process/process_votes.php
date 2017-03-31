<?php
    include './connect.php';

    session_start();
    // Get values and test
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $poll_id    = $_POST["poll_id"];
        $vote_type  = $_POST["action"];
        $uid        = $_SESSION["username"];

        switch ($vote_type) {
            case 'upVote':
                $sqlPoll = "UPDATE polls SET upVotes = upVotes + 1 where pollID = $poll_id";
                $sqlUser = "UPDATE user_votes SET upVotes = CONCAT(upVotes, '$poll_id,') where username = '$uid'";
                break;

            case 'downVote':
                $sqlPoll = "UPDATE polls SET downVotes = downVotes + 1 where pollID = $poll_id";
                $sqlUser = "UPDATE user_votes SET downVotes = CONCAT(downVotes, '$poll_id,') where username = '$uid'";
                break;

            case 'mehVote':
                $sqlPoll = "UPDATE polls SET mehVotes = mehVotes + 1 where pollID = $poll_id";
                $sqlUser = "UPDATE user_votes SET mehVotes = CONCAT(mehVotes, '$poll_id,') where username = '$uid'";
                break;

            default:
                die();
                break;
        }

        $conn->query($sqlPoll);
        $conn->query($sqlUser);
    }
?>

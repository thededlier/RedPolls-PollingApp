<?php
    include './connect.php';

    session_start();
    // Get values and test
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $poll_id    = $_POST["poll_id"];
        $vote_type  = $_POST["action"];
        $uid        = $_SESSION["username"];
        $stat       = $_POST["vote_stat"];

        if($stat == '') {
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
                    ;
                    break;
            }
        } else if($stat === 'up') {
            $sqlPoll = "UPDATE polls SET upVotes = upVotes - 1 where pollID = $poll_id";
            $sqlUser = "UPDATE user_votes SET upVotes = replace(upVotes, '$poll_id,', '') where username = '$uid'";

            $conn->query($sqlPoll);
            $conn->query($sqlUser);

            if($vote_type === 'upVote') {
                die(header('Location: ../events.php?poll_id='. $poll_id));
            } else if ($vote_type === 'downVote') {
                $sqlPoll = "UPDATE polls SET downVotes = downVotes + 1 where pollID = $poll_id";
                $sqlUser = "UPDATE user_votes SET downVotes = CONCAT(downVotes, '$poll_id,') where username = '$uid'";
            } else if ($vote_type === 'mehVote') {
                $sqlPoll = "UPDATE polls SET mehVotes = mehVotes + 1 where pollID = $poll_id";
                $sqlUser = "UPDATE user_votes SET mehVotes = CONCAT(mehVotes, '$poll_id,') where username = '$uid'";
            }
        } else if($stat === 'down') {
            $sqlPoll = "UPDATE polls SET downVotes = downVotes - 1 where pollID = $poll_id";
            $sqlUser = "UPDATE user_votes SET downVotes = replace(downVotes, '$poll_id,', '') where username = '$uid'";

            $conn->query($sqlPoll);
            $conn->query($sqlUser);

            if($vote_type === 'upVote') {
                $sqlPoll = "UPDATE polls SET upVotes = upVotes + 1 where pollID = $poll_id";
                $sqlUser = "UPDATE user_votes SET upVotes = CONCAT(upVotes, '$poll_id,') where username = '$uid'";
            } else if ($vote_type === 'downVote') {
                die(header('Location: ../events.php?poll_id='. $poll_id));
            } else if ($vote_type === 'mehVote') {
                $sqlPoll = "UPDATE polls SET mehVotes = mehVotes + 1 where pollID = $poll_id";
                $sqlUser = "UPDATE user_votes SET mehVotes = CONCAT(mehVotes, '$poll_id,') where username = '$uid'";
            }

        } else if($stat === 'meh') {
            $sqlPoll = "UPDATE polls SET mehVotes = mehVotes - 1 where pollID = $poll_id";
            $sqlUser = "UPDATE user_votes SET mehVotes = replace(mehVotes, '$poll_id,', '') where username = '$uid'";

            $conn->query($sqlPoll);
            $conn->query($sqlUser);

            if($vote_type === 'upVote') {
                $sqlPoll = "UPDATE polls SET upVotes = upVotes + 1 where pollID = $poll_id";
                $sqlUser = "UPDATE user_votes SET upVotes = CONCAT(upVotes, '$poll_id,') where username = '$uid'";
            } else if ($vote_type === 'downVote') {
                $sqlPoll = "UPDATE polls SET downVotes = downVotes + 1 where pollID = $poll_id";
                $sqlUser = "UPDATE user_votes SET downVotes = CONCAT(downVotes, '$poll_id,') where username = '$uid'";
            } else if ($vote_type === 'mehVote') {
                die(header('Location: ../events.php?poll_id='. $poll_id));
            }
        }

        $conn->query($sqlPoll);
        $conn->query($sqlUser);

        header('Location: ../events.php?poll_id='. $poll_id);
    }
?>

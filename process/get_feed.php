<?php
    function getFeed($user) {
        include './process/connect.php';

        $html = "";
        $topics = "";

        $sql = "SELECT * FROM user_prefs where username = '$user'";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $topics = $row["topics"];
        }

        $topic = explode(",", $topics);

        $sql = "SELECT * FROM polls where topics = '$topic[0]'";
        $i = 0;
        foreach($topic as $i) {
            $sql .= " OR topics = '$i'";
        }

        $sql .= " OR topics = 'Other' order by startDate desc";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $html .=    '<a href="./events.php?poll_id='. $row["pollID"] . '" class="list-group-item">' .
                                '<div class="row">' .
                                    '<div class="col-xs-2 col-md-3">' .
                                        '<img class="img-responsive" src="./polls/covers/' . $row["coverImg"] . '">' .
                                    '</div>' .
                                    '<div class="col-xs-10 col-md-9">' .
                                        '<h3 class="poll-head">' . $row["title"] . '</h3>' .
                                        '<span class="event-creator">@' . $row["createdBy"] . '</span>' .
                                        '<p class="poll-desc">' .
                                            $row["description"] .
                                        '</p>' .
                                        '<div class="row">' .
                                            '<button class="btn btn-transparent pull-left voteBtn" type="disabled">' .
                                                '<span class="glyphicon glyphicon-arrow-up" id="upBtn"></span> ' . $row["upVotes"] .
                                            '</button>' .
                                            '<button class="btn btn-transparent pull-left voteBtn" type="disabled">' .
                                                '<span class="glyphicon glyphicon-arrow-down" id="downBtn"></span> ' . $row['downVotes'] .
                                            '</button>' .
                                            '<button class="btn btn-transparent pull-left voteBtn" type="disabled">' .
                                                '<i class="fa fa-meh-o" id="mehBtn" aria-hidden="true"></i> ' . $row['mehVotes'] .
                                            '</button>' .
                                            '<div class="md-chip blue pull-right">' .
                                                '<div class="md-chip-img">' .
                                                    '<span class="md-chip-span blue">&nbsp;</span>' .
                                                '</div>' .
                                                '<span class="md-chip-text">' . $row["topics"] . ' </span>' .
                                            '</div>' .
                                        '</div>' .
                                    '</div>' .
                                '</div>' .
                            '</a>';
            }
        }

        return $html;
    }

    function getShort($user) {
        include './process/connect.php';

        $html = "";

        $sql = "SELECT title, pollID FROM polls where createdBy = '$user'";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $html .= '<a href="./events.php?poll_id='. $row["pollID"] . '" class="list-group-item">' . $row["title"] . '</a>';
            }
        } else {
            $html = '<a class="list-group-item"> You have no polls of your own </a>';
        }

        return $html;
    }
?>

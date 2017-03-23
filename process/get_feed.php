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
        $result = $conn->query($sql);
        
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $html .=    '<a href="./events.php?poll_id='. $row["pollID"] . '" class="list-group-item">' .
                                '<div class="row">' .
                                    '<div class="col-xs-2 col-md-3">' .
                                        '<img class="img-responsive" src="./polls/covers/' . $row["coverImg"] . '">' .
                                    '</div>' .
                                    '<div class="col-xs-10 col-md-9">' .
                                        '<h3>' . $row["title"] . '</h3>' .
                                        '<p>' .
                                            $row["description"] .   
                                        '</p>' .
                                    '</div>' .
                                '</div>' .
                            '</a>';
            }
        }
        
        return $html;
    }
?>
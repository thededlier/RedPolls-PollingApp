<?php
    function getFeed($user) {
        include './process/connect.php';
        
        $html = "";
        $topics = "";
        
        $sql = "SELECT * FROM user_prefs where username = '$user'";
        
        $result = $conn->query($sql);
        
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $topics = $row["topics"];
            }
        }
        
        $topic = explode(",", $topics);
        
        $sql = "SELECT * FROM polls where topics = '$topic[0]'";
        $i = 0;
        foreach($i as $topic) {
            $sql .= "OR topics = '$topic[$i]'";
        }
        
        $result = $conn->query($sql);
        
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $html .=    '<a href="#" class="list-group-item">' .
                                '<h3>' . $row["title"] . '</h3>' .
                                '<p>' .
                                    $row["description"] .   
                                '</p>' .
                            '</a>';
            }
        }
        
        return $html;
    }
?>
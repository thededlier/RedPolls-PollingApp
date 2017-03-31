<?php

    function MyList($user, $type) {
        $html = "";

        $sql = "SELECT title FROM polls where createdBy = '$user'";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if(type === "SHORT") {
                    $html .= '<a href="./events.php?poll_id=' . $row['poll_id'] . '" class="list-group-item">' . $row["title"] . '</a>';   
                }
            }
        } else {
            $html = '<a class="list-group-item"> You have no polls of your own </a>';
        }

        return $html;
    }
?>

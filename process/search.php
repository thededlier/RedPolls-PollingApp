<?php
    function searchQuery($search_key) {
        include './process/connect.php';

        $html = "";

        $sql = "SELECT * FROM polls where createdBy LIKE '%$search_key%' OR title LIKE '%$search_key%' OR description LIKE '%$search_key%'";

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
?>

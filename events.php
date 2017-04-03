<?php
    include './process/connect.php';

    session_start();

    $user = $_SESSION["username"];

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $poll_id   = $_GET["poll_id"];
    } else {
        header("Location: index.php");
        die();
    }

    $sql = "SELECT * FROM polls where pollID = '$poll_id'";

    $result = $conn->query($sql);

    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $title      = $row["title"];
        $desc       = $row["description"];
        $startDate  = $row["startDate"];
        $endDate    = $row["endDate"];
        $cover      = $row["coverImg"];
        $topics     = $row["topics"];
        $creator    = $row["createdBy"];
        $upVotes    = $row["upVotes"];
        $downVotes  = $row["downVotes"];
        $mehVotes   = $row["mehVotes"];

        $sql = "SELECT * FROM user_votes where username = '$user'";
        $result = $conn->query($sql);

        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $up_votes = explode(",", $row['upVotes']);
            $down_votes = explode(",", $row['downVotes']);
            $meh_votes = explode(",", $row['mehVotes']);

            $stat = '';

            foreach ($up_votes as $i) {
                if($poll_id === $i) {
                    $stat = 'up';
                }
            }
            foreach ($down_votes as $i) {
                if($poll_id === $i) {
                    $stat = 'down';
                }
            }
            foreach ($meh_votes as $i) {
                if($poll_id === $i) {
                    $stat = 'meh';
                }
            }
        }
        if($creator === $user) {
            $enable_edit = TRUE;
        } else {
            $enable_edit = FALSE;
        }
    }
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/font-awesome.min.css">
        <!-- Custom stylesheet -->
        <link rel="stylesheet" href="./css/stylesheet.css">
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./index.php">RedPolls</a>
                </div>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="./create.php">New Poll</a></li>
                    <li><a href="#">My Polls</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["username"] ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Settings</a></li>
                            <li><a href="./process/process_logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <!--<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>-->
                </ul>

                <form class="navbar-form navbar-left" action="./search-results.php" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search_key" placeholder="Search">
                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 panel panel-white">
                    <img class="img-responsive" src="polls/covers/<?php echo $cover; ?>">
                    <hr>
                    <span class="event-title"><?php echo $title; ?></span>
                    <span class="event-creator"><a href="">@<?php echo $creator; ?></a></span>
                    <form action="./edit-poll.php" method="POST">
                        <input type="hidden" name="poll_id" value="<?php echo $poll_id; ?>">
                        <span class="pull-right"><button class="btn btn-primary" type="submit" id="editBtn">Edit</button></span>
                    </form>
                    <hr>
                    <p><?php echo $desc; ?></p>
                    <hr>
                    <form method="post" action="process/process_votes.php">
                        <input type="hidden" name="poll_id" value="<?php echo $poll_id; ?>">
                        <input type="hidden" name="action" value="upVote">
                        <input type="hidden" name="vote_stat" value="<?php echo $stat; ?>">
                        <button class="btn btn-transparent pull-left voteBtn" type="submit">
                            <span class="glyphicon glyphicon-arrow-up" id="upBtn"></span> <?php echo $upVotes; ?>
                        </button>
                    </form>
                    <form method="post" action="process/process_votes.php">
                        <input type="hidden" name="poll_id" value="<?php echo $poll_id; ?>">
                        <input type="hidden" name="action" value="downVote">
                        <input type="hidden" name="vote_stat" value="<?php echo $stat; ?>">
                        <button class="btn btn-transparent pull-left voteBtn" type="submit">
                            <span class="glyphicon glyphicon-arrow-down" id="downBtn"></span> <?php echo $downVotes; ?>
                        </button>
                    </form>
                    <form method="post" action="process/process_votes.php">
                        <input type="hidden" name="poll_id" value="<?php echo $poll_id; ?>">
                        <input type="hidden" name="action" value="mehVote">
                        <input type="hidden" name="vote_stat" value="<?php echo $stat; ?>">
                        <button class="btn btn-transparent pull-left voteBtn" type="submit">
                            <i class="fa fa-meh-o" id="mehBtn" aria-hidden="true"></i> <?php echo $mehVotes; ?>
                        </button>
                    </form>
                    <button class="btn btn-transparent pull-right"><span class="glyphicon glyphicon-time"> <?php echo $endDate; ?></span></button>
                    <div class="md-chip blue pull-right">
                        <div class="md-chip-img">
                            <span class="md-chip-span blue">&nbsp;</span>
                        </div>
                        <span class="md-chip-text"><?php echo $topics; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery library -->
        <script src="js/jquery-1.9.1.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="./js/bootstrap.min.js"></script>

        <script type="text/javascript">
        // Change color of vote btn based on already voting
            <?php if($stat != '') { ?>
                        document.getElementById('<?php echo $stat; ?>Btn').style.color = "#2377ff";
            <?php } ?>

            <?php if($enable_edit === TRUE) { ?>
                        document.getElementById('editBtn').style.display = "block";
            <?php } else { ?>
                        document.getElementById('editBtn').style.display = "none";
            <?php }?>
        </script>
    </body>
</html>

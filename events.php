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
            <div class="container-fluid">
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

                <form class="navbar-form navbar-left">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
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
                    <span class="event-title"><?php echo $title; ?></span><span class="event-creator">@<?php echo $creator; ?></span>
                    <hr>
                    <p><?php echo $desc; ?></p>
                    <hr>
                    <form method="post" action="process/process_votes.php">
                        <button class="btn btn-transparent pull-left"><span class="glyphicon glyphicon-arrow-up"><?php echo $upVotes; ?></span></button>
                        <button class="btn btn-transparent pull-left"><span class="glyphicon glyphicon-arrow-down"><?php echo $downVotes; ?></span></button>
                        <button class="btn btn-transparent pull-left"><i class="fa fa-meh-o" aria-hidden="true"><?php echo $mehVotes; ?></i></button>
                        <button class="btn btn-transparent pull-right"><span class="glyphicon glyphicon-time"><?php echo $endDate; ?></span></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- jQuery library -->
        <script src="js/jquery-1.9.1.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="./js/bootstrap.min.js"></script>

    </body>
</html>

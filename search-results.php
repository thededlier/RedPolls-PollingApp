<?php
    include './process/connect.php';
    include './process/get_feed.php';
    include './process/search.php';

//  Supress warnings
    error_reporting(0);

    session_start();

    if(!isset($_SESSION["username"])) {
        header("Location: ./login.php");
        die();
    }
    $user = $_SESSION["username"];

//    Get User Polls
        // $shortList = "";
        //
        // $sql = "SELECT title FROM polls where createdBy = '$user'";
        //
        // $result = $conn->query($sql);
        //
        // if($result->num_rows > 0) {
        //     while($row = $result->fetch_assoc()) {
        //         $shortList .= '<a href="./events.php?poll_id='. $row["pollID"] . '" class="list-group-item">' . $row["title"] . '</a>';
        //     }
        // } else {
        //     $shortList = '<a class="list-group-item"> You have no polls of your own </a>';
        // }
//
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $search_key = $_GET["search_key"];
    } else {
        header("Location: index.php");
        die();
    }

    $searchList = searchQuery($search_key);
    $shortList = getShort($user);
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <!-- Custom stylesheet -->
        <link rel="stylesheet" href="./css/stylesheet.css">
        <link rel="stylesheet" href="./css/font-awesome.min.css">
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
                    <div class="list-group">
                        <h1>Search Results</h1>
                        <?php echo $searchList; ?>
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 col-md-offset-1 col-lg-offset-1 hidden-xs panel panel-white panel-red-top">
                    <div class="list-group">
                        <h3>My Polls</h3>
                        <?php echo $shortList; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery library -->
        <script src="js/jquery-1.9.1.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="./js/bootstrap.min.js"></script>

    </body>
</html>

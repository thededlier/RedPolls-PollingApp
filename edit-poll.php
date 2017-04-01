<?php
    include './process/connect.php';

    session_start();

    $user = $_SESSION["username"];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $poll_id   = $_POST["poll_id"];
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

        if($creator === $user) {
            ;
        } else {
            die(header('Location: ./index.php'));
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
                    <form action="./process/process_change.php" method="POST">
                        <img class="img-responsive" id="preview" src="polls/covers/<?php echo $cover; ?>">
                        <hr>
                        <div class="form-group">
                            <label for="upFile">Change Cover Image</label>
                            <input type="file" accept="image/jpeg, image/png" class="btn btn-primary" id="upFile" name="image">
                        </div>
                        <div class="form-group">
                            <label for="event-title">Title</label>
                            <input type="text" class="form-control" name="eventTitle" id="event-title" value="<?php echo $title; ?>">
                        </div>
                        <div class="form-group">
                            <label for="event-desc">Description</label>
                            <textarea class="form-control" rows=4 name="eventDesc" id="event-desc"><?php echo $desc; ?></textarea>
                        </div>
                        <hr>
                        <div class="pull-right">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                            <a href="index.php" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- jQuery library -->
        <script src="js/jquery-1.9.1.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="./js/bootstrap.min.js"></script>

        <script>
            document.getElementById("upFile").onchange = function () {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // get loaded data and render thumbnail.
                    document.getElementById("preview").src = e.target.result;
                };

                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);
            };
        </script>
    </body>
</html>

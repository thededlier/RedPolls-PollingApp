<?php
    include './process/connect.php';

    session_start();

    $user = $_SESSION["username"];

//    Get User Polls
        $shortList = "";

        $sql = "SELECT title FROM polls where createdBy = '$user'";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $shortList .= '<a href="#" class="list-group-item">' . $row["title"] . '</a>';
            }
        } else {
            $shortList = '<a class="list-group-item"> You have no polls of your own </a>';
        }
//
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="./css/bootstrap.min.css">
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
                    <form class="form-horizontal" action="./process/process_creation.php" method="POST" enctype = "multipart/form-data">
                        <div class="form-group">
                            <label for="upFile" class="control-label col-md-2">Upload an Image</label>
                            <div class="col-md-9">
                                <input type="file" accept="image/jpeg, image/png" class="btn btn-primary" id="upFile" name="image">
                            </div>
                            <img class="img-responsive col-md-9" id="preview">
                        </div>
                        <div class="form-group">
                            <label for="pollTitle" class="control-label col-md-2">Title</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="pollTitle" name="pollTitle">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pollDesc" class="control-label col-md-2">Description</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows=4 id="pollDesc" name="pollDesc"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="topic" class="control-label col-md-2">Topics</label>
                            <div class="col-md-4">
                                <select class="form-control" id="topic" name="topics">
                                    <option value="Politics">Politics</option>
                                    <option value="Business">Business</option>
                                    <option value="Education">Education</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="endDate" class="control-label col-md-2">End Date</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" id="endDate" name="endDate">
                            </div>
                        </div>
                        <div class="col-md-11">
                            <div class="pull-right">
                                <button type="button" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
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

        <!-- Get image preview -->
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

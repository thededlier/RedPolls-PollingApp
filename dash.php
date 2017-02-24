<?php
    include './process/connect.php';

    session_start();
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
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">RedPolls</a>
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
                    <div class="list-group">
                        <h1>My Feed</h1>
                        <a href="#" class="list-group-item">
                            <h3>Test Poll</h3>
                            <p>
                                Test Description Test Description Test Description Test Description Test Description Test Description Test DescriptionTest Description Test Description
                            </p> 
                        </a>
                        <a href="#" class="list-group-item">
                            <h3>Test Poll</h3>
                            <p>
                                Test Description Test Description Test Description Test Description Test Description Test Description Test DescriptionTest Description Test Description
                            </p> 
                        </a>
                        <a href="#" class="list-group-item">
                            <h3>Test Poll</h3>
                            <p>
                                Test Description Test Description Test Description Test Description Test Description Test Description Test DescriptionTest Description Test Description
                            </p> 
                        </a>
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 col-md-offset-1 col-lg-offset-1 hidden-xs panel panel-white panel-red-top">
                    <div class="list-group">
                        <h3>My Polls</h3>
                        <a href="#" class="list-group-item">Test Poll</a>
                        <a href="#" class="list-group-item">Test Poll</a>
                        <a href="#" class="list-group-item">Test Poll</a>
                        <a href="#" class="list-group-item">Test Poll</a>
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
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="./css/bootstrap.min.css">    
        <!-- jQuery library -->
        <script src="js/jquery-1.9.1.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="./js/bootstrap.min.js"></script>

        <!-- Custom stylesheet -->
        <link rel="stylesheet" href="./css/stylesheet.css">
    </head>
    <body>  
        <div class="container">
            <div class="row">
                <form action="./process/process_login.php" method="POST">
                    <h3 class="center">Sign in to RedPolls</h3>
                    <div class="col-md-3 col-lg-3 col-xs-11 center-block panel-login panel-white">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username">
                        </div>
                        <div class="form-group">
                            <label for="userPass">Password</label>
                            <input type="password" class="form-control" name="userPass" id="userPass"> 
                        </div>
                        <button class="btn btn-success btn-block" type="submit">Sign in</button>
                    </div>
                </form>

                <div class="col-md-3 col-lg-3 col-xs-11 center-block panel panel-transparent center">
                    <span>New to RedPolls? <a href="./signup.html">Create An Account</a></span>
                </div>
            </div>
        </div>
    </body>

</html>
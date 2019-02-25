<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" text="type/css" href="../Bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" text="type/css" href="../style.css">
    </head>

    <body>
        <div class="loginContainer container h-100 d-flex justify-content-center">
            <div class="jumbotron my-auto">
                <h2>New Golden City Builders</h2>
                <h2>Login</h2>
                <form action="server.php" method="POST">
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="username" id="inputLoginUsername" placeholder="username">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="password " name="password" id="inputLoginPassword" placeholder="password">
                    </div>
                    <div class="">
                        <button type="submit" name="login" value="Login" class="btn btn-primary btn-block">Login</button>
                    </div>  
                    <div>
                        <?php
                            session_start();
                            if(isset($_SESSION['login_error'])) {
                                echo "Incorrect username or password.";
                                unset($_SESSION['login_error']);
                            }
                        ?>
                    </div>                 
                    <div class="d-flex flex-row">
                        <p class="p-2"><a href="createaccount.php">Create Account</p>
                        <p class="p-2"><a href="forgotpassword.php">Forgot Password</p>
                    </div>
                </form> 
            </div>
        </div>
    </body>
</html>
<!DOCTYPE html>

<html>

<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" text="type/css" href="../style.css">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
</head>

<body>

    <div class="container login-container">
        <div class="row">
            <div class="col s12 m5 offset-m4">
                <div class="card white darken-1">
                    <div class="card-content login-image">
                        <h2 class="card-title center-align Login-Header">New Golden City Builders</h2>
                        <h2 class="card-title center-align Login-Header">Login</h2>
                        <form action="server.php" method="POST">
                            <div class="row center-align login-content">
                                <div class="input-field col s12 m10 offset-m1">
                                    <i class="material-icons prefix icon">account_circle</i>
                                    <input placeholder="username" id="login-username" name="username" type="text" class="validate">
                                </div>

                                <div class="input-field col s12 m10 offset-m1">
                                    <i class="material-icons prefix icon">lock_outline</i>
                                    <input placeholder="password" id="login-password" name="password" type="password" class="validate">
                                </div>

                                <div class="row">
                                    <div class="col s12 offset-m3">
                                        <a href="forgotpassword.php">Forgot Password</a>
                                    </div>
                                </div>
                                <?php
                            session_start();
                            if(isset($_SESSION['login_error'])) {
                                echo "Incorrect username or password.";
                                unset($_SESSION['login_error']);
                            }
                            ?>
                                <div class="row">
                                    <div class="col s12 m10 offset-m1">
                                        <button class="btn waves-effect waves-light login-btn" type="submit" name="login">Login</button>
                                    </div>
                                </div>
                                    <div class="row">
                                        <a href="createaccount.php" id="create-account-btn" name="action">Create An Account</a>
                                    </div>

                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>

<!DOCTYPE html>

<html>

<head>
    <title>NGCB</title>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../style.css">
</head>

<body>
    <div class="split-login-container left-login-container">
        <div class="header-container-one">
            <h2 class="header header-one">New Golden City Builders and Development Corporation</h2>
        </div>

    </div>

    <div class="split-login-container right-login-container">
        <div class="row">
                <h2 class="header header-two">Login</h2>

                <form action="server.php" method="POST">
                    <div class="co-login">
                        <div class="f-login input-field col s12 m10 offset-m1 ">
                            <i class="material-icons prefix icon">account_circle</i>
                            <input placeholder="username" id="login-username" name="username" type="text">
                        </div>

                        <div class="f-login input-field col s12 m10 offset-m1">
                            <i class="material-icons prefix icon">lock_outline</i>
                            <input placeholder="password" id="login-password" name="password" type="password">
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
                                <button class="btn waves-effect waves-light login-btn" type="submit"
                                    name="login">Login</button>
                            </div>
                        </div>
                        <div class="row">
                            <a href="createaccount.php" id="create-btn" name="action">Create An Account</a>
                        </div>

                    </div>
                </form>

        </div>

    </div>
    </div>
</body>

</html>
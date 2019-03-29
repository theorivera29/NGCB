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

            <input type='checkbox' id='form-switch'>
            <form id="login-form" action="server.php" method="POST">
                <h2 class="header header-two">Login</h2>
                <?php
                    session_start();
                    if(isset($_SESSION['login_error'])) {
                    echo "Incorrect username or password.";
                    unset($_SESSION['login_error']);
                    }
                ?>
                <div class="co-login">
                    <div class="f-login username input-field col s6 m8 offset-m1 ">
                        <input id="login-username" name="username" type="text" required>
                        <label class="active" for="username">Username</label>
                    </div>
                    <div class="f-login password input-field col s6 m8 offset-m1">
                        <input id="login-password" name="password" type="password" required>
                        <label class="active" for="password">Password</label>
                    </div>
                    <div class="row">
                        <div class="col s12 m24">
                            <a href="forgotpassword.php">Forgot Password</a>
                            <button class="btn waves-effect waves-light login-btn" type="submit"
                                name="login">Login</button>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col s12 m9 offset-m3">
                            <label for='form-switch' id="form-switch-label">Create an Account</label>
                        </div>
                    </div>
                </div>

            </form>

            <form id="register-form" action="server.php" method="POST">
                <h2 class="header header-two">Create an Account</h2>
                <div class="row">
                    <div class="input-field col s12 m10 offset-m1">
                        <input id="firstname" name="firstname" type="text" class="validate">
                        <label for="firstname">First Name</label>
                    </div>

                    <div class="input-field col s12 m10 offset-m1">
                        <input id="lastname" name="lastname" type="text" class="validate">
                        <label for="lastname">Last Name</label>
                    </div>

                    <div class="input-field col s12 m10 offset-m1">
                        <input id="username" name="username" type="text" class="validate">
                        <label for="username">Username</label>
                    </div>

                    <div class="input-field col s12 m10 offset-m1">
                        <input id="email" name="email" type="text" class="validate">
                        <label for="email">Email</label>
                    </div>

                    <div class="input-field col s12 m10 offset-m1">
                        <input id="password" name="password" type="text" class="validate">
                        <label for="password">Password</label>
                    </div>

                    <div class="col s12 m10 offset-m1">
                        <span>Account Type</span>
                        <div class="row">
                            <label>
                                <input class="with-gap" name="account_type" type="radio" checked
                                    value="Materials Engineer" />
                                <span>Materials Engineer</span>
                                <input class="with-gap" name="account_type" type="radio" checked value="View Only" />
                                <span>View Only</span>
                            </label>
                        </div>

                    </div>

                    <div class="row center">
                        <button class="btn waves-effect waves-light create-account-btn" type="submit" name="create_account">Create
                            An Account</button>
                        <a class="waves-effect waves-light btn" href="loginpage.php">Cancel</a>
                    </div>
                </div>
            </form>
        </div>

    </div>
    </div>


</body>

</html>
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

                            <button class="btn waves-effect waves-light login-btn" type="submit"
                                name="login">Login</button>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col s12 m9 offset-m3">
                            <label for='form-switch' id="form-switch-label">Forgot Password</label>
                        </div>
                    </div>
                </div>

            </form>

            <form id="password-form" action="server.php" method="POST">
                <h2 class="header header-two">Password Reset</h2>
                <div class="row">
                    <div class="input-field col s7 offset-m2">
                        <i class="material-icons prefix">account_circle</i>
                        <input placeholder="username" id="login-username" name="username" type="text" class="validate">
                    </div>

                    <div class="row">
                        <div class="col s4 m6 offset-m3">
                            <a href="createaccount.php" class="btn waves-effect waves-light" type="submit"
                                name="action">Submit</a>
                            <a href="loginpage.php" class="btn waves-effect waves-light" type="submit"
                                name="action">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    </div>


</body>

</html>
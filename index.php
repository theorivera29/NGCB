<?php
    include "db_connection.php";
    session_start();
    $task = "";    

    if(isset($_SESSION['loggedin'])) {
        if(isset($_SESSION['account_type'])) {
            $account_type = $_SESSION['account_type'];

            if (strcmp($account_type,"Admin") == 0) {
                header("location: http://127.0.0.1/NGCB/Admin/admindashboard.php");
                exit;
            } else if (strcmp($account_type,"MatEng") == 0) {
                header("location: http://127.0.0.1/NGCB/Materials%20Engineer/dashboard.php");
                exit;
            } else {
                header("location: http://127.0.0.1/NGCB/View%20Only/projects.php");
                exit;
            }
        }
    }
    if(isset($_SESSION['tasks'])) {
        $task = $_SESSION['tasks'];
    }
?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCB</title>
    <link rel="icon" type="image/png" href="Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="style.css">
</head>

<body>
    <div class="split-login-container left-login-container">
        <div class="header-container-one">
            <h2 class="header header-one">New Golden City Builders and Development Corporation</h2>
        </div>

    </div>

    <div class="split-login-container right-login-container">
        <div class="row login-container">
            <input type='checkbox' id='form-switch'>
            <form id="login-form" action="server.php" method="POST">
                <h2 class="header header-two">Log In</h2>
                <?php
                    if(isset($_SESSION['login_error'])) {
                    echo "Incorrect username or password.";
                    unset($_SESSION['login_error']);
                    }
                ?>
                <div class="co-login">
                    <div class="f-login username input-field col s6 m12">
                        <input placeholder="Your username.." id="field-login-username" name="username" type="text" required>
                        <label class="active" for="username">Username</label>
                    </div>
                    <div class="f-login password input-field col s6 m12">
                        <input placeholder="Your password.." id="field-login-password" name="password" type="password"
                            required>
                        <label class="active" for="password">Password</label>
                    </div>
                    <div class="row">
                        <div class="col m12">

                            <button class="btn waves-effect waves-light login-btn" type="submit"
                                name="login">Login</button>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <label for='form-switch' id="form-switch-label" class="forgot-password">Forgot
                                Password</label>
                        </div>
                    </div>
                </div>

            </form>

            <form id="password-form" action="server.php" method="POST">
                <div class="row" id="login-form">
                    <h2 class="header header-two">Password Reset</h2>
                    <div class="input-field col s6 m12">
                        <input placeholder="Your username.." id="login-password" name="password" type="text" required>
                        <label class="active" for="password">Password</label>
                    </div>
                    <div class="row">
                        <button href="index.php" class="btn waves-effect waves-light" type="submit"
                            name="action">Submit</button>
                        <a href="index.php" class="btn waves-effect waves-light" type="submit"
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
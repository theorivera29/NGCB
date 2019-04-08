<?php
    include "../db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
      header('Location: http://127.0.0.1/NGCB/index.php');
    }
?>

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
<nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large pulse"><i
                    class="material-icons">menu</i></a>
            <h4 id="NGCB">NEW GOLDEN CITY BUILDERS</h4>
            <ul class="side-nav" id="mobile-demo">
                <li class="collection-item avatar">
                    <span class="title">
                    </span>
                    <span class="title">
                    </span>
                </li>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="admindashboard.php">Dashboard</a></li>
                <li>
                    <div class="divider"></div>
                </li>

                <ul class="collapsible">
                    <li>
                        <a class="collapsible-header waves-effect waves-blue">Accounts<i
                                class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a class="waves-effect waves-blue" href="accountcreation.php">Create Account</a>
                                </li>
                                <li>
                                    <a class="waves-effect waves-blue" href="listofaccounts.php">List of Accounts</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <li>
                    <div class="divider"></div>
                </li>
                </li>
                <li><a href="projects.php">Projects</a></li>

                <li>
                <li>
                    <div class="divider"></div>
                </li>



                <li><a href="passwordrequest.php">Password Request</a></li>
                <li>
                <li>
                    <div class="divider"></div>
                </li>
                <li>
                    <a href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <form action="server.php" method="POST">
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
                    <input id="password" name="password" type="password" class="validate">
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
                    <button class="btn waves-effect waves-light create-account-btn" type="submit"
                        name="create_account">Create
                        An Account</button>
                    
                </div>
            </div>
        </form>
    </div>


</form>
    </div>
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script>
        // SIDEBAR
        $(document).ready(function () {
            $('.button-collapse').sideNav({
                menuWidth: 300, // Default is 300
                edge: 'left', // Choose the horizontal origin
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
                draggable: true // Choose whether you can drag to open on touch screens
            });
            // START OPEN
            $('.button-collapse').sideNav('show');
        });
    </script>

</body>

</html>
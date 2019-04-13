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
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.min.css" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../style.css">
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="navigation" class="button-collapse show-on-large menu-icon"><i
                    class="material-icons menuIcon">menu</i></a>
            <span id="NGCB">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</span>
            <?php 
                            if(isset($_SESSION['username'])) {
                            $username = $_SESSION['username'];
                            $sql = "SELECT * FROM accounts WHERE accounts_username = '$username'";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_row($result);
                        ?>
            <span id="acName">
                <ul>
                    <?php echo $row[1]." ".$row[2]; ?>
                    <li class="down-arrow">

                        <a class="dropdown-button" href="#!" data-activates="dropdown" data-beloworigin="true"><i
                                class="material-icons dropdown-button">keyboard_arrow_down</i></a>
                    </li>

                </ul>
                <ul id="dropdown" class="dropdown-content collection">
                    <li><a class="waves-effect waves-blue" href="account.php">Account</a></li>
                    <li><a class="waves-effect waves-blue" href="../logout.php">Logout</a></li>

                </ul>
            </span>
            <ul class="side-nav" id="navigation">
                <li class="icon-container">
                    <img src="../Images/NGCB_logo.png" class="sidenav-logo">
                </li>
                <h3 id="account-type">
                    <?php 
                        if(strcmp($row[5], "MatEng") == 0 ) {
                            echo "Materials Engineer";
                        } else if(strcmp($row[5], "ViewOnly") == 0 ) {
                            echo "View Only";
                        } else {
                            echo "Admin";
                        }
                        }
                    ?>
                </h3>

                <li>
                    <i class="material-icons left">dashboard</i><a class="waves-effect waves-blue"
                        href="admindashboard.php">Dashboard</a>
                </li>


                <ul class="collapsible">
                    <li>
                        <i class="material-icons left">supervisor_account</i><a
                            class="collapsible-header waves-effect waves-blue">Accounts<i
                                class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a class="waves-effect waves-blue" href="accountcreation.php">Create Account</a>
                                </li>
                                <li><a class="waves-effect waves-blue" href="listofaccounts.php">List of Accounts</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <li>
                    <i class="material-icons left">insert_drive_file</i><a class="waves-effect waves-blue"
                        href="projects.php">Projects</a>
                </li>
                <li>
                    <i class="material-icons left">folder</i><a class="waves-effect waves-blue"
                        href="report.php">Logs</a>
                </li>
                <li>
                    <i class="material-icons left">receipt</i><a class="waves-effect waves-blue"
                        href="report.php">Report</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="account-creation-container">
        <form action="../server.php" method="POST">
            <h2 class="header header-two">Create an Account</h2>
            <div class="row">
                <div class="input-field col s5">
                    <input id="firstname" name="firstname" type="text" class="validate create-account-field"
                        pattern="[A-Za-z]*" title="Input only letters" required>
                    <label for="firstname" class="create-account-field">First Name</label>
                </div>

                <div class="input-field col s5">
                    <input id="lastname" name="lastname" type="text" class="validate create-account-field"
                        pattern="[A-Za-z]*" title="Input only letters" required>
                    <label for="lastname" class="create-account-field">Last Name</label>
                </div>

                <div class="input-field col s5">
                    <input id="username" name="username" type="text" class="validate create-account-field"
                        pattern="[A-Za-z0-9]*" title="Input only letters" required>
                    <label for="username" class="create-account-field">Username</label>
                </div>

                <div class="input-field col s5">
                    <input id="email" name="email" type="text" class="validate create-account-field"
                        pattern="[A-Za-z0-9]*@[A-Za-z]*\.[A-Za-z]*" title="Follow the format. Example: email@email.com"
                        required>
                    <label for="email" class="create-account-field">Email</label>
                </div>
                <button class="btn waves-effect waves-light create-account-btn all-btn" type="submit"
                    name="create_account">Create
                    An Account</button>
            </div>
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
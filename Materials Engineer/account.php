<?php
    include "db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
      header('Location: http://127.0.0.1/NGCB/Materials%20Engineer/loginpage.php');
    }
  ?>

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
    <nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large"><i class="material-icons">menu</i></a>
            <span id="NGCB">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</span>

            <ul class="side-nav" id="mobile-demo">
                <li class="collection-item avatar">
                    <?php 
                        if(isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        $sql = "SELECT * FROM accounts WHERE accounts_username = '$username'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_row($result);
                    ?>
                    <span class="title">
                        <?php echo $row[1]." ".$row[2]; ?>
                    </span>
                    <span class="title">
                        <?php echo $row[5]; }?>
                    </span>
                </li>

                <li>
                    <div class="divider"></div>
                </li>

                <li>
                    <a href="dashboard.php">Dashboard</a>
                </li>

                <li>
                    <div class="divider"></div>
                </li>

                <ul class="collapsible">
                    <li>
                        <a class="collapsible-header waves-effect waves-blue">Site<i class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a class="waves-effect waves-blue" href="projects.php">Projects</a></li>
                                <li><a class="waves-effect waves-blue" href="sitematerials.php">Site Materials</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <li>
                    <div class="divider"></div>
                </li>

                <ul class="collapsible">
                    <li>
                        <a class="collapsible-header waves-effect waves-blue">Hauling<i class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a class="waves-effect waves-blue" href="hauling.php">Fill out Hauling Form</a>
                                </li>
                                <li>
                                    <a class="waves-effect waves-blue" href="hauled%20items.php">View Hauled
                                        Materials</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <li>
                    <div class="divider"></div>
                </li>

                <li>
                    <a class="waves-effect waves-blue" href="report.php">Report</a>
                </li>

                <li>
                    <div class="divider"></div>
                </li>

                <li>
                    <a href="account.php">Account Setting</a>
                </li>

                <li>
                    <div class="divider"></div>
                </li>

                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">

        <div class="co-login">
            <div class="row">
                <h4> <i class="small material-icons">settings</i>Account Setting</h4>
            </div>
            <form action="server.php" method="POST">
               <input type="hidden" name="userid"
                    value="<?php if(isset($_SESSION['tasks'])) {echo $_SESSION['tasks'];}?>">
                <div class="f-login username input-field col s6 m8 offset-m1 ">
                    <input id="login-username" name="newusername" type="text">
                    <label class="active" for="newusername">Username</label>
                </div>
                <div class="f-login username input-field col s6 m8 offset-m1 ">
                    <input id="login-username" name="newfname" type="text">
                    <label class="active" for="newfname">First Name</label>
                </div>
                <div class="f-login username input-field col s6 m8 offset-m1 ">
                    <input id="login-username" name="newlname" type="text">
                    <label class="active" for="newlname">Last Name</label>
                </div>
                <div class="f-login username input-field col s6 m8 offset-m1 ">
                    <input id="login-username" name="newemail" type="text">
                    <label class="active" for="newemail">E-mail</label>
                </div>
                <div class="f-login password input-field col s6 m8 offset-m1">
                    <input id="login-password" name="newpassword" type="password">
                    <label class="active" for="newpassword">Password</label>
                </div>
                <div class="row">
                    <div class="col s12 offset-m3">
                        <button class="btn waves-effect waves-light login-btn" type="submit" name="edit_account">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script>
        // SIDEBAR
        $(document).ready(function() {
            $('.button-collapse').sideNav({
                menuWidth: 300, // Default is 300
                edge: 'left', // Choose the horizontal origin
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
                draggable: true // Choose whether you can drag to open on touch screens
            });
            // START OPEN
            $('.button-collapse').sideNav('show');


            //DATEPICKER
            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 15, // Creates a dropdown of 15 years to control year,
                closeOnSelect: false // Close upon selecting a date,
            });

        });

        const btn = document.querySelector('#li-generate');
        const inpt = document.querySelector('#inputValue');
        const ul = document.querySelector('.ulList');

        //const deleteLi = document.querySelector('.remove');

        btn.addEventListener('click', liGenerate);
        document.addEventListener('click', liDelete);

    </script>

</body>

</html>
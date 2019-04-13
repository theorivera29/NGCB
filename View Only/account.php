<?php
    include "../db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
      header('Location: http://127.0.0.1/NGCB/Materials%20Engineer/loginpage.php');
    }
  ?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
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
                    <div class="divider"></div>
                </li>
                <li>
                    <a href="projects.php">Projects</a>
                </li>
                <li>
                    <div class="divider"></div>
                </li>
                <li>
                    <a href="hauleditems.php">Hauled Materials</a>
                </li>
                <li>
                    <div class="divider"></div>
                </li>
                <li>
                    <a href="sitematerials.php">Site Materials</a>
                </li>
                <li>
                    <div class="divider"></div>
                </li>
            </ul>
        </div>
    </nav>



    <div class="card account-container">
        <div class="account-edit-container">
            <div class="row">
                <h4> <i class="small material-icons">settings</i>Account Setting</h4>
            </div>

            <?php 
                        if(isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        $sql = "SELECT 
                        accounts_username, accounts_fname, accounts_lname, accounts_email, accounts_password FROM accounts
                        WHERE accounts_username='$username';";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_row($result);
                    ?>

            <form action="server.php" method="POST">
                <input type="hidden" name="userid"
                    value="<?php if(isset($_SESSION['tasks'])) {echo $_SESSION['tasks'];}?>">
                <div class="input-field col account-edit-field">
                    <input id="login-username" name="newusername" type="text" value=" <?php echo $row[0]?>">
                    <label class="active" for="newusername">Username</label>
                </div>
                <div class="input-field col account-edit-field">
                    <input id="login-username" name="newfname" type="text" value=" <?php echo $row[1]?>">
                    <label class="active" for="newfname">First Name</label>
                </div>
                <div class="input-field col account-edit-field">
                    <input id="login-username" name="newlname" type="text" value=" <?php echo $row[2]?>">
                    <label class="active" for="newlname">Last Name</label>
                </div>
                <div class="input-field col account-edit-field">
                    <input id="login-username" name="newemail" type="text" value=" <?php echo $row[3]?>">
                    <label class="active" for="newemail">E-mail</label>
                </div>
                <div class="input-field col account-edit-field">
                    <input id="login-password" name="newpassword" type="password" value=" <?php echo $row[4]?>">
                    <label class="active" for="newpassword">Password</label>
                </div>

                <?php 
                        }
                    ?>
                <div class="row">
                    <div class="col">
                        <button class="btn waves-effect waves-light" type="submit"
                            name="edit_account">Save</button>
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
        $(document).ready(function () {
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
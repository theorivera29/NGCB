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
    <link rel="stylesheet" text="type/css" href="../materialize/css/materialize.css">
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
                    <i class="material-icons left">assignment</i><a class="waves-effect waves-blue"
                        href="projects.php">Projects</a>
                </li>

                <li>
                    <i class="material-icons left">local_shipping</i><a class="waves-effect waves-blue"
                        href="hauleditems.php">Hauled Materials</a>
                </li>

                <li>
                    <i class="material-icons left">place</i><a class="waves-effect waves-blue"
                        href="sitematerials.php">Site Materials</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="card account-container">
        <div class="account-edit-container">
            <div class="row">
                <h4>Account Setting</h4>
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

            <form action="../server.php" method="POST">
                <div class="row">
                    <input type="hidden" name="userid"
                        value="<?php if(isset($_SESSION['tasks'])) {echo $_SESSION['tasks'];}?>">
                    <div class="input-field col s5 account-username-field">
                        <input id="account-username" name="newusername" type="text" value=" <?php echo $row[0]?>">
                        <label class="active account-setting-label" for="newusername">Username</label>
                    </div>
                    <div class="input-field col s5 account-email-field">
                        <input id="account-email" name="newemail" type="text" value=" <?php echo $row[3]?>">
                        <label class="active account-setting-label" for="newemail">E-mail</label>
                    </div>
                    <div class="input-field col s5 account-firstname-field">
                        <input id="account-firstname" name="newfname" type="text" value=" <?php echo $row[1]?>">
                        <label class="active account-setting-label" for="newfname">First Name</label>
                    </div>
                    <div class="input-field col s5 account-lastname-field">
                        <input id="account-lastname" name="newlname" type="text" value=" <?php echo $row[2]?>">
                        <label class="active account-setting-label" for="newlname">Last Name</label>
                    </div>
                    <div class="input-field col s5 account-newpassword-field">
                        <input id="account-password" name="newpassword" type="password">
                        <label class="active account-setting-label" for="newpassword">New Password</label>
                    </div>
                    <div class="input-field col s5 account-confirmpassword-field">
                        <input id="account-confirmpassword" name="confirmpassword" type="password" value="">
                        <label class="active account-setting-label" for="confirmpassword">Confirm Password</label>
                    </div>
                    <div class="input-field col s5">
                        <input type="checkbox" id="checkbox-new-password" onclick="showNewPassword()" />
                        <label for="checkbox-new-password">Show new password</label>
                    </div>

                    <?php 
                        }
                    ?>
                        <div class="col 12 account-btn">
                            <button class="btn waves-effect waves-light all-btn save-acc-btn" type="submit" name="edit_account">Save</button>
                            <a href="dashboard.php" class="btn waves-effect waves-light all-btn cancel-acc-btn">Cancel</a>
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
       $(document).ready(function() {
            $('.button-collapse').sideNav({
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
            });
            $('.collapsible').collapsible();
            $('.modal-trigger').leanModal();
        });

        const btn = document.querySelector('#li-generate');
        const inpt = document.querySelector('#inputValue');
        const ul = document.querySelector('.ulList');

        //const deleteLi = document.querySelector('.remove');

        btn.addEventListener('click', liGenerate);
        document.addEventListener('click', liDelete);

        function showNewPassword() {
            var show = document.getElementById("account-password");
            if (show.type === "password") {
                show.type = "text";
            } else {
                show.type = "password";
            }
            var showconfirm = document.getElementById("account-confirmpassword");
            if (showconfirm.type === "password") {
                showconfirm.type = "text";
            } else {
                showconfirm.type = "password";
            }
        }
    </script>

</body>

</html>
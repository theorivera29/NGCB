<?php
    include "db_connection.php";
    session_start();

//    if(!isset($_SESSION['loggedin'])) {
//      header('Location: http://127.0.0.1/22619/Materials%20Engineer/loginpage.php');
//    }
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
            <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large pulse"><i class="material-icons">menu</i></a>
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
                </li>
                <li><a href="listofaccounts.php">List of Accounts</a></li>
                <li>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="projects.php">Projects</a></li>
                <li>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="projects.php">Password Request</a></li>
                <li>
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
        <div class="card">
            <table class="striped centered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Account Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        <?php 
                            $sql = "SELECT accounts_id, concat(accounts_fname,', ', accounts_lname) as name, accounts_username, 
                            accounts_email, accounts_type, accounts_status FROM accounts WHERE accounts_deletable = 'yes' AND accounts_status='active';";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)){
                        ?>

                        <tr>
                            <td>
                                <?php echo $row[0] ?>
                            </td>
                            <td>
                                <?php echo $row[1] ?>
                            </td>
                            <td>
                                <?php echo $row[2] ?>
                            </td>
                            <td>
                                <?php echo $row[3] ?>
                            </td>
                            <td>
                                <?php echo $row[4] ?>
                            </td>
                            <td>
                                <?php echo $row[5] ?>
                            </td>
                            <td>
                                <button id="disableBtn" onclick="disablePrompt()">Disable</button>
                            </td>
                        </tr>
                        <?php    
                            }
                        ?>
                    </tbody>
            </table>

        </div>
    </div>


    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js"></script>
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

        function disablePrompt(){
            var disprompt = prompt("Are you sure you want to disable the account");
           
        };
    </script>

</body>

</html>
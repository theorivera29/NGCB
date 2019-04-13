<?php 
    include "../db_connection.php";
?>


<!DOCTYPE html>

<html>

<head>
<title>NGCBDC</title>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../style.css">


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

                <ul class="collapsible">
                    <li>
                        <a class="collapsible-header waves-effect waves-blue">Accounts<i class="material-icons right">keyboard_arrow_down</i></a>
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
                <li><a href="projects.php">Projects</a></li>
                <li>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="passwordrequest.php">Password Request</a></li>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="admindashboard.php">Dashboard</a></li>
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

    <table class="centered striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Activity</th>
                <th>Account</th>
            </tr>
        </thead>

        <tbody>
        <?php 
        $sql = "SELECT 
        logs.logs_datetime,
        logs.logs_activity,
        accounts.accounts_fname
        FROM 
        logs
        INNER JOIN accounts ON logs.logs_logsOf  = accounts.accounts_id;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_row($result)){
        ?>
            <tr>
                <td><?php echo $row[0]; ?></td>
                <td><?php echo $row[1]; ?></td>
                <td><?php echo $row[2]; ?></td>
            </tr>
        <?php 
            }
        ?>
        </tbody>
    </table>


    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script>
        $(document).ready(function() {
            $('.modal-trigger').leanModal();
        });

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
        });

    </script>

</body>

</html>

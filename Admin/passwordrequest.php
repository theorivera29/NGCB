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
                    <i class="material-icons left">vpn_key</i><a class="waves-effect waves-blue"
                        href="passwordrequest.php">Password Request</a>
                </li>
                <li>
                    <i class="material-icons left">insert_drive_file</i><a class="waves-effect waves-blue"
                        href="projects.php">Projects</a>
                </li>
                <li>
                    <i class="material-icons left">folder</i><a class="waves-effect waves-blue"
                        href="logs.php">Logs</a>
                </li>
                <li>
                    <i class="material-icons left">receipt</i><a class="waves-effect waves-blue"
                        href="report.php">Report</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="pass-reset-container">
        <div class="card">
            <table class="centered pass-reset-table">
                <thead class="centered pass-reset-table-head">
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Account Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT accounts.accounts_username, CONCAT(accounts.accounts_fname, ' ', accounts.accounts_lname), accounts.accounts_email,
                                accounts.accounts_type, accounts.accounts_id, request.req_id FROM accounts INNER JOIN request ON accounts.accounts_id = request.req_username;";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row[0];?></td>
                        <td><?php echo $row[1];?></td>
                        <td><?php echo $row[2];?></td>
                        <td><?php echo $row[3];?></td>
                        <td>
                            <form action="../server.php" method="POST">
                                <input type="hidden" name="request_accountID" value="<?php echo $row[4]; ?>">
                                <button type="submit" name="request_accept"  href="#acceptRequest<?php echo $row[5]; ?>"
                                    class="waves-effect waves-light btn modal-trigger all-btn accept-btn">
                                    Accept
                                </button>

                                <input type="hidden" name="request_accountID" value="<?php echo $row[4]; ?>">
                                <button type="submit" name="request_reject"  href="#rejectRequest<?php echo $row[5]; ?>" 
                                    class="waves-effect waves-light btn modal-trigger all-btn reject-btn">
                                    Reject
                                </button>
                                
                                <div id="acceptRequest<?php echo $row[5]; ?>" class="modal modal-question">
                                    <div class="modal-content">
                                        <span class="modal-question-content">Are you sure you are accepting this request?</span>
                                        <br>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="modal-close waves-effect waves-light btn btn-flat no-btn">No</a>
                                        <button type="submit" name="request_accept"
                                            class="modal-close waves-effect waves-light btn-flat yes-btn">Yes</button>
                                    </div>
                                </div>

                                <div id="rejectRequest<?php echo $row[5]; ?>" class="modal modal-question">
                                    <div class="modal-content">
                                        <span class="modal-question-content">Are you sure you are rejecting this request?</span>
                                        <br>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="modal-close waves-effect waves-light btn btn-flat no-btn">No</a>
                                        <button type="submit" name="request_reject"
                                            class="modal-close waves-effect waves-light btn-flat yes-btn">Yes</button>
                                    </div>
                                </div>
                            </form>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script>
         $(document).ready(function () {
            $('.button-collapse').sideNav({
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
            });
            $('.collapsible').collapsible();
            $('.modal-trigger').leanModal();
        });

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("sort");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>

</body>

</html>
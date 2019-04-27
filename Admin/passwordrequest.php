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
            </ul>
        </div>
    </nav>

    <div class="pass-reset-container">
        <div class="card">
            <table id="sort" class="centered pass-reset-table">
                <thead class="centered pass-reset-table-head">
                    <tr>
                        <th onClick="javascript:SortTable(0,'T');">Username<i
                        class="material-icons tiny sort-icon">code</i></th>
                        <th onClick="javascript:SortTable(1,'T');">Name<i
                        class="material-icons tiny sort-icon">code</i></th>
                        <th onClick="javascript:SortTable(2,'T');">E-mail<i
                        class="material-icons tiny sort-icon">code</i></th>
                        <th onClick="javascript:SortTable(3,'T');">Account Type<i
                        class="material-icons tiny sort-icon">code</i></th>
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
    <script type="text/javascript" src="../materialize/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
    <script>
         $(document).ready(function () {
            $('.button-collapse').sideNav({
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
            });
            $('.collapsible').collapsible();
            $('.modal-trigger').leanModal();
        });

        var TableIDvalue = "sort";
        var TableLastSortedColumn = -1;

        function SortTable() {
            var sortColumn = parseInt(arguments[0]);
            var type = arguments.length > 1 ? arguments[1] : 'T';
            var dateformat = arguments.length > 2 ? arguments[2] : '';
            var table = document.getElementById(TableIDvalue);
            var tbody = table.getElementsByTagName("tbody")[0];
            var rows = tbody.getElementsByTagName("tr");
            var arrayOfRows = new Array();
            type = type.toUpperCase();
            dateformat = dateformat.toLowerCase();
            for (var i = 0, len = rows.length; i < len; i++) {
                arrayOfRows[i] = new Object;
                arrayOfRows[i].oldIndex = i;
                var celltext = rows[i].getElementsByTagName("td")[sortColumn].innerHTML.replace(/<[^>]*>/g, "");
                if (type == 'D') {
                    arrayOfRows[i].value = GetDateSortingKey(dateformat, celltext);
                } else {
                    var re = type == "N" ? /[^\.\-\+\d]/g : /[^a-zA-Z0-9]/g;
                    arrayOfRows[i].value = celltext.replace(re, "").substr(0, 25).toLowerCase();
                }
            }
            if (sortColumn == TableLastSortedColumn) {
                arrayOfRows.reverse();
            } else {
                TableLastSortedColumn = sortColumn;
                switch (type) {
                    case "N":
                        arrayOfRows.sort(CompareRowOfNumbers);
                        break;
                    default:
                        arrayOfRows.sort(CompareRowOfText);
                }
            }
            var newTableBody = document.createElement("tbody");
            for (var i = 0, len = arrayOfRows.length; i < len; i++) {
                newTableBody.appendChild(rows[arrayOfRows[i].oldIndex].cloneNode(true));
            }
            table.replaceChild(newTableBody, tbody);
        } // function SortTable()

        function CompareRowOfText(a, b) {
            var aval = a.value;
            var bval = b.value;
            return (aval == bval ? 0 : (aval > bval ? 1 : -1));
        } // function CompareRowOfText()

        function CompareRowOfNumbers(a, b) {
            var aval = /\d/.test(a.value) ? parseFloat(a.value) : 0;
            var bval = /\d/.test(b.value) ? parseFloat(b.value) : 0;
            return (aval == bval ? 0 : (aval > bval ? 1 : -1));
        } // function CompareRowOfNumbers()

        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("sort");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

</body>

</html>
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

    <div class="container">
        <div class="card">
            <table id="sort" class="striped centered">
                <thead class="hauled-items-head">
                    <tr>
                        <th onClick="javascript:SortTable(0,'N');">Hauling forms<i
                                class="material-icons tiny sort-icon">code</i></th>
                        <th onClick="javascript:SortTable(0,'D');">Date<i class="material-icons tiny sort-icon">code</i>
                        </th>
                        <th onClick="javascript:SortTable(0,'T');">Project<i
                                class="material-icons tiny sort-icon">code</i></th>
                        <th onClick="javascript:SortTable(0,'T');">Deliver To<i
                                class="material-icons tiny sort-icon">code</i></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php
                $sql = "SELECT hauling_no, hauling_date, hauling_hauledFrom, hauling_deliverTo FROM  hauling;";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result)) {
                ?>
                <tbody>
                    <td>
                        <?php echo $row[0] ;?>
                    </td>
                    <td>
                        <?php echo $row[1] ;?>
                    </td>
                    <td>
                        <?php echo $row[2] ;?>
                    </td>
                    <td>
                        <?php echo $row[3] ;?>
                    </td>
                    <td>
                        <form action="../server.php" method="POST">
                            <input type="hidden" name="hauling_no" value="<?php echo $row[0]?>">
                            <input type="hidden" name="account_type" value="<?php echo $_SESSION['account_type']; ?>">
                            <button class="waves-effect waves-light btn view-hauled-item-btn" type="submit"
                                name="view_hauled">View</button>
                        </form>
                    </td>
                </tbody>
                <?php
        }
    ?>
            </table>

        </div>
    </div>


    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h4>Delete hauling form?</h4>
            <p>Are you sure you want to delete this form?</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">No</a>
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Yes</a>
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
                    case "D":
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

        function GetDateSortingKey(format, text) {
            if (format.length < 1) {
                return "";
            }
            format = format.toLowerCase();
            text = text.toLowerCase();
            text = text.replace(/^[^a-z0-9]*/, "");
            text = text.replace(/[^a-z0-9]*$/, "");
            if (text.length < 1) {
                return "";
            }
            text = text.replace(/[^a-z0-9]+/g, ",");
            var date = text.split(",");
            if (date.length < 3) {
                return "";
            }
            var d = 0,
                m = 0,
                y = 0;
            for (var i = 0; i < 3; i++) {
                var ts = format.substr(i, 1);
                if (ts == "d") {
                    d = date[i];
                } else if (ts == "m") {
                    m = date[i];
                } else if (ts == "y") {
                    y = date[i];
                }
            }
            d = d.replace(/^0/, "");
            if (d < 10) {
                d = "0" + d;
            }
            m = m.replace(/^0/, "");
            if (m < 10) {
                m = "0" + m;
            }
            y = parseInt(y);
            if (y < 100) {
                y = parseInt(y) + 2000;
            }
            return "" + String(y) + "" + String(m) + "" + String(d) + "";
        } // function GetDateSortingKey()
    </script>
</body>

</html>
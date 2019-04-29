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

<body class="site-materials-body">
    <nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="navigation" class="button-collapse show-on-large menu-icon"><i class="material-icons menuIcon">menu</i></a>
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

                        <a class="dropdown-button" href="#!" data-activates="dropdown" data-beloworigin="true"><i class="material-icons dropdown-button">keyboard_arrow_down</i></a>
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
                    <i class="material-icons left">dashboard</i><a class="waves-effect waves-blue" href="dashboard.php">Dashboard</a>
                </li>


                <ul class="collapsible">
                    <li>
                        <i class="material-icons left">place</i><a class="collapsible-header waves-effect waves-blue">Site<i class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a class="waves-effect waves-blue" href="projects.php">Projects</a></li>
                                <li><a class="waves-effect waves-blue" href="sitematerials.php">Site Materials</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>



                <ul class="collapsible">
                    <li>
                        <i class="material-icons left">local_shipping</i><a class="collapsible-header waves-effect waves-blue">Hauling<i class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a class="waves-effect waves-blue" href="hauling.php">Fill out Hauling Form</a>
                                </li>
                                <li>
                                    <a class="waves-effect waves-blue" href="hauleditems.php">View Hauled
                                        Materials</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <li>
                    <i class="material-icons left">receipt</i><a class="waves-effect waves-blue" href="report.php">Report</a>
                </li>
            </ul>
        </div>
    </nav>



    <div class="site-materials-container">
        <input class="input search-bar" id="myInput" onkeyup="myFunction()" type="search" placeholder="Search...">
        <div class="lighten-5">
            <table id="sort" class="centered striped site-materials-content">
                <thead class="site-materials-head">
                    <tr>
                        <th onClick="javascript:SortTable(0,'T');" id="particular-cell">Particulars</th>
                        <th onClick="javascript:SortTable(1,'T');">Category</th>
                        <th onClick="javascript:SortTable(2,'N');">Previous Material Stock</th>
                        <th onClick="javascript:SortTable(3,'T');">Unit</th>
                        <th onClick="javascript:SortTable(4,'N');">Delivered Material as of
                            <?php echo date("F Y"); ?>
                        </th>
                        <th onClick="javascript:SortTable(5,'N');">Material pulled out as of
                            <?php echo date("F Y"); ?>
                        </th>
                        <th onClick="javascript:SortTable(6,'T');">Unit</th>
                        <th onClick="javascript:SortTable(7,'N');">Accumulated Materials Delivered</th>
                        <th onClick="javascript:SortTable(8,'N');">Material on site as of
                            <?php echo date("F Y"); ?>
                        </th>
                        <th onClick="javascript:SortTable(9,'T');">Unit</th>
                        <th onClick="javascript:SortTable(10,'T');">Project</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $sql_categ = "SELECT DISTINCT categories.categories_name FROM materials 
                    INNER JOIN categories ON materials.mat_categ = categories.categories_id
                    INNER JOIN projects ON materials.mat_project = projects.projects_id
                    ORDER BY categories.categories_name;";
                    $result = mysqli_query($conn, $sql_categ);
                    $categories = array();
                    while($row_categ = mysqli_fetch_assoc($result)){
                        $categories[] = $row_categ;
                    }

                    foreach($categories as $data) {
                    $categ = $data['categories_name'];
                    $sql = "SELECT 
                    mat_name,
                    categories_name, 
                    mat_prevStock, 
                    projects_name,
                    unit_name,
                    mat_id
                    FROM materials 
                    INNER JOIN categories ON materials.mat_categ = categories.categories_id
                    INNER JOIN projects ON materials.mat_project = projects.projects_id
                    INNER JOIN unit ON materials.mat_unit = unit.unit_id
                    WHERE categories.categories_name = '$categ'
                    ORDER BY 1;";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_row($result)){
                        $sql1 = "SELECT SUM(delivered_quantity) FROM deliveredin
                        INNER JOIN materials ON deliveredin.delivered_matName = materials.mat_id
                        WHERE materials.mat_name = '$row[0]';";
                        $result1 = mysqli_query($conn, $sql1);
                        $row1 = mysqli_fetch_row($result1);
                        $sql2 = "SELECT SUM(usage_quantity) FROM usagein
                        INNER JOIN materials ON usagein.usage_matName = materials.mat_id
                        WHERE materials.mat_name = '$row[0]';";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_row($result2);
                ?>
                    <tr>
                        <td>
                            <form action="../server.php" method="POST">
                                <input type="hidden" name="mat_id" value="<?php echo $row[5]?>">
                                <input type="hidden" name="mat_name" value="<?php echo urlencode($row[0])?>">
                                <button class="waves-effect waves-light btn matname-btn" type="submit" name="open_sitestockcard">
                                    <?php echo $row[0] ?></button>
                            </form>

                        </td>
                        <td>
                            <?php echo $row[1] ?>
                        </td>
                        <td>
                            <?php echo $row[2] ?>
                        </td>
                        <td>
                            <?php echo $row[4] ?>
                        </td>
                        <td>
                            <?php 
                                if($row1[0] == null ){
                                    echo 0;
                                } else {
                                    echo $row1[0];
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if($row2[0] == null ){
                                    echo 0;
                                } else {
                                    echo $row2[0];
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo $row[4] ?>
                        </td>
                        <td>
                            <?php echo $row[2]+$row1[0] ?>
                        </td>
                        <td>
                            <?php echo ($row[2]+$row1[0])-$row2[0]  ?>
                        </td>
                        <td>
                            <?php echo $row[4] ?>
                        </td>
                        <td>
                            <?php echo $row[3] ?>
                        </td>
                        <?php 
                            }
                        ?>
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
        // SIDEBAR
        $(document).ready(function() {
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

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
    <div class="site-materials-container">
    <input class="input search-bar" id="myInput" onkeyup="myFunction()" type="search"
                    placeholder="Search...">
        <div class="lighten-5">
            <table id = "sort" class="centered site-materials-content">
                <thead class="site-materials-head">
                    <tr>
                        <th onclick="sortTable(0)">Particulars</th>
                        <th onclick="sortTable(1)">Category</th>
                        <th onclick="sortTable(2)">Previous Material Stock</th>
                        <th>Unit</th>
                        <th onclick="sortTable(3)">Delivered Material as of
                            <?php echo date("F Y"); ?>
                        </th>
                        <th onclick="sortTable(4)">Material pulled out as of
                            <?php echo date("F Y"); ?>
                        </th>
                        <th>Unit</th>
                        <th onclick="sortTable(5)">Accumulated Materials Delivered</th>
                        <th onclick="sortTable(6)">Material on site as of
                            <?php echo date("F Y"); ?>
                        </th>
                        <th>Unit</th>
                        <th onclick="sortTable(7)">Project</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        $sql_categ = "SELECT DISTINCT categories.categories_name FROM materials 
                        INNER JOIN categories ON materials.mat_categ = categories.categories_id
                        ORDER BY categories.categories_name;";
                        $result = mysqli_query($conn, $sql_categ);
                        $categories = array();
                        while($row_categ = mysqli_fetch_assoc($result)){
                            $categories[] = $row_categ;
                        }

                        foreach($categories as $data) {
                        $categ = $data['categories_name'];
                    ?>
                    <?php 
                        $sql = "SELECT 
                        materials.mat_name, 
                        categories.categories_name,
                        materials.mat_prevStock, 
                        materials.delivered_material, 
                        materials.pulled_out, 
                        materials.accumulated_materials,
                        materials.currentQuantity,
                        projects.projects_name
                        FROM materials 
                        INNER JOIN categories ON materials.mat_categ = categories.categories_id
                        INNER JOIN projects ON materials.mat_project = projects.projects_id
                        WHERE categories.categories_name = '$categ';";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)){
                    ?>
                    <tr>
                        <td>
                            <form action="../server.php" method="POST">
                            <input type="hidden" name="mat_name" value="<?php echo urlencode($row[0])?>">
                                <button class="waves-effect waves-light btn matname-btn" type="submit" name="view_open_sitestockcard">
                                    <?php echo $row[0] ?></button>
                            </form>
                        <td>
                            <?php echo $row[1] ?>
                        </td>
                        <td>
                            <?php echo $row[2] ?>
                        </td>
                        <td>
                            Unit
                        </td>
                        <td>
                            <?php echo $row[3] ?>
                        </td>
                        <td>
                            <?php echo $row[4] ?>
                        </td>
                        <td>
                            Unit
                        </td>
                        <td>
                            <?php echo $row[5] ?>
                        </td>
                        <td>
                            <?php echo $row[6] ?>
                        </td>
                        <td>
                            Unit
                        </td>
                        <td>
                            <?php echo $row[7] ?>
                        </td>
                        <?php 
                            }
                        ?>
                    </tr>
                </tbody>
                <?php 
                    }
                ?>
            </table>
            
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
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
            });
            $('.collapsible').collapsible();
            $('.modal-trigger').leanModal();
        });

        $(function() {

            $("table").tablesorter({
                    theme: "materialize",

                    widthFixed: true,
                    // widget code contained in the jquery.tablesorter.widgets.js file
                    // use the zebra stripe widget if you plan on hiding any rows (filter widget)
                    widgets: ["filter", "zebra"],

                    widgetOptions: {
                        // using the default zebra striping class name, so it actually isn't included in the theme variable above
                        // this is ONLY needed for materialize theming if you are using the filter widget, because rows are hidden
                        zebra: ["even", "odd"],

                        // reset filters button
                        filter_reset: ".reset",

                        // extra css class name (string or array) added to the filter element (input or select)
                        // select needs a "browser-default" class or it gets hidden
                        filter_cssFilter: ["", "", "browser-default"]
                    }
                })
                .tablesorterPager({

                    // target the pager markup - see the HTML block below
                    container: $(".ts-pager"),

                    // target the pager page select dropdown - choose a page
                    cssGoto: ".pagenum",

                    // remove rows from the table to speed up the sort of large tables.
                    // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
                    removeRows: false,

                    // output string - default is '{page}/{totalPages}';
                    // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
                    output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

                });

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

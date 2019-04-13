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
    <link rel="stylesheet" text="type/css" href="../materialize/css/etoyungoffine.css">
    <link rel="stylesheet" text="type/css" href="../style.css">
</head>

<body>
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
    <div class="row">
            <form>
                <input class="input search-bar-site-materials" type="search" placeholder="Search">
                <input class="submit search-btn" type="submit" value="SEARCH">
            </form>
        </div>
    </div>
    <div class="site-materials-container">
        <div class="lighten-5">
            <table class="centered site-materials-content">
                <thead class="site-materials-head">
                    <tr>
                        <th>Particulars</th>
                        <th>Previous Material Stock</th>
                        <th>Delivered Material as of
                            <?php echo date("F Y"); ?>
                        </th>
                        <th>Material pulled out as of
                            <?php echo date("F Y"); ?>
                        </th>
                        <th>Accumulated Materials Delivered</th>
                        <th>Material on site as of
                            <?php echo date("F Y"); ?>
                        </th>
                        <th>Project</th>
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
                    <tr>
                        <td colspan="10" class="td-category"> <b>
                                <?php echo $categ; ?></b></td>
                    </tr>
                    <?php 
                        $sql = "SELECT 
                        materials.mat_name, 
                        materials.mat_prevStock, 
                        materials.delivered_material, 
                        materials.pulled_out, 
                        materials.accumulated_materials,
                        materials.currentQuantity,
                        projects.projects_name,
                        materials.mat_unit
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
                                <input type="hidden" name="mat_name" value="<?php echo $row[0]?>">
                                <a class="waves-effect waves-light btn matname-btn modal-trigger" name="view_material" href="#stockcard">
                                    <?php echo $row[0] ?></a>
                            </form>
                            <div id="stockcard" class="modal stock-card-container">
                                <ul class="tabs">
                                    <li class="tab col s3"><a href="#deliverin">Deliver In</a></li>
                                    <li class="tab col s3"><a href="#usagein">Usage In </a></li>
                                </ul>

                                <div id="deliverin">
                                    <div class="row">
                                        <form action="../server.php" method="POST">
                                            <table class="centered">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Quantity</th>
                                                        <th>Unit</th>
                                                        <th>Supplied By</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <input type="hidden" name="mat_name" value="<?php echo $row[0]?>">
                                                        <td><input type="date" min="2019-01-01" required></td>
                                                        <td><input type="text" name="dev_quantity" required></td>
                                                        <td><input type="text" name="dev_unit" value="<?php echo $row[7]?>" required></td>
                                                        <td><input type="text" name="dev_supp" required></td>
                                                    </tr>
                                                    <?php 
                        $dsql = "SELECT * FROM deliveredin;";
                        $dresult = mysqli_query($conn, $dsql);
                        while($drow = mysqli_fetch_row($dresult)){
                    ?>
                                                    <tr>
                                                        <td><?php echo $drow[1]?></td>
                                                        <td><?php echo $drow[2]?></td>
                                                        <td><?php echo $drow[3]?></td>
                                                        <td><?php echo $drow[4]?></td>
                                                    </tr>
                                                    <?php 
                            }
                        ?>
                                                </tbody>
                                            </table>
                                            <div class="modal-footer">
                                                <button class="waves-effect waves-light btn green" type="submit" class="validate" name="add_deliveredin">Save</button>
                                                <a href="#!" class="modal-close waves-effect waves-green btn-flat">CANCEL</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div id="usagein">
                                    <div class="row">
                                        <form action="../server.php" method="POST">
                                            <table class="centered">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Quantity</th>
                                                        <th>Unit</th>
                                                        <th>Pulled Out By</th>
                                                        <th>Area of Usage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <input type="hidden" name="mat_name" value="<?php echo $row[0]?>">
                                                        <td><input type="text" name="us_date"></td>
                                                        <td><input type="text" name="us_quantity" required></td>
                                                        <td><input type="text" name="us_unit" value="<?php echo $row[7]?>" required>
                                                        <td><input type="text" name="pulloutby" required></td>
                                                        <td><input type="text" name="us_area" required></td>
                                                    </tr>
                                                    <?php 
                        $usql = "SELECT * FROM usagein;";
                        $uresult = mysqli_query($conn, $usql);
                        while($urow = mysqli_fetch_row($uresult)){
                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $urow[1]?>
                                                        </td>
                                                        <td>
                                                            <?php echo $urow[2]?>
                                                        </td>
                                                        <td>
                                                            <?php echo $urow[3]?>
                                                        </td>
                                                        <td>
                                                            <?php echo $urow[4]?>
                                                        </td>
                                                        <td>
                                                            <?php echo $urow[5]?>
                                                        </td>
                                                    </tr>
                                                    <?php 
                            }
                        ?>
                                                </tbody>
                                            </table>
                                            <div class="modal-footer">
                                                <button class="waves-effect waves-light btn green" type="submit" class="validate" name="add_usagein">Save</button>
                                                <a href="#!" class="modal-close waves-effect waves-green btn-flat">CANCEL</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
                            <?php echo $row[6] ?>
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
        $(document).ready(function() {
            $('.button-collapse').sideNav({
                menuWidth: 300, // Default is 300
                edge: 'left', // Choose the horizontal origin
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
                draggable: true // Choose whether you can drag to open on touch screens
            });

            $('.modal-trigger').leanModal();

            // START OPEN
            $('.button-collapse').sideNav('show');
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

    </script>
</body>

</html>

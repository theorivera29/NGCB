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
    <title>NGCB</title>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../style.css">
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large"><i class="material-icons">menu</i></a>
            <span id="NGCB">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</span>

            <ul class="side-nav" id="mobile-demo">
                <li class="collection-item avatar">
                    <?php 
                        if(isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        $sql = "SELECT * FROM accounts WHERE accounts_username = '$username'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_row($result);
                    ?>
                    <span class="title">
                        <?php echo $row[1]." ".$row[2]; ?>
                    </span>
                    <span class="title">
                        <?php echo $row[5]; }?>
                    </span>
                </li>

                <li>
                    <div class="divider"></div>
                </li>

                <li>
                    <a href="dashboard.php">Dashboard</a>
                </li>

                <li>
                    <div class="divider"></div>
                </li>

                <ul class="collapsible">
                    <li>
                        <a class="collapsible-header waves-effect waves-blue">Site<i class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a class="waves-effect waves-blue" href="projects.php">Projects</a></li>
                                <li><a class="waves-effect waves-blue" href="sitematerials.php">Site Materials</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <li>
                    <div class="divider"></div>
                </li>

                <ul class="collapsible">
                    <li>
                        <a class="collapsible-header waves-effect waves-blue">Hauling<i class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a class="waves-effect waves-blue" href="hauling.php">Fill out Hauling Form</a>
                                </li>
                                <li>
                                    <a class="waves-effect waves-blue" href="hauled%20items.php">View Hauled
                                        Materials</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <li>
                    <div class="divider"></div>
                </li>

                <li>
                    <a class="waves-effect waves-blue" href="report.php">Report</a>
                </li>

                <li>
                    <div class="divider"></div>
                </li>

                <li>
                    <a href="account.php">Account Setting</a>
                </li>

                <li>
                    <div class="divider"></div>
                </li>

                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

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
                                <input type="hidden" name="mat_name" value="<?php echo $row[0]?>">
                                <a class="waves-effect waves-light btn matname-btn modal-trigger" name="view_material" href="#modal1">
                                    <?php echo $row[0] ?></a>
                            </form>

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
                    <?php 
                    }
                ?>
                </tbody>
            </table>
        </div>
        </div>

        <!--MODAL-->
        <div id="modal1" class="modal modal-fixed-footer">
        <ul class="tabs">
                    <li class="tab col s3"><a href="#ongoing">Ongoing</a></li>
                    <li class="tab col s3"><a href="#closed">Closed</a></li>
                </ul>
            <form action="../server.php" method="POST">
                <div class="modal- ">
                    <div class="content">
                        <div class="row">

                            <div class="col s12">
                                <h4>DELIVER IN</h4>
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
                                            <td><input type="date" name="dev_date"></td>
                                            <td><input type="text" name="dev_quantity"></td>
                                            <td><input type="text" name="unit"></td>
                                            <td><input type="text" name="dev_supp"></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col s12">
                                <h4>USAGE IN</h4>
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
                                            <td contenteditable="true"><input type="date" name="us_date"></td>
                                            <td contenteditable="true"><input type="text" name="us_quantity"></td>
                                            <td contenteditable="true"><select class="browser-default" name="us_unit">
                                                    <option value="UNITS" selected></option>
                                                </select></td>
                                            <td contenteditable="true"><select class="browser-default" name="categories">
                                                    <option value="mat eng namesss" selected></option>
                                                </select></td>
                                            <td contenteditable="true"><input type="text" name="us_area"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="waves-effect waves-light btn green" type="submit" class="validate" name="add_deliveredin">Save</button>
                    <a href="#!" class="modal-close waves-effect waves-green btn-flat">CANCEL</a>
                </div>
            </form>
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

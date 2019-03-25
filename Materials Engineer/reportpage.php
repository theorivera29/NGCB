<?php
    include "db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
      header('Location: http://127.0.0.1/22619/Materials%20Engineer/loginpage.php');
    }
?>

<!DOCTYPE html>

<html>

<head>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link rel="stylesheet" text="type/css" href="../materialize/css/materialize.css">
    <link rel="stylesheet" text="type/css" href="../materialize/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../style.css">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
                        <?php echo $row[1]." ".$row[2]; ?></span>
                    <span class="title">
                        <?php echo $row[5]; }?></span>
                </li>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="dashboard.php">Dashboard</a></li>
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
                                <li><a class="waves-effect waves-blue" href="category.php">Category</a></li>
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
                                <li><a class="waves-effect waves-blue" href="hauling.php">Fill out Hauling Form</a></li>
                                <li><a class="waves-effect waves-blue" href="hauled%20items.php">View Hauled Materials</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <li>
                    <div class="divider"></div>
                </li>
                <li><a class="waves-effect waves-blue" href="report.php">Report</a></li>
                <li>
                    <div class="divider"></div>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="row">
        <div class="col s12 right-align">
            <form action="server.php" method="POST">
                <button class="waves-effect waves-light btn report-btn modal-trigger" type="submit" name="generate_report">
                    <i class="material-icons left">print</i>Generate Report
                </button>
            </form>
        </div>
    </div>
    <div class="report-container">
        <div class="row">
            <div class="col s12 light-blue lighten-5">
                <table class=" striped centered">
                    <thead class="report-head">
                        <tr>
                            <th>Particulars</th>
                            <th>Previous Material Stock</th>
                            <th>Delivered Material as of <?php echo date("F Y"); ?></th>
                            <th>Material Pulled out as of <?php echo date("F Y"); ?></th>
                            <th>Accumulate of Materials Delivered</th>
                            <th>Material on Site as of <?php echo date("F Y"); ?></th>
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
                    <td id="merge-ten-cell"> <b>
                            <?php echo $categ; ?></b></td>
                </tr>
                <?php 
                        $sql = "SELECT 
                        materials.mat_name, 
                        materials.mat_prevStock, 
                        stockcard.stockcard_totalDelivered, 
                        stockcard.stockcard_totalPulledOut, 
                        (stockcard.stockcard_totalDelivered + materials.mat_prevStock), 
                        stockcard.stockcard_quantity
                        FROM materials 
                        INNER JOIN stockcard ON materials.mat_id = stockcard.stockcard_id
                        ORDER BY materials.mat_name;";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)){
                    ?>
                <tr>
                    <td>
                        <?php echo $row[0] ?></a>

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
    </div>




    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js"></script>
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

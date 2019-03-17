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
            <h4 id="NGCB">NEW GOLDEN CITY BUILDERS</h4>
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

    <div class="container site-materials-container center">
        <table>
            <thead>
                <tr>
                    <th>Particulars</th>
                    <th id="merge-two-cell">Previous Material Stock</th>
                    <th>Delivered Material as of
                        <?php echo date("F Y"); ?>
                    </th>
                    <th id="merge-two-cell">Material pulled out as of
                        <?php echo date("F Y"); ?>
                    </th>
                    <th>Accumulated Materials Delivered</th>
                    <th id="merge-two-cell">Material on site as of
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
                        stockcard.stockcard_quantity,
                        projects.projects_name
                        FROM materials 
                        INNER JOIN projects ON materials.mat_project = projects.projects_id 
                        INNER JOIN stockcard ON materials.mat_id = stockcard.stockcard_id
                        INNER JOIN categories ON materials.mat_categ = categories.categories_id
                        WHERE categories.categories_name = '$categ'
                        ORDER BY materials.mat_name;";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)){
                    ?>
                <tr>
                    <td>
                        <form action="server.php" method="POST">
                            <input type="hidden" name="material_name" value="<?php echo $row[0]?>">
                            <a class="waves-effect waves-light btn modal-trigger" href="#modal1">
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

    <div id="modal1" class="modal">
        <div class="modal-content">
            <div class="content">
                <div class="row">
                    <div class="col s12 light-blue lighten-3">
                        <h4>DELIVER IN</h4>
                        <table class="centered blue-grey lighten-5">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Supplied By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT mat_name FROM materials;";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_row($result)) {                         

                            ?>
                                <h1>
                                    <?php echo $row[0]; ?>
                                </h1>

                                <?php 
                                }
                            ?>
                                <tr>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col s12 light-blue lighten-3">
                        <h4>USAGE IN</h4>
                        <table class="centered blue-grey lighten-5">
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
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">SAVE</a>
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">CANCEL</a>
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

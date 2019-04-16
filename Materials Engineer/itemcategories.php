<?php
    include "../db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
      header('Location: http://127.0.0.1/NGCB/index.php');
    }
    $projects_name = $_GET['projects_name'];
    
    $sql = "SELECT projects_status FROM projects WHERE projects_name = '$projects_name'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $projects_status = $row[0];
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

    <?php 
        if(strcmp($projects_status, "open") == 0) {
    ?>
    <div class="row">
            <div class="col 6 m4">
                <form>
                    <input class="input search-bar" type="search" placeholder="Search">
                    <input class="submit search-btn" type="submit" value="SEARCH">
                </form>
            </div>

            <a href="#addmaterialModal" class="waves-effect waves-light btn button add-mat-btn modal-trigger">Add Material</a>
        </div>
    <?php 
        }
    ?>

    <div class="item-categories">
        <?php
        $categories_id = $_GET['categories_id'];
        $sql = "SELECT * FROM  categories WHERE categories_id = '$categories_id';";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)) {
    ?>
        <h5 id="categ-title">
            <?php echo $row[1] ;?>
        </h5>
        <?php
        }
    ?>
        <div class="row">
            <div class="col s12">
                <table class="striped centered ">
                    <thead class="item-categories-head">
                        <tr>
                            <th>Particulars</th>
                            <th>Previous Material Stock</th>
                            <th>Delivered Material as of <?php echo date("F Y"); ?></th>
                            <th>Material Pulled out as of <?php echo date("F Y"); ?></th>
                            <th>Accumulate of Materials Delivered</th>
                            <th>Material on Site as of <?php echo date("F Y"); ?></th>
                            <?php 
                                if(strcmp($projects_status, "open") == 0) {
                            ?>
                            <?php
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $categories_id = $_GET['categories_id'];
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
                        INNER JOIN projects ON materials.mat_project = projects.projects_id WHERE mat_categ = '$categories_id';";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)){
                        ?>
                        <tr>
                            <td>
                                <form action="../server.php" method="POST">
                                   <input type="hidden" name="projects_name" value="<?php echo $projects_name; ?>">
                                    <input type="hidden" name="mat_name" value="<?php echo urlencode($row[0])?>">
                                    <button class="waves-effect waves-light btn matname-btn" name="open_stockcard">
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
                                <?php echo $row[3] ?>
                            </td>
                            <td>
                                <?php echo $row[4] ?>
                            </td>
                            <td>
                                <?php echo $row[5] ?>
                            </td>
                            <?php 
                                if(strcmp($projects_status, "open") == 0) {
                            ?>
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



    <!-- ADD SITE MATERIAL MODAL -->
    <div id="addmaterialModal" class="modal modal-fixed-footer add-mat-modal">
        <form action="../server.php" method="POST">
            <input type="hidden" name="projects_name" value="<?php echo $projects_name?>">
            <div class="modal-content">
                <span id="modal-title">Add Material</span>
                <div class="row">
                    <div class="input-field col add-material-name">
                        <input id="mat_name" name="mat_name" type="text" class="validate" required>
                        <label for="mat_name">Material Name:</label>
                    </div>
                    <div class="col s5">
                        <label>Category:</label>
                        <div class="input-field col s12">
                            <select class="browser-default" id="category-option" name="mat_categ">
                                <option selected>Choose category</option>
                                <?php
                                    $sql = "SELECT categories_id, categories_name FROM categories;";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_row($result)) {                         

                                ?>
                                <option value="<?php echo $row[0]; ?>">
                                    <?php echo $row[1]; ?>
                                </option>
                                <?php 
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s5 material-add-unit">
                        <label>Unit:</label>
                        <select class="browser-default" name="mat_unit">
                            <option selected>Choose unit</option>
                            <?php
                                    $sql = "SELECT DISTINCT mat_unit FROM materials;";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_row($result)) {                         

                                ?>
                            <option value="<?php echo $row[0]; ?>">
                                <?php echo $row[0]; ?>
                            </option>
                            <?php 
                                    }
                                ?>
                        </select>
                    </div>
                    <div class="input-field col add-threshold">
                        <input id="mat_notif" name="mat_notif" type="text" class="validate" pattern="[0-9]*" title="Input only numbers" required>
                        <label for="mat_notif">Item threshold:</label>
                    </div>
                </div>
                <div class="row">
                    <h5>Deliver In</h5>
                    <table class="striped centered">
                        <thead class="view-inventory-head">
                            <tr>
                                <th>Date</th>
                                <th>Quantity</th>
                                <th>Supplied By</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <input type="date" min="2019-01-01" required>
                                </td>
                                <td>
                                    <input id="delivered_quantity" name="dev_quantity" type="text" class="validate" required>
                                </td>
                                <td>
                                    <input id="suppliedBy" name="suppliedBy" type="text" class="validate" required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-light btn-flat cancel-mat-btn">Cancel</a>
                <button type="submit" class="waves-effect waves-light btn-flat save-mat-btn" name="create_materials">Save</button>
            </div>
        </form>
    </div>





    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
    <script>
        // SIDEBAR
        $(document).ready(function () {
            $('.button-collapse').sideNav({
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
            });
            $('.collapsible').collapsible();
            $('.modal-trigger').leanModal();
        });
    </script>

</body>

</html>

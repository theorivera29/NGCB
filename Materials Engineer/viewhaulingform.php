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
                    <i class="material-icons left">dashboard</i><a class="waves-effect waves-blue"
                        href="dashboard.php">Dashboard</a>
                </li>


                <ul class="collapsible">
                    <li>
                        <i class="material-icons left">place</i><a
                            class="collapsible-header waves-effect waves-blue">Site<i
                                class="material-icons right">keyboard_arrow_down</i></a>
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
                        <i class="material-icons left">local_shipping</i><a
                            class="collapsible-header waves-effect waves-blue">Hauling<i
                                class="material-icons right">keyboard_arrow_down</i></a>
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
                    <i class="material-icons left">receipt</i><a class="waves-effect waves-blue"
                        href="report.php">Report</a>
                </li>
            </ul>
        </div>
    </nav>

    <?php
        $hauling_no = $_GET['hauling_no'];
        $sql = "SELECT 
        hauling.hauling_date, 
        hauling.hauling_deliverTo, 
        hauling.hauling_hauledFrom, 
        hauling.hauling_quantity, 
        unit.unit_name, 
        materials.mat_name, 
        hauling.hauling_hauledBy, 
        hauling.hauling_requestedBy,
        hauling.hauling_warehouseman, 
        hauling.hauling_approvedBy, 
        hauling.hauling_truckDetailsType, 
        hauling.hauling_truckDetailsPlateNo, 
        hauling.hauling_truckDetailsPo, 
        hauling.hauling_truckDetailsHaulerDr 
        FROM hauling 
        INNER JOIN unit ON hauling.hauling_unit = unit.unit_id 
        INNER JOIN materials ON hauling.hauling_matname = materials.mat_id
        WHERE hauling_no = '$hauling_no';";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_row($result)){
    ?>

    <div class="row">
        <div class="col s12 right-align">
            <form action="../server.php" method="POST">
                <input type="hidden" name="hauling_no" value="<?php echo $hauling_no ;?>">
                <button class="waves-effect waves-light btn report-btn" type="submit" name="generate_hauling">
                    <i class="material-icons left">print</i>Generate Hauling
                </button>
            </form>
        </div>
    </div>

    <div class="row fill-hauling-form-container">
        <div class="col haulingform-container">
            <div class="card hauling-form">
                <form class="view-hauled-form">
                    <div class="fillout-content">
                        <div class="row">
                            <div class="col">
                                <h4>Hauling Form</h4>
                            </div>
                            <div class="row container-date-hauling">
                                <div class="col">
                                    <h5 id="panel-text date-span">Date:</h5>
                                </div>
                                <div class="col">
                                    <input type="text" disabled value="<?php echo $row[0]?>">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <div class="input-field col deliver-to-field">
                                    <input id="delivername" type="text" disabled value="<?php echo $row[1]?>">

                                    <label for="delivername">Deliver To:</label>
                                </div>
                                <div class="input-field col form-number-field">
                                    <input id="formnumber" type="text" disabled value="<?php echo $hauling_no?>">
                                    <label for="formnumber">Form Number:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <div class="input-field col hauled-from-field">
                                    <input id="hauledfrom" type="text" disabled value="<?php echo $row[2]?>">
                                    <label for="hauledfrom">Hauled From :</label>
                                </div>
                            </div>
                        </div>


                        <div class="col hauling-table-container">
                            <table class="hauling-form-table">
                                <thead class="hauling-form-table-head">
                                    <tr>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Articles</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td><input type="text" id="quantity" disabled value="<?php echo $row[3]?>"></td>
                                        <td><input id="unit" type="text" disabled value="<?php echo $row[4]?>"></td>
                                        <td><input id="materials" type="text" disabled value="<?php echo $row[5]?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col s6 hauled-side-container">
                                <div class="input-field col s10 left-align ">
                                    <input id="requested" type="text" disabled value="<?php echo $row[7]?>">
                                    <label for="requested">Requested :</label>
                                </div>
                                <div class="input-field col s10 left-align ">
                                    <input id="hauledby" type="text" disabled value="<?php echo $row[6]?>">
                                    <label for="hauledby">Hauled by :</label>
                                </div>
                                <div class="input-field col s10 left-align ">
                                    <input id="warehouseman" type="text" disabled value="<?php echo $row[8]?>">
                                    <label for="warehouseman">Warehouseman:</label>
                                </div>
                                <div class="input-field col s10 left-align ">
                                    <input id="approvedby" type="text" disabled value="<?php echo $row[9]?>">
                                    <label for="approvedby">Approved By:</label>
                                </div>
                            </div>
                            <div class="col s6">
                                <table class="striped centered">
                                    <thead>

                                        <tr>
                                            <th> </th>
                                            <th>Truck details</th>
                                            <th> </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>Type:</td>
                                            <td><input type="text" id="truck_type" disabled
                                                    value="<?php echo $row[10]?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Plate No.:</td>
                                            <td><input type="text" id="truck_plate" disabled
                                                    value="<?php echo $row[11]?>"></td>
                                        </tr>
                                        <tr>
                                            <td>P.O/R.S No.:</td>
                                            <td><input type="text" id="truck_po" disabled value="<?php echo $row[12]?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Hauler DR No.:</td>
                                            <td><input type="text" id="truck_hauler" disabled
                                                    value="<?php echo $row[13]?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php
        }
    ?>
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
    </script>

</body>

</html>
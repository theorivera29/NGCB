<?php
    include "../db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
      header('Location: http://127.0.0.1/NGCB/index.php');
    }
$mat_name = $_GET['mat_name'];

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
            <a href="viewinventory.php" data-activates="navigation" class="button-collapse show-on-large menu-icon"><i class="material-icons menuIcon">arrow_back</i></a>
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
            </ul>
        </div>
    </nav>


    <div class="col view-inventory-slider">
        <ul class="tabs tabs-inventory">
            <li class="tab col s3"><a href="#deliverin">Deliver In</a></li>
            <li class="tab col s3"><a href="#usagein">Usage In</a></li>
        </ul>
    </div>

    <div id="deliverin" class="col s12">
        <div class="deliverin-container">
            <form action="../server.php" method="POST">
                <table class="centered deliverin striped">
                    <thead class="deliverin-head">
                        <tr>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Supplied By</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="stockcard-entry">
                            <?php 
                        $sql = "SELECT 
                        unit.unit_name, materials.mat_id FROM materials 
                        INNER JOIN unit ON materials.mat_unit = unit.unit_id
                        WHERE mat_name = '$mat_name';";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)){
                        $mat_id = $row[1];
                        ?>
                            <input type="hidden" name="mat_name" value="<?php echo htmlentities($mat_name); ?>">
                            <input type="hidden" name="mat_id" value="<?php echo $row[1]; ?>">
                            <td>
                                <input type="date" min="2019-01-01" name="dev_date" required>
                            </td>
                            <td>
                                <input id="delivered_quantity" name="dev_quantity" type="text"
                                    class="validate" pattern="[0-9]*" title="Input numbers only"
                                    required>
                            </td>
                            <td>
                                <input id="delivered_unit" name="dev_unit" type="text"
                                    class="validate" value="<?php echo $row[0]; ?>" required>
                            </td>
                            <td>
                                <input id="suppliedBy" name="dev_supp" type="text" class="validate" required>
                            </td>

                        </tr>

                        <?php 
                        $sql_devIn = "SELECT deliveredin.delivered_date, 
                        deliveredin.delivered_quantity, 
                        unit.unit_name, 
                        deliveredin.suppliedBy, 
                        deliveredin.delivered_matName 
                        FROM deliveredin 
                        INNER JOIN unit ON deliveredin.delivered_unit = unit.unit_id 
                        WHERE delivered_matName = '$mat_id'";
                        $result_devIn = mysqli_query($conn, $sql_devIn);
                        while($row_devIn = mysqli_fetch_row($result_devIn)){
                        ?><tr class="deliverin-data">
                            <td>
                                <?php echo $row_devIn[0] ?>
                            </td>
                            <td>
                                <?php echo $row_devIn[1] ?>
                            </td>
                            <td>
                                <?php echo $row_devIn[2] ?>
                            </td>
                            <td>
                                <?php echo $row_devIn[3] ?>
                            </td>
                            </tr>
                             <?php 
                        }
                        ?>
                        <?php 
                        $sql_total = "SELECT SUM(delivered_quantity) FROM deliveredin as total_deliveredin  WHERE delivered_matname = '$mat_id';";
                        $result_total = mysqli_query($conn, $sql_total);
                        while($row_total = mysqli_fetch_row($result_total)){
                        ?>
                        <tr>
                        <td>TOTAL:</td>
                        <td><?php echo $row_total[0]?></td>
                        </tr>
                        <?php 
                        }
                        }
                        ?>
                    </tbody>
                </table>
                <div class="stockcard-btn">
                    <button class="waves-effect waves-light btn save-stockcard-btn" type="submit" class="validate"
                        name="add_deliveredin">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="usagein" class="col s12">
        <div class="usagein-container">
            <form action="../server.php" method="POST">
                <table class="centered usagein striped">
                    <thead class="usagein-head">
                        <tr>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Pulled Out By</th>
                            <th>Area of Usage</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="stockcard-entry">
                            <?php 
                        $sql = "SELECT 
                        unit.unit_name, materials.mat_id FROM materials 
                        INNER JOIN unit ON materials.mat_unit = unit.unit_id
                        WHERE mat_name = '$mat_name';";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)){
                        $mat_id = $row[1];
                        ?>
                            <input type="hidden" name="mat_name" value="<?php echo htmlentities($mat_name); ?>">
                            <input type="hidden" name="mat_id" value="<?php echo $row[1]; ?>">
                            <td>
                                <input type="date" min="2019-01-01" name="us_date" required>
                            </td>
                            <td>
                                <input id="delivered_quantity" name="us_quantity" type="text"
                                    class="validate" pattern="[0-9]*" title="Input numbers only"
                                    required>
                            </td>
                            <td>
                                <input id="us_unit" name="us_unit" type="text" class="validate"
                                    value="<?php echo $row[0]; ?>" required>
                            </td>
                            <td>
                                <input id="pulloutby" name="pulloutby" type="text" class="validate" required>
                            </td>
                            <td>
                                <input id="us_area" name="us_area" type="text" class="validate" required>
                            </td>
                        </tr>
                        <?php 
                        $sql_useIn = "SELECT usagein.usage_date, usagein.usage_quantity, unit.unit_name, usagein.pulledOutBy, usagein.usage_areaOfUsage FROM usagein INNER JOIN unit ON usagein.usage_unit = unit.unit_id WHERE usage_matname = '$mat_id';";
                        $result_useIn = mysqli_query($conn, $sql_useIn);
                        while($row_useIn = mysqli_fetch_row($result_useIn)){
                        ?><tr class="usagein_data">
                            <td>
                                <?php echo $row_useIn[0] ?>
                            </td>
                            <td>
                                <?php echo $row_useIn[1] ?>
                            </td>
                            <td>
                                <?php echo $row_useIn[2] ?>
                            </td>
                            <td>
                                <?php echo $row_useIn[3] ?>
                            </td>
                            <td>
                                <?php echo $row_useIn[4] ?>
                            </td>
                        </tr>
                          <?php 
                        }
                        ?>
                        <?php 
                        $sql_total = "SELECT SUM(usage_quantity) FROM usagein as total_usagein  WHERE usage_matname = '$mat_id';";
                        $result_total = mysqli_query($conn, $sql_total);
                        while($row_total = mysqli_fetch_row($result_total)){
                        ?>
                        <tr>
                            <td>
                                TOTAL:
                            </td>
                            <td>
                                <?php echo $row_total[0] ?>
                            </td>
                        </tr>
                    <?php
                        }
                        }
                            ?>
                </table>
                <div class="stockcard-btn">
                    <button class="waves-effect waves-light btn save-stockcard-btn" type="submit" class="validate"
                        name="add_usagein">Save</button>
                </div>
            </form>
        </div>
    </div>





    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
</body>

</html>
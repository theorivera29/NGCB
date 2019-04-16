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


    <div class="col view-inventory-slider">
        <ul class="tabs tabs-inventory">
            <li class="tab col s3"><a href="#deliverin">Deliver In</a></li>
            <li class="tab col s3"><a href="#usagein">Usage In</a></li>
        </ul>
    </div>

    <div id="deliverin" class="col s12">
        <div class="deliverin-container">
            <form action="../server.php" method="POST">
                <table class="centered deliverin">
                    <?php 
                        $sql = "SELECT 
                        mat_unit, mat_id FROM materials WHERE mat_name = '$mat_name';";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)){
                        ?>
                    <thead class="deliverin-head">
                        <tr>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Supplied By</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <input type="hidden" name="mat_name" value="<?php echo $mat_name; ?>">
                            <input type="hidden" name="mat_id" value="<?php echo $row[1]; ?>">
                            <td>
                                <input type="date" min="2019-01-01" name="dev_date" required>
                            </td>
                            <td>
                                <input id="delivered_quantity" name="dev_quantity" type="text" class="validate view-inventory" pattern="[0-9]*" title="Input numbers only" required>
                            </td>
                            <td>
                                <input id="delivered_quantity" name="dev_unit" type="text" class="validate view-inventory" value="<?php echo $row[0]; ?>" required>
                            </td>
                            <td>
                                <input id="suppliedBy" name="dev_supp" type="text" class="validate" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?echo ?>
                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                        </tr>
                    </tbody>
                    <?php 
                        }
                        ?>
                </table>

            <button class="waves-effect waves-light btn save-stockcard-btn" type="submit" class="validate" name="add_deliveredin">Save</button>
            </form>
        </div>
    </div>

    <div id="usagein" class="col s12">
        <div class="usagein-container">
            <form action="../server.php" method="POST">
                <table class="centered usagein">
                    <?php 
                        $sql = "SELECT 
                        mat_unit, mat_id FROM materials WHERE mat_name = '$mat_name';";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)){
                        ?>
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
                        <tr>
                            <input type="hidden" name="mat_name" value="<?php echo $mat_name; ?>">
                            <input type="hidden" name="mat_id" value="<?php echo $row[1]; ?>">
                            <td>
                                <input type="date" min="2019-01-01" name="us_date" required>
                            </td>
                            <td>
                                <input id="delivered_quantity" name="us_quantity" type="text" class="validate view-inventory" pattern="[0-9]*" title="Input numbers only" required>
                            </td>
                            <td>
                                <input id="us_unit" name="us_unit" type="text" class="validate view-inventory" value="<?php echo $row[0]; ?>" required>
                            </td>
                            <td>
                                <input id="pulloutby" name="pulloutby" type="text" class="validate" required>
                            </td>
                            <td>
                                <input id="us_area" name="us_area" type="text" class="validate" required>
                            </td>
                        </tr>
                    </tbody>
                    <?php 
                        }
                        ?>
                </table>

                <button class="waves-effect waves-light btn green" type="submit" class="validate" name="add_usagein">Save</button>

            <button class="waves-effect waves-light btn save-stockcard-btn" type="submit" class="validate" name="add_usagein">Save</button>

            </form>
        </div>
    </div>





    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script>
        $(document).ready(function() {
            $('.button-collapse').sideNav({
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
            });
            $('.collapsible').collapsible();
            $('.modal-trigger').leanModal();
        });

    </script>

</body>

</html>

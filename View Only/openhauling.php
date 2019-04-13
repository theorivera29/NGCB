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
                    <div class="divider"></div>
                </li>
                <li>
                    <a href="projects.php">Projects</a>
                </li>
                <li>
                    <div class="divider"></div>
                </li>
                <li>
                    <a href="hauleditems.php">Hauled Materials</a>
                </li>
                <li>
                    <div class="divider"></div>
                </li>
                <li>
                    <a href="sitematerials.php">Site Materials</a>
                </li>
                <li>
                    <div class="divider"></div>
                </li>
            </ul>
        </div>
    </nav>
    <?php
                            $hauling_no = $_GET['hauling_no'];
                            $sql = "SELECT * FROM hauling WHERE hauling_no = '$hauling_no';";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)){
                        ?>
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card light-blue lighten-5">
                <div class="card-content sample">

                    <h4>Hauling Form</h4>
                    <form class="sample">
                        <div class="row">
                            <div class="col s8">
                                <label for="date">Date:</label>
                                <input id="date" type="text" disabled value="<?php echo $row[1]?>">
                            </div>
                            <div class="input-field col s2">
                                <input disabled value="<?php echo $row[0]?>" id="formnumber" type="text">
                                <label for="formnumber">Form No.:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div>
                                    <div class="input-field col s12 left-align ">
                                        <input disabled value="<?php echo $row[2]?>" id="delivername" type="text"
                                            class="validate">
                                        <label for="delivername">Deliver To:</label>
                                    </div>
                                    <div class="input-field col s12 left-align ">
                                        <input disabled value="<?php echo $row[3]?>" id="hauledfrom" type="text"
                                            class="validate">
                                        <label for="hauledfrom">Hauled From:</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <table class="striped centered">
                                <thead>
                                    <tr>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Articles</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td><?php echo $row[4]?></td>
                                        <td><?php echo $row[5]?></td>
                                        <td><?php echo $row[6]?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col s6">
                                <div class="input-field col s10 left-align ">
                                    <input disabled value="<?php echo $row[7]?>" id="hauledby" type="text"
                                        class="validate">
                                    <label for="hauledby">Hauled By:</label>
                                </div>
                                <div class="input-field col s10 left-align ">
                                    <input disabled value="<?php echo $row[8]?>" id="warehouseman" type="text"
                                        class="validate">
                                    <label for="warehouseman">Warehouseman:</label>
                                </div>
                                <div class="input-field col s10 left-align ">
                                    <input disabled value="<?php echo $row[9]?>" id="approvedby" type="text"
                                        class="validate">
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
                                            <td><?php echo $row[10]?></td>
                                        </tr>
                                        <tr>
                                            <td>Plate No.:</td>
                                            <td><?php echo $row[11]?></td>
                                        </tr>
                                        <tr>
                                            <td>P.O/R.S No.:</td>
                                            <td><?php echo $row[12]?></td>
                                        </tr>
                                        <tr>
                                            <td>Hauler DR No.:</td>
                                            <td><?php echo $row[13]?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php
        }
    ?>
                        </div>
                    </form>
                </div>
            </div>
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
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
                    <i class="material-icons left">dashboard</i><a class="waves-effect waves-blue"
                        href="projects.php">Projects</a>
                </li>

                <li>
                    <i class="material-icons left">receipt</i><a class="waves-effect waves-blue"
                        href="hauleditems.php">Hauled Materials</a>
                </li>

                <li>
                    <i class="material-icons left">receipt</i><a class="waves-effect waves-blue"
                        href="sitematerials.php">Site Materials</a>
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
            <table class="centered deliverin">
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
                        <td>
                            <input type="date" min="2019-01-01" required>
                        </td>
                        <td>
                            <input id="delivered_quantity" name="dev_quantity" type="text"
                                class="validate view-inventory" pattern="[0-9]*" title="Input numbers only" required>
                        </td>
                        <td>
                            <input id="delivered_quantity" name="dev_unit" type="text" class="validate view-inventory"
                                required>
                        </td>
                        <td>
                            <input id="suppliedBy" name="suppliedBy" type="text" class="validate" required>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div id="usagein" class="col s12">
        <div class="usagein-container">
            <table class="centered usagein">
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
                        <td>
                            <input type="date" min="2019-01-01" required>
                        </td>
                        <td>
                            <input id="delivered_quantity" name="dev_quantity" type="text"
                                class="validate view-inventory" pattern="[0-9]*" title="Input numbers only" required>
                        </td>
                        <td>
                            <input id="delivered_quantity" name="dev_unit" type="text" class="validate view-inventory"
                                required>
                        </td>
                        <td>
                            <input id="suppliedBy" name="suppliedBy" type="text" class="validate" required>
                        </td>
                        <td>
                            <input id="suppliedBy" name="suppliedBy" type="text" class="validate" required>
                        </td>
                    </tr>

                </tbody>
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
                menuWidth: 300, // Default is 300
                edge: 'left', // Choose the horizontal origin
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
                draggable: true // Choose whether you can drag to open on touch screens
            });
            // START OPEN
            $('.button-collapse').sideNav('show');

            $('.modal-trigger').leanModal();

        });
    </script>

</body>

</html>
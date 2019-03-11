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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../style.css">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large"><i class="material-icons">menu</i></a>
            <h4 id="NGCB">New Golden City Builders</h4>
            <ul class="side-nav blue-grey lighten-2" id="mobile-demo">
                <li class="collection-item avatar">
                    <img src="../Images/pic.jpg" alt="" class="circle">
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
                <li><a class="waves-effect waves-blue white-text" href="dashboard.php">Dashboard</a></li>
                <li>
                    <div class="divider"></div>
                </li>
                <ul class="collapsible">
                    <li>
                        <a class="collapsible-header  waves-effect waves-blue white-text">Site<i class="material-icons right">keyboard_arrow_down</i></a>
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
                        <a class="collapsible-header waves-effect waves-blue white-text">Hauling<i class="material-icons right">keyboard_arrow_down</i></a>
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
                <li><a class="waves-effect waves-blue white-text" href="report.php">Report</a></li>
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
        <div class="col s12 m10 offset-m1">
            <div class="card light-blue lighten-5">
                <div class="card-content black-text">
                    <h4>Hauling Form</h4>
                    <div class="row">
                        <div class="col s8">
                            <label>Date:</label>
                            <input id="test" type="date" class="datepicker" value="05/03/2019">
                        </div>
                        <div class="input-field col s2 offset-s2 right-align">
                            <input id="formnumber" type="text" class="validate">
                            <label for="formnumber">Form Number:</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <div>
                                <div class="input-field col s12 left-align ">
                                    <input id="delivername" type="text" class="validate">
                                    <label for="delivername">Deliver To:</label>
                                </div>
                                <div class="input-field col s12 left-align ">
                                    <input id="hauledfrom" type="text" class="validate">
                                    <label for="hauledfrom">Hauled From :</label>
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
                                    <td contenteditable='true'>5</td>
                                    <td contenteditable='true'>pcs</td>
                                    <td contenteditable='true'>Triangular post 4mm</td>
                                </tr>
                                <tr>
                                    <td contenteditable='true'>4</td>
                                    <td contenteditable='true'>pcs</td>
                                    <td contenteditable='true'>Beam truss 3mm</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col s6">
                            <div class="input-field col s10 left-align ">
                                <input id="hauledby" type="text" class="validate">
                                <label for="hauledby">Hauled by :</label>
                            </div>
                            <div class="input-field col s10 left-align ">
                                <input id="warehouseman" type="text" class="validate">
                                <label for="warehouseman">Warehouseman:</label>
                            </div>
                            <div class="input-field col s10 left-align ">
                                <input id="approvedby" type="text" class="validate">
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
                                        <td contenteditable='true'></td>
                                    </tr>
                                    <tr>
                                        <td>Plate No.:</td>
                                        <td contenteditable='true'></td>
                                    </tr>
                                    <tr>
                                        <td>P.O/R.S No.:</td>
                                        <td contenteditable='true'></td>
                                    </tr>
                                    <tr>
                                        <td>Hauler DR No.:</td>
                                        <td contenteditable='true'></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <?php
        $sql = "SELECT * FROM  hauling;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)) {
    ?>
                <div class="card-action right-align">
                    <form action="server.php" method="POST">
                        <input type="hidden" name="hauling_no" value="<?php echo $row[1];?>">
                        <a class="waves-effect waves-light btn green" type="submit" name="create_hauling">Save</a>
                    </form>
                    <a class="waves-effect waves-light btn red">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <?php
        }
    ?>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js"></script>
    <script>
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

            $('.modal-trigger').leanModal();

        });

        $(document).ready(function() {
            $(".datepicker").pickadate({
                closeOnSelect: true,
                format: "dd/mm/yyyy"
            });
        });

    </script>

</body>

</html>

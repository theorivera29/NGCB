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

    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card light-blue lighten-5">
                <form action="server.php" method="POST">
                    <div class="card-content black-text">
                        <h4>Hauling Form</h4>
                        <div class="row">
                            <div class="col s8">
                                <label>Date:</label>
                                <input id="test" type="date" class="datepicker" name="date">
                            </div>
                            <div class="input-field col s2 offset-s2 right-align">
                                <input id="formnumber" type="text" class="validate" name="formnumber">
                                <label for="formnumber">Form Number:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div>
                                    <div class="input-field col s12 left-align ">
                                        <input id="delivername" type="text" class="validate" name="delivername">
                                        <label for="delivername">Deliver To:</label>
                                    </div>
                                    <div class="input-field col s12 left-align ">
                                        <input id="hauledfrom" type="text" class="validate" name="hauledfrom">
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
                                        <td><input type="text" name="quantity[]"></td>
                                        <td><input type="text" name="unit[]"></td>
                                        <td><input type="text" name="articles[]"></td>
                                    </tr>
                                </tbody>
                            </table>
                                <input type="button" class="add-row" value="Add Row">
                        </div>

                        <div class="row">
                            <div class="col s6">
                                <div class="input-field col s10 left-align ">
                                    <input id="hauledby" type="text" class="validate" name="hauledby">
                                    <label for="hauledby">Hauled by :</label>
                                </div>
                                <div class="input-field col s10 left-align ">
                                    <input id="warehouseman" type="text" class="validate" name="warehouseman">
                                    <label for="warehouseman">Warehouseman:</label>
                                </div>
                                <div class="input-field col s10 left-align ">
                                    <input id="approvedby" type="text" class="validate" name="approvedby">
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
                                            <td><input type="text" name="truck_type"></td>
                                        </tr>
                                        <tr>
                                            <td>Plate No.:</td>
                                            <td><input type="text" name="truck_plate"></td>
                                        </tr>
                                        <tr>
                                            <td>P.O/R.S No.:</td>
                                            <td><input type="text" name="truck_po"></td>
                                        </tr>
                                        <tr>
                                            <td>Hauler DR No.:</td>
                                            <td><input type="text" name="truck_hauler"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-action right-align">
                            <button class="waves-effect waves-light btn green" type="submit" name="create_hauling">Save</button>
                        <a class="waves-effect waves-light btn red">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

        $(document).ready(function(){
            $(".add-row").click(function(){
                var quantity = $("#name").val();
                var unit = $("#email").val();
                var articles = $('#articles').val();
                var markup = "<tr>"
                                +"<td><input type=\"text\" name=\"quantity[]\"></td>"
                                +"<td><input type=\"text\" name=\"unit[]\"></td>"
                                +"<td><input type=\"text\" name=\"articles[]\"></td>"
                            +"</tr>;"
                $("table tbody").append(markup);
            });
        });
    </script>

</body>

</html>

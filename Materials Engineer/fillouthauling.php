<?php
    include "../db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
        header('Location: http://127.0.0.1/NGCB/index.php');
    }
    $account_id_loggedin = "";
?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../materialize/css/materialize.css">
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

    <div class="row fill-hauling-form-container">
        <div class="col haulingform-container">
            <div class="card hauling-form">
                <form action="../server.php" method="POST">
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
                                    <input type="date" class="todo-picker hauling-date" name="haulingdate" min="<?php echo date("Y-m-d");?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <div class="input-field col deliver-to-field">
                                    <input id="delivername" type="text" class="validate" name="delivername"
                                        pattern="[A-Za-z0-9\s]*" title="Input only letters">

                                    <label for="delivername">Deliver To:</label>
                                </div>
                                <?php 
                                        $projects_name = $_GET['projects_name'];
                                     ?>
                                <div class="input-field col form-number-field">
                                    <input id="formnumber" type="text" class="validate" name="formnumber"
                                        pattern="[0-9]*" title="Input numbers only">
                                    <label for="formnumber">Form Number:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <div class="input-field col hauled-from-field">
                                    <input id="hauledfrom" type="text" class="validate" name="hauledfrom"
                                        value="<?php echo $projects_name ; ?>">
                                    <label for="hauledfrom">Hauled From :</label>
                                </div>
                            </div>
                        </div>


                        <div class="col hauling-table-container">
                            <table class="hauling-form-table" id="table_mat">
                                <thead class="hauling-form-table-head">
                                    <tr>
                                        <th>Categories</th>
                                        <th>Articles</th>
                                        <th>Unit</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>
                                            <select id="categories" class="browser-default" name="mat_categ">
                                                <option disabled selected>Choose category</option>
                                                <?php
                                                $row = mysqli_fetch_row(mysqli_query($conn, "SELECT projects_id FROM projects WHERE projects_name = '$projects_name';"));
                                                $projects_id = $row[0];
                                                echo "<option>".$projects_id."ASD</option>";
                                                $sql = "SELECT DISTINCT categories.categories_id, categories.categories_name 
                                                FROM categories INNER JOIN materials ON categories.categories_project = materials.mat_categ
                                                WHERE materials.mat_project = $projects_id;";
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
                                        </td>
                                        <td>
                                            <select id="materials" class="browser-default" name="articles">
                                                <option disabled selected>Choose material</option>
                                            </select>
                                        </td>
                                        <td><input id="unit" readonly type="text" name="unit">
                                        </td>
                                        <td><input type="text" name="quantity" id="quantity" class="validate "
                                                pattern="[0-9]*" title="Input numbers only"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col s6 hauled-side-container">
                                <div class="input-field col s10 left-align ">
                                    <input id="requested" type="text" class="validate" name="requested"
                                        pattern="[A-Za-z\s]*" title="Input letters only">
                                    <label for="requested">Requested :</label>
                                </div>
                                <div class="input-field col s10 left-align ">
                                    <input id="hauledby" type="text" class="validate" name="hauledby"
                                        pattern="[A-Za-z\s]*" title="Input letters only">
                                    <label for="hauledby">Hauled by :</label>
                                </div>
                                <div class="input-field col s10 left-align ">
                                    <input id="warehouseman" type="text" class="validate" name="warehouseman"
                                        pattern="[A-Za-z\s]*" title="Input letters only">
                                    <label for="warehouseman">Warehouseman:</label>
                                </div>
                                <div class="input-field col s10 left-align ">
                                    <input id="approvedby" type="text" class="validate" name="approvedby"
                                        pattern="[A-Za-z\s]*" title="Input letters only">
                                    <label for="approvedby">Approved By:</label>
                                </div>
                            </div>
                            <div class="col s6">
                                <table class="centered">
                                    <thead>
                                        <tr>
                                            <th>Truck details</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>Type:</td>
                                            <td><input type="text" name="truck_type" id="truck_type"
                                                    pattern="[A-Za-z\s]*" title="Input only letters"></td>
                                        </tr>
                                        <tr>
                                            <td>Plate No.:</td>
                                            <td><input type="text" name="truck_plate" id="truck_plate"></td>
                                        </tr>
                                        <tr>
                                            <td>P.O/R.S No.:</td>
                                            <td><input type="text" name="truck_po" id="truck_po" minlength="6"
                                                    maxlength="6" title="Alphanumeric only"></td>
                                        </tr>
                                        <tr>
                                            <td>Hauler DR No.:</td>
                                            <td><input type="text" name="truck_hauler" id="truck_hauler"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-action right-align">
                        <button class="waves-effect waves-light btn all-btn save-hauled-btn" type="submit"
                            class="validate" name="create_hauling">Save</button>
                        <a class="waves-effect waves-light btn all-btn cancel-hauled-btn" href="hauling.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

        $('#categories').on('change', function () {
            $.get('http://localhost/NGCB/Materials%20Engineer/../server.php?category_id=' + $(this).children(
                'option:selected').val(), function (data) {
                var d = JSON.parse(data)
                var print_options = '';
                print_options = print_options + `<option disabled selected>Choose your option</option>`
                d.forEach(function (da) {
                    print_options = print_options + `<option value="${da[0]}">${da[1]}</option>`
                })
                $('#materials').html(print_options)
            })
        })

        $('#materials').on('change', function () {
            console.log($(this).children('option:selected').val())
            $.get('http://localhost/NGCB/Materials%20Engineer/../server.php?mat_name=' + $(this).children(
                'option:selected').val(), function (data) {
                var d = JSON.parse(data);
                $('#unit').val(d[0][0])
            })
        })
    </script>
</body>
</html>
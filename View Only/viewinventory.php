<?php
    include "../db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
      header('Location: http://127.0.0.1/NGCB/index.php');
    }

    if(isset($_GET['delivered_matName'])){
        $delivered_matName = $_GET['delivered_matName'];
    }
    $sql = "SELECT delivered_matName FROM deliveredin
    INNER JOIN materials ON deliveredin.delivered_matName = mat_id
    WHERE delivered_matName = '$delivered_matName'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $delivered_matName = $row[0];
    while($row = mysqli_fetch_row($result)){
?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCB</title>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../style.css">
</head>

<body>
<nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large pulse"><i
                    class="material-icons">menu</i></a>
            <h4 id="NGCB">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</h4>
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
                        <?php echo $row[1]." ".$row[2]; ?>
                    </span>
                    <span class="title">
                        <?php echo $row[5]; }?>
                    </span>
                </li>
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
                <li>
                    <a href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="">
        <?php 
           $projects_name = $_GET['projects_name'];
        ?>
        <div class="row">
            <h5>Project Name:
                <?php echo $projects_name; ?>
            </h5>
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a href="#sitematerials">Site Materials</a></li>
                    <li class="tab col s3"><a href="#categories">Categories</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!--SITE MATERIALS-->
    <div id="sitematerials" class="col s12">
        <div class="view-inventory-container">
            <div class="light-blue lighten-5 ">
                <table class="striped centered view-inventory">
                    <thead class="view-inventory-head">
                        <tr>
                            <th>Particulars</th>
                            <th>Previous Material Stock</th>
                            <th>Delivered Material as of
                                <?php echo date("F Y"); ?>
                            </th>
                            <th>Material Pulled out as of
                                <?php echo date("F Y"); ?>
                            </th>
                            <th>Accumulate of Materials Delivered</th>
                            <th>Material on Site as of
                                <?php echo date("F Y"); ?>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php 
                            $projects_name = $_GET['projects_name'];
                            $sql_categ = "SELECT DISTINCT categories.categories_name FROM materials 
                            INNER JOIN categories ON materials.mat_categ = categories.categories_id
                            INNER JOIN projects ON materials.mat_project = projects.projects_id
                            WHERE projects.projects_name = '$projects_name'
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
                            <td colspan="10" class="td-category"> <b>
                                    <?php echo $categ; ?></b></td>
                        </tr>
                        <?php 
                            $sql = "SELECT
                            materials.mat_name, 
                            materials.mat_prevStock, 
                            materials.delivered_material, 
                            materials.pulled_out, 
                            materials.accumulated_materials,
                            materials.currentQuantity
                            FROM materials 
                            INNER JOIN projects ON materials.mat_project = projects.projects_id 
                            INNER JOIN categories ON materials.mat_categ = categories.categories_id
                            WHERE categories.categories_name = '$categ';";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)){
                        ?>

                        <tr>
                        <td>
                            <form action="server.php" method="POST">
                                <input type="hidden" name="account_type" value="<?php echo $_SESSION['account_type']; ?>">
                                <input type="hidden" name="mat_name" value="<?php echo $row[0]?>">
                                <a class="waves-effect waves-light btn matname-btn modal-trigger" name="view_material" href="#modal1">
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
    <!--MODAL-->
    <tr>
                        <td>
                            <form action="../server.php" method="POST">
                                <input type="hidden" name="mat_name" value="<?php echo $row[0]?>">
                            </form>
                            <div id="modal1" class="modal modal-fixed-footer">
                                <ul class="tabs">
                                    <li class="tab col s3"><a href="#deliverin">Deliver In</a></li>
                                    <li class="tab col s3"><a href="#usagein">Usage In </a></li>
                                </ul>

                                <?php
                                $sql = "SELECT delivered_date, delivered_quantity, materials.mat_unit, suppliedBy FROM deliveredin 
                                INNER JOIN materials ON deliveredin.delivered_unit = mat_id
                                WHERE delivered_matName = '$delivered_matName';";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_row($result)){
                                ?>

                                <div id="deliverin">
                                    <div class="row">
                                        <form action="../server.php" method="POST">
                                            <table class="centered">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Quantity</th>
                                                        <th>Unit</th>
                                                        <th>Supplied By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <input type="hidden" name="mat_name" value="<?php echo $row[0]?>">
                                                        <td><input type="date" name="dev_date" value="<?php echo $row[0]?>"></td>
                                                        <td><input type="text" name="dev_quantity" value="<?php echo $row[1]?>"></td>
                                                        <td><input type="text" name="unit" value="<?php echo $row[2]?>"></td>
                                                        <td><input type="text" name="dev_supp" value="<?php echo $row[3]?>"></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <div class="modal-footer">
                                                <a href="#!" class="modal-close waves-effect waves-green btn-flat">CLOSE</a>
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>

                                <div id="usagein">
                                    <div class="row">
                                        <form action="../server.php" method="POST">
                                            <table class="centered">
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
                                                        <td><input type="text" placeholder="yyyy-mm-dd" name="us_date" ></td>
                                                        <td><input type="text" name="us_quantity" required></td>
                                                        <td><select class="browser-default" name="us_unit" required>
                                                                <option value="UNITS" disabled selected>Unit</option>
                                                                <option value="pcs" selected>pcs</option>
                                                                <option value="mtrs" selected>mtrs</option>
                                                                <option value="rolls" selected>rolls</option>
                                                            </select></td>
                                                        <td><input type="text" name="pulloutby" required></td>
                                                        <td><input type="text" name="us_area" required></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="modal-footer">
                                                <a href="#!" class="modal-close waves-effect waves-green btn-flat">CLOSE</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!--SITE CATEGORIES-->
    <div id="categories" class="col s12">
        <div class="row">
            <?php
        $sql = "SELECT categories.categories_id, categories.categories_name FROM  categories 
        INNER JOIN projects ON categories.categories_project = projects.projects_id 
        WHERE projects.projects_name = '$projects_name'
        ORDER BY categories.categories_name;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)) {
    ?>
            <div class="col s3 m3 category-container">
                <div class="card center">
                    <div class="card-content category-cards">
                        <span class="card-title category-title">
                            <?php echo $row[1] ;?>
                        </span>
                        <div class="row">
                            <form action="../server.php" method="POST">
                                <input type="hidden" name="categories_id" value="<?php echo $row[0]?>">
                                <input type="hidden" name="account_type" value="<?php echo $_SESSION['account_type']; ?>">
                                <button class="waves-effect waves-light btn view-inventory-btn" type="submit"
                                    name="view_category">View Inventory</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    ?>
        </div>
        <?php
        }
    ?>
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

            $(".add-row").click(function () {
                var quantity = $("#name").val();
                var unit = $("#email").val();
                var articles = $('#articles').val();
                var markup = "<tr>" +
                    "<td><input type=\"text\" name=\"category_name[]\"></td>" +
                    "</tr>;"
                $("table tbody").append(markup);
            });
        });
    </script>

</body>

</html>
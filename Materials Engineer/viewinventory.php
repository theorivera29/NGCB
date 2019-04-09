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
    <title>NGCB</title>
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
                                class="material-icons right">keyboard_arrow_down</i></a>
                    </li>

                </ul>
                <ul id="dropdown" class="dropdown-content collection">
                    <li><a class="waves-effect waves-blue" href="account.php">Account</a></li>
                    <li><a class="waves-effect waves-blue" href="../logout.php">Logout</a></li>

                </ul>
            </span>
            <ul class="side-nav" id="navigation">
                <li class="icon-container">
                    <ul>
                        <li class="acType">
                            <img src="../Images/NGCB_logo.png" class="sidenav-logo">
                        </li>
                    </ul>
                </li>
                <h3 id="account-type"><?php echo $row[5]; }?></h3>

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
    

    <!--SITE MATERIALS-->
    <div id="sitematerials" class="col s12">
        <?php 
            if(strcmp($projects_status, "open") == 0) {
        ?>
                <div class="row">
                    <div class="col s3 search-bar">
                        <input type="text" placeholder="Search.."> 
                    </div>
                    <div class="col s9 add-material right-align">
                        <a href="#addmaterialModal" class="waves-effect waves-light btn button modal-trigger ">
                        <i class="material-icons left">add_circle_outline</i>Add Material</a>
                    </div>
                </div>
        
        <?php 
            }
        ?>
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
                            <?php 
                                if(strcmp($projects_status, "open") == 0) {
                            ?>
                                <th> Action</th>
                            <?php 
                                }
                            ?>
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
                            materials.currentQuantity,
                            projects.projects_name
                            FROM materials 
                            INNER JOIN categories ON materials.mat_categ = categories.categories_id
                            INNER JOIN projects ON materials.mat_project = projects.projects_id
                            WHERE categories.categories_name = '$categ';";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)){
                        ?>
                        <tr>
                            <td>
                                <form action="../server.php" method="POST">
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
                                if(strcmp($projects_status, "open") == 0) {
                            ?>
                            <td> 
                                <a href="#editmaterialModal" class="waves-effect waves-light btn button modal-trigger edit-material-btn">Edit</a>

                                <!-- EDIT SITE MATERIAL MODAL -->
                                <form action="../server.php" method="POST">
                                    <div id="editmaterialModal" class="modal modal-fixed-footer">
                                        <div class="modal-content">
                                            <h4>Edit Material</h4>
                                            <h6>
                                                <?php echo $row[0];?>
                                            </h6>
                                            <div class="row">
                                                <input type="hidden" name="materialname" value="<?php echo $row[0];?>">
                                                <div class="input-field col s12">
                                                    <input id="newmaterialname" name="newmaterialname" type="text" class="validate">
                                                    <label for="newmaterialname">Material Name:</label>
                                                </div>
                                                <div class="input-field col s5">
                                                    <select class="browser-default" name="mat_unit">
                                                        <option value="" disabled selected>Quantifier</option>
                                                        <option value="pcs">pcs</option>
                                                        <option value="rolls">rolls</option>
                                                        <option value="mtrs">mtrs</option>
                                                    </select>
                                                </div>
                                                <div class="input-field col s7">
                                                    <input id="minquantity" name="minquantity" type="text" class="validate">
                                                    <label for="minquantity">Threshold:</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
                                            <button class="waves-effect waves-light btn green" type="submit" class="validate" name="edit_materials">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <?php 
                                }
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

    <!--SITE CATEGORIES-->
    <div id="categories" class="col s12">
        <div class="row">
            <?php 
                if(strcmp($projects_status, "open") == 0) {
            ?>
            <div class="row add-category">
                <div class="col s12 right-align">
                    <a href="#addcategoryModal" class="waves-effect waves-light btn button modal-trigger">
                        <i class="material-icons left">add_circle_outline</i>Add Category</a>
                    <a href="#editcategoryModal" class="waves-effect waves-light btn button modal-trigger">
                        <i class="material-icons left">edit</i>Edit Category</a>
                </div>
                </div>
            <?php
                }
            ?>
        </div>

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
                <div class="card center category-cards">
                    <div class="card-content ">
                        <span class="card-title category-title">
                            <?php echo $row[1] ;?>
                        </span>
                        <div class="row">
                            <form action="../server.php" method="POST">
                                <input type="hidden" name="account_type" value="<?php echo $_SESSION['account_type']; ?>">
                                <input type="hidden" name="categories_id" value="<?php echo $row[0]?>">
                                <input type="hidden" name="projects_name" value="<?php echo $projects_name?>">
                                <button class="waves-effect waves-light btn view-inventory-btn" type="submit" name="view_category">View Inventory</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    ?>
        </div>
    </div>
    <!-- ADD SITE MATERIAL MODAL -->
    <div id="addmaterialModal" class="modal modal-fixed-footer">
        <form action="../server.php" method="POST">
            <input type="hidden" name="projects_name" value="<?php echo $projects_name?>">
            <div class="modal-content">
                <h4>Add Material</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="mat_name" name="mat_name" type="text" class="validate">
                        <label for="mat_name">Material Name:</label>
                    </div>
                    <div class="col s12">
                        <label>Category:</label>

                        <div class="input-field col s12">
                            <select class="browser-default" name="mat_categ">
                                <option value="" disabled selected>Choose your option</option>
                                <?php
                                    $sql = "SELECT * FROM categories;";
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
                    <div class="row">
                        <div class="col s5">
                            <label>Quantifier:</label>
                        </div>
                    </div>
                    <div class="input-field col s5">
                        <select class="browser-default" name="mat_unit">
                            <option value="" disabled selected>Choose your option</option>
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
                    <div class="input-field col s7">
                        <input id="mat_notif" name="mat_notif" type="text" class="validate">
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
                                <th>Unit</th>
                                <th>Supplied By</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                <input placeholder="yyyy-mm-dd&emsp;▼" type="text" class="datepicker sample-date">
                                </td>
                                <td>
                                    <input id="delivered_quantity" name="delivered_quantity" type="text" class="validate">
                                </td>
                                <td>
                                <select id="unit" class="browser-default" name="unit">
                                                <option selected></option>
                                </select>
                        </td>
                                <td>
                                    <input id="suppliedBy" name="suppliedBy" type="text" class="validate">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
                <button hreg="#addstockcardModal" type="submit" class="waves-effect waves-teal btn-flat" name="create_materials">Save</button>
            </div>
        </form>
    </div>

    <!-- ADD CATEGORY MODAL -->
    <div id="addcategoryModal" class="modal modal-fixed-footer">
        <form action="../server.php" method="POST">
            <div class="modal-content">
                <h4>Add Category</h4>
                <div class="row">
                    <div class="input-field col s12">
                        Category Name:
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <input id="categoryname" type="text" class="validate" name="category_name[]">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="input-field col s12">
                        <button type="button" class="add-row">Add Category<i class="material-icons left">add_circle_outline</i></button>
                        <!-- <a href="#!">Add Category<i class="material-icons left">add_circle_outline</i></a> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
                <button class="modal-close waves-effect waves-green btn-flat" type="submit" name="create_category">Save</button>
            </div>
        </form>
    </div>

    <!-- EDIT MATERIAL MODAL -->
    <div id="editcategoryModal" class="modal modal-fixed-footer">
        <form action="../server.php" method="POST">
            <div class="modal-content">
                <h4>Edit Category</h4>
                <div class="row">
                    <h5>Select category</h5>
                    <div class="input-field col s6">
                        <select class="browser-default" name="category_name">
                            <option>Choose your option</option>
                            <?php
                                $sql = "SELECT categories_name FROM categories;";
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
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="materialname" type="text" class="validate" name="new_category_name">
                        <label for="materialname">New Category Name:</label>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
                <button class="modal-close waves-effect waves-green btn-flat" type="submit" name="edit_category">Save</button>
            </div>
        </form>
    </div>


    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script type="text/javascript" src="../datepicker.js" ></script>
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

            $(".add-row").click(function() {
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

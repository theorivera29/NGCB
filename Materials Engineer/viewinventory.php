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
    <title>NGCB</title>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../style.css">
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large"><i
                    class="material-icons">menu</i></a>
            <span id="NGCB">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</span>

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
                    <a href="dashboard.php">Dashboard</a>
                </li>

                <li>
                    <div class="divider"></div>
                </li>

                <ul class="collapsible">
                    <li>
                        <a class="collapsible-header waves-effect waves-blue">Site<i
                                class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a class="waves-effect waves-blue" href="projects.php">Projects</a></li>
                                <li><a class="waves-effect waves-blue" href="sitematerials.php">Site Materials</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <li>
                    <div class="divider"></div>
                </li>

                <ul class="collapsible">
                    <li>
                        <a class="collapsible-header waves-effect waves-blue">Hauling<i
                                class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a class="waves-effect waves-blue" href="hauling.php">Fill out Hauling Form</a>
                                </li>
                                <li>
                                    <a class="waves-effect waves-blue" href="hauled%20items.php">View Hauled
                                        Materials</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <li>
                    <div class="divider"></div>
                </li>

                <li>
                    <a class="waves-effect waves-blue" href="report.php">Report</a>
                </li>

                <li>
                    <div class="divider"></div>
                </li>

                <li>
                    <a href="account.php">Account Setting</a>
                </li>

                <li>
                    <div class="divider"></div>
                </li>

                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="">
        <?php 
                        if(isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        $sql = "SELECT projects_name FROM projects;";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_row($result);
                    ?>
        <div class="row">
            <span> <?php echo row[0]; ?></span>

            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a href="#sitematerials">Site Materials</a></li>
                    <li class="tab col s3"><a href="#categories">Categories</a></li>
                </ul>
            </div>
        </div>
        <?php    
                            }
                        ?>
    </div>

    <!--SITE MATERIALS-->
    <div id="sitematerials" class="col s12">
        <div class="row">
            <div class="col s11 right-align">
                <a href="#addmaterialModal" class="waves-effect waves-light btn button modal-trigger add-material-btn">
                    <i class="material-icons left">add_circle_outline</i>Add Material</a>
            </div>
        </div>
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
                            <th> Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $projects_name = $_GET['projects_name'];
                            $sql = "SELECT 
                            materials.mat_name, 
                            materials.mat_prevStock, 
                            stockcard.stockcard_totalDelivered, 
                            stockcard.stockcard_totalPulledOut, 
                            (stockcard.stockcard_totalDelivered + materials.mat_prevStock), 
                            stockcard.stockcard_quantity 
                            FROM materials 
                            INNER JOIN projects ON materials.mat_project = projects.projects_id 
                            INNER JOIN stockcard ON materials.mat_id = stockcard.stockcard_id
                            WHERE projects.projects_name = '$projects_name';";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)){
                        ?>

                        <tr>
                            <td>
                                <?php echo $row[0] ?>
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
                            <td> <a href="#editmaterialModal"
                                    class="waves-effect waves-light btn button modal-trigger edit-material-btn">Edit</a>
                            </td>
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
            <div class="col s12 right-align">
                <a href="#addcategoryModal" class="waves-effect waves-light btn button modal-trigger">
                    <i class="material-icons left">add_circle_outline</i>Add Category</a>
                <a href="#editcategoryModal" class="waves-effect waves-light btn button modal-trigger">
                    <i class="material-icons left">edit</i>Edit Category</a>
            </div>
        </div>

        <div class="row">
            <?php
        $sql = "SELECT * FROM  categories ORDER BY categories_name;";
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
                            <form action="server.php" method="POST">
                                <input type="hidden" name="categories_id" value="<?php echo $row[0]?>">
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
    </div>
    <!-- ADD SITE MATERIAL MODAL -->
    <div id="addmaterialModal" class="modal modal-fixed-footer">
        <form action="server.php" method="POST">
            <div class="modal-content">
                <h4>Add Material</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="materialname" name="materialname" type="text" class="validate">
                        <label for="materialname">Material Name:</label>
                    </div>
                    <div class="col s12">
                        <label>Category:</label>

                        <div class="input-field col s12">
                            <select class="browser-default" name="categories">
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
                        <select class="browser-default" name="categories">
                            <option value="" disabled selected>Choose your option</option>

                            <option>

                            </option>

                        </select>
                    </div>
                    <div class="input-field col s7">
                        <input id="minquantity" name="minquantity" type="text" class="validate">
                        <label for="minquantity">Minimum quantity of materials when to be quantified:</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
                <button href="#addstockcardModal" type="submit" class="waves-effect waves-teal btn-flat modal-trigger"
                    name="add_materials">Next</button>
            </div>
        </form>
    </div>

    <!-- ADD STOCKCARD MODAL -->
    <div id="addstockcardModal" class="modal modal-fixed-footer">
        <div class="modal-content">
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
                        <td contenteditable="true"></td>
                        <td contenteditable="true"></td>
                        <td contenteditable="true"></td>
                        <td contenteditable="true"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Save</a>
            <a href="#addmaterialModal" class="modal-close waves-effect waves-teal btn-flat">Back</a>
        </div>
    </div>


    <!-- EDIT SITE MATERIAL MODAL -->
    <div id="editmaterialModal" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Edit Material</h4>
            <div class="row">
                <div class="input-field col s12">
                    <input id="materialname" name="materialname" type="text" class="validate">
                    <label for="materialname">Material Name:</label>
                </div>
                <div class="col s12">
                    <label>Category:</label>

                    <div class="input-field col s12">
                        <select class="browser-default" name="categories">
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
                    <select class="browser-default" name="categories">
                        <option value="" disabled selected>Choose your option</option>

                        <option>

                        </option>

                    </select>
                </div>
                <div class="input-field col s7">
                    <input id="minquantity" name="minquantity" type="text" class="validate">
                    <label for="minquantity">Minimum quantity of materials when to be quantified:</label>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Save</a>
        </div>
    </div>

    <!-- ADD CATEGORY MODAL -->
    <div id="addcategoryModal" class="modal modal-fixed-footer">
        <form action="server.php" method="POST">
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
                        <button type="button" class="add-row">Add Category<i
                                class="material-icons left">add_circle_outline</i></button>
                        <!-- <a href="#!">Add Category<i class="material-icons left">add_circle_outline</i></a> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
                <button class="modal-close waves-effect waves-green btn-flat" type="submit"
                    name="create_category">Save</button>
            </div>
        </form>
    </div>

    <!-- EDIT MATERIAL MODAL -->
    <div id="editcategoryModal" class="modal modal-fixed-footer">
        <form action="server.php" method="POST">
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
                <button class="modal-close waves-effect waves-green btn-flat" type="submit"
                    name="edit_category">Save</button>
            </div>
        </form>
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
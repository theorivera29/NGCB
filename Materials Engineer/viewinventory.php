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
        <h5 class="project-name-inventory">
            <?php echo $projects_name; ?>
        </h5>
        <div class="col view-inventory-slider">
            <ul class="tabs tabs-inventory">
                <li class="tab col s3"><a href="#sitematerials">Project Materials</a></li>
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
            <div class="col 6 m4">

                <input class="input search-bar" id="myInput" onkeyup="myFunction()" type="search"
                    placeholder="Search...">

            </div>
           
           <a href="#addUnitModal"
                class="waves-effect waves-light btn modal-trigger add-unit-btn add-unit-btn-viewinventory">
                Add Unit</a>
            <a href="#addmaterialModal"
                class="waves-effect waves-light btn modal-trigger add-mat-btn add-mat-btn-viewinventory">
                Add Material</a>
        </div>

        <?php 
            }
        ?>
        <div class="view-inventory-container">
            <table id="sort" class="centered striped view-inventory">
                <thead class="view-inventory-head">
                    <tr>
                        <th onclick="sortTable(0)">Particulars</th>
                        <th onclick="sortTable(1)">Category</th>
                        <th onclick="sortTable(2)">Previous Material Stock</th>
                        <th>Unit</th>
                        <th onclick="sortTable(3)">Delivered Material as of
                            <?php echo date("F Y"); ?>
                        </th>
                        <th onclick="sortTable(4)">Material Pulled out as of
                            <?php echo date("F Y"); ?>
                        </th>
                        <th>Unit</th>
                        <th onclick="sortTable(5)">Accumulated Materials Delivered In</th>
                        <th onclick="sortTable(6)">Material on Site as of
                            <?php echo date("F Y"); ?>
                        </th>
                        <th>Unit</th>
                        <?php 
                                if(strcmp($projects_status, "open") == 0) {
                            ?>
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

                    <?php 
                            $sql = "SELECT 
                            materials.mat_name,
                            categories.categories_name, 
                            materials.mat_prevStock, 
                            unit_name,
                            materials.delivered_material, 
                            materials.pulled_out, 
                            unit_name,
                            materials.accumulated_materials,
                            materials.currentQuantity,
                            unit_name,
                            projects.projects_name
                            FROM materials 
                            INNER JOIN categories ON materials.mat_categ = categories.categories_id
                            INNER JOIN projects ON materials.mat_project = projects.projects_id
                            INNER JOIN unit ON materials.mat_unit = unit.unit_id
                            WHERE categories.categories_name = '$categ';";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)){
                        ?>
                    <tr>
                        <td>
                            <form action="../server.php" method="POST">
                                <input type="hidden" name="mat_name" value="<?php echo urlencode($row[0])?>">
                                <input type="hidden" name="projects_name" value="<?php echo $projects_name?>">
                                <button class="waves-effect waves-light btn matname-btn" name="open_stockcard">
                                    <?php echo $row[0] ?></button>
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
                        <td>
                            <?php echo $row[6] ?>
                        </td>
                        <td>
                            <?php echo $row[7] ?>
                        </td>
                        <td>
                            <?php echo $row[8] ?>
                        </td>
                        <td>
                            <?php echo $row[9] ?>
                        </td>
                        <?php 
                                if(strcmp($projects_status, "open") == 0) {
                            ?>
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
        <div id="stockcard" class="modal stockard-status">
            <ul class="tabs">
                <li class="tab col s3 tabs-stockard"><a href="#deliverIn">Deliver In</a></li>
                <li class="tab col s3 tabs-stockard"><a href="#usageIn">Usage In </a></li>
            </ul>

            <div id="deliverIn">
                <div class="row deliverIn-container">
                    <form action="../server.php" method="POST">
                        <table class="deliverIn-container-table centered">
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
                                    <td><input type="date" min="2019-01-01" required></td>
                                    <td><input type="text" name="dev_quantity" type="text"
                                            class="validate view-inventory" pattern="[0-9]*" title="Input numbers only"
                                            required></td>
                                    <td><input type="text" name="dev_unit" value="<?php echo $row[7]?>" required></td>
                                    <td><input type="text" name="dev_supp" required></td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <a href="#!"
                                class="modal-close waves-effect waves-light btn all-btn cancel-mat-btn">Cancel</a>
                            <button class="btn waves-effect waves-light save-mat-btn all-btn" type="submit"
                                class="validate" name="add_deliveredin">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="usageIn">
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
                                    <input type="hidden" name="mat_name" value="<?php echo $row[0]?>">
                                    <td><input type="date" min="2019-01-01" required></td>
                                    <td><input type="text" name="us_quantity" type="text"
                                            class="validate view-inventory" pattern="[0-9]*" title="Input numbers only"
                                            required></td>
                                    <td><input type="text" name="us_unit" value="<?php echo $row[7]?>" required>
                                    <td><input type="text" name="pulloutby" required></td>
                                    <td><input type="text" name="us_area" required></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <a href="#!" class="modal-close waves-effect btn all-btn cancel-mat-btn">Cancel</a>
                            <button class="waves-effect waves-light btn all-btn save-mat-btn" type="submit"
                                class="validate" name="add_usagein">Save</button>
                        </div>
                    </form>
                </div>
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
                    <a href="#addcategoryModal" class="waves-effect waves-light btn modal-trigger all-btn category-btn">
                        Add Category</a>
                    <a href="#editcategoryModal"
                        class="waves-effect waves-light btn modal-trigger all-btn category-btn">
                        Edit Category</a>
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
                                <input type="hidden" name="account_type" value="<?php echo $projects_name; ?>">
                                <input type="hidden" name="account_type"
                                    value="<?php echo $_SESSION['account_type']; ?>">
                                <input type="hidden" name="categories_id" value="<?php echo $row[0]?>">
                                <input type="hidden" name="projects_name" value="<?php echo $projects_name?>">
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
    
    <!-- Add Unit Modal-->
    
    <div id="addUnitModal" class="modal modal-fixed-footer add-unit-modal">
       <form action="../server.php" method="POST">
            <input type="hidden" name="projects_name" value="<?php echo $projects_name?>">
            <div class="modal-content add-categ-modal">
                <span id="modal-title">Add Unit</span>
                <div class="row">
                    <div class="input-field col s12">
                        <input name="category_name" type="text" class="validate field-category" pattern="[A-Za-z0-9\s]*"
                            title="Follow the format. Example: mtrs" required>
                        <label for="category_name">Add Unit:</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-light btn-flat cancel-mat-btn">Cancel</a>
                <button class="modal-close waves-effect waves-light btn-flat save-mat-btn" type="submit"
                    name="create_category">Save</button>
            </div>
        </form>
    </div>
    

    <!-- ADD SITE MATERIAL MODAL -->
    <div id="addmaterialModal" class="modal modal-fixed-footer add-mat-modal">
        <form action="../server.php" method="POST">
            <input type="hidden" name="projects_name" value="<?php echo $projects_name?>">
            <div class="modal-content">
                <span id="modal-title">Add Material</span>
                <div class="row">
                    <div class="input-field col add-material-name">
                        <input id="mat_name" name="mat_name" type="text" class="validate" required>
                        <label for="mat_name">Material Name:</label>
                    </div>
                    <div class="col s5">
                        <label>Category:</label>
                        <div class="input-field col s12">
                            <select class="browser-default" id="category-option" name="mat_categ">
                                <option selected>Choose category</option>
                                <?php
                                    $sql = "SELECT categories_id, categories_name FROM categories;";
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
                </div>
                <div class="row">
                    <div class="col s5 material-add-unit">
                        <label>Unit:</label>
                        <select class="browser-default" name="mat_unit">
                            <option selected>Choose unit</option>
                            <?php
                                    $sql = "SELECT DISTINCT unit.unit_name, materials.mat_unit FROM unit INNER JOIN materials ON materials.mat_id = unit.unit_id";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_row($result)) {                         

                                ?>
                            <option value="<?php echo $row[1]; ?>">
                                <?php echo $row[0]; ?>
                            </option>
                            <?php 
                                    }
                                ?>
                        </select>
                    </div>
                    <div class="input-field col add-threshold">
                        <input id="mat_notif" name="mat_notif" type="text" class="validate view-inventory"
                            pattern="[0-9]*" title="Input only numbers" required>
                        <label for="mat_notif">Item threshold:</label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-light btn-flat cancel-mat-btn">Cancel</a>
                <button type="submit" class="waves-effect waves-light btn-flat save-mat-btn"
                    name="create_materials">Save</button>
            </div>
        </form>
    </div>


    <!-- ADD CATEGORY MODAL -->
    <div id="addcategoryModal" class="modal add-category-modal">
        <form action="../server.php" method="POST">
            <input type="hidden" name="projects_name" value="<?php echo $projects_name?>">
            <div class="modal-content add-categ-modal">
                <span id="modal-title">Add Category</span>
                <div class="row">
                    <div class="input-field col s12">
                        <input name="category_name" type="text" class="validate field-category" pattern="[A-Za-z0-9\s]*"
                            title="Follow the format. Example: Formworks" required>
                        <label for="category_name">Category Name:</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-light btn-flat cancel-mat-btn">Cancel</a>
                <button class="modal-close waves-effect waves-light btn-flat save-mat-btn" type="submit"
                    name="create_category">Save</button>
            </div>
        </form>
    </div>

    <!-- EDIT CATEGORY MODAL -->
    <div id="editcategoryModal" class="modal add-category-modal">
        <form action="../server.php" method="POST">
            <div class="modal-content edit-categ-modal">
                <span id="modal-title">Edit Category</span>
                <div class="row">
                    <input type="hidden" name="projects_name" value="<?php echo $projects_name?>">
                    <div class="input-field col s6">
                        <span id="category-title">Categories</span>
                        <select class="browser-default" id="category-option" name="category_name">
                            <option>Choose category</option>
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
                    <div class="input-field col field-new-category">
                        <input id="materialname" type="text" class="validate" name="new_category_name">
                        <label for="materialname">New Category Name:</label>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-light btn-flat cancel-mat-btn">Cancel</a>
                <button class="modal-close waves-effect waves-light btn-flat save-mat-btn" type="submit"
                    name="edit_category">Save</button>
            </div>
        </form>
    </div>


    <!--Import jQuery before materialize.js-->
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

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("sort");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }

        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("sort");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

</body>

</html>
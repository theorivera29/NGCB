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
                    <i class="material-icons left">assignment</i><a class="waves-effect waves-blue"
                        href="projects.php">Projects</a>
                </li>

                <li>
                <i class="material-icons left">local_shipping</i><a class="waves-effect waves-blue"
                        href="hauleditems.php">Hauled Materials</a>
                </li>

                <li>
                <i class="material-icons left">place</i><a class="waves-effect waves-blue"
                        href="sitematerials.php">Site Materials</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="item-categories">
        <?php
        $categories_id = $_GET['categories_id'];
        $sql = "SELECT * FROM  categories WHERE categories_id = '$categories_id';";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)) {
    ?>
        <h4><?php echo $row[1] ;?></h4>
        <?php
        }
    ?>
        <div class="row">
            <div class="col s12">
                <table class="centered ">
                    <thead class="item-categories-head">
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
                            $categories_id = $_GET['categories_id'];
                            $sql = "SELECT
                            materials.mat_name, 
                            materials.mat_prevStock, 
                            materials.delivered_material, 
                            materials.pulled_out, 
                            materials.accumulated_materials,
                            materials.currentQuantity
                            FROM materials 
                            INNER JOIN categories ON materials.mat_categ = categories.categories_id
                            WHERE categories.categories_id = '$categories_id';";
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
                        </tr>

                        <?php    
                            }
                        ?>
                        <!-- LALABAS LANG TO IF MAY ITEM NA NAKALAGAY, HINDI KO ALAM IF PAANO AYA ICOCOMMENT KO MUNA TO
                        <a href="#" class="waves-effect waves-teal btn modal-trigger">Open</a>
                        <a href="#" class="waves-effect waves-red btn modal-trigger">Delete</a>
                        -->

                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- ADD MATERIAL MODAL -->
    <div id="addmaterialModal" class="modal modal-fixed-footer">
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
                        <select class="browser-default">
                            <option value="" disabled selected>Choose your option</option>
                            <?php
                                $sql = "SELECT categories_name FROM categories;";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_row($result)) {                         

                            ?>
                            <option value="1">
                                <?php echo $row[0]; ?>
                            </option>

                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="input-field col s5">
                    <input id="quantifier" name="quantifier" type="text" class="validate">
                    <label for="quantifier">Quantifier:</label>
                </div>
                <div class="input-field col s7">
                    <input id="minquantity" name="minquantity" type="text" class="validate">
                    <label for="minquantity">Minimum quantity of materials when to be quantified:</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
            <a href="#addstockcardModal" class="waves-effect waves-teal btn-flat modal-trigger">Next</a>
        </div>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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


    <!-- EDIT MATERIAL MODAL -->
    <div id="editmaterialModal" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Edit Material</h4>
            <h5>Old Material Information:</h5>
            <div class="row">
                <div class="input-field col s6">
                    <input disabled value=" Sample Material Name" id="disabled" type="text" class="validate">
                    <label for="disabled">Material Name</label>
                </div>
                <div class="input-field col s6">
                    <input disabled value="Sample Category" id="disabled" type="text" class="validate">
                    <label for="disabled">Category</label>
                </div>
                <div class="input-field col s6">
                    <input disabled value=" Sample Quantifier" id="disabled" type="text" class="validate">
                    <label for="disabled">Quantifier</label>
                </div>
                <div class="input-field col s6">
                    <input disabled value=" Sample Minimum Quantity" id="disabled" type="text" class="validate">
                    <label for="disabled">Minimum quantity of materials when to be quantified:</label>
                </div>
            </div>
            <h5>New Material Information:</h5>
            <div class="row">
                <div class="input-field col s6">
                    <input id="materialname" type="text" class="validate">
                    <label for="materialname">Material Name:</label>
                </div>
                <div class="col s6">
                    <label>Category:</label>
                </div>
                <div class="input-field col s6">
                    <select class="browser-default">
                        <option value="" disabled selected>Choose your option</option>
                        <?php
                            $sql = "SELECT categories_name FROM categories;";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)) {                        
                        ?>
                        <option value="1">
                            <?php echo $row[0]; ?>
                        </option>

                        <?php 
                            }
                        ?>
                    </select>
                </div>
                <div class="input-field col s5">
                    <input id="unit" name="unit" type="text" class="validate">
                    <label for="unit">Unit:</label>
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



    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script>
        $(document).ready(function () {
            $('.button-collapse').sideNav({
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
            });
            $('.collapsible').collapsible();
            $('.modal-trigger').leanModal();
        });
    </script>

</body>

</html>
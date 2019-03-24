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
    <link rel="icon" type="image/png" href="../Images/logo.png">
    <link rel="stylesheet" text="type/css" href="../materialize/css/materialize.css">
    <link rel="stylesheet" text="type/css" href="../materialize/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../style.css">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large"><i class="material-icons">menu</i></a>
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
        <div class="col s12 right-align">
            <a href="#addmaterialModal" class="waves-effect waves-light btn button modal-trigger">
                <i class="material-icons left">add_circle_outline</i>Add Material</a>
            <a href="#editmaterialModal" class="waves-effect waves-light btn button modal-trigger">
                <i class="material-icons left">edit</i>Edit Material</a>
        </div>
    </div>
    
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
                            <th>Delivered Material as of CURRENT DATE</th>
                            <th>Material Pulled out as of CURRENT DATE</th>
                            <th>Accumulate of Materials Delivered</th>
                            <th>Material on Site as of CURRENT DATE</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $categories_id = $_GET['categories_id'];
                            $sql = "SELECT * FROM materials WHERE mat_categ = '$categories_id';";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)){
                        ?>
                        <tr>
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
                            <td> </td>
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

    </script>

</body>

</html>

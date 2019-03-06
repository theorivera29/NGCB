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
                <li><a href="dashboard.php">Dashboard</a></li>
                <li>
                    <div class="divider"></div>
                </li>
                <ul class="collapsible">
                    <li>
                        <a class="collapsible-header  waves-effect waves-blue white-text">Site<i class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a class="waves-effect waves-blue" href="projects.php">Projects</a></li>
                                <li><a class="waves-effect waves-blue" href="sitematerials.html">Site Materials</a></li>
                                <li><a class="waves-effect waves-blue" href="category.html">Category</a></li>
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
                                <li><a class="waves-effect waves-blue" href="hauling.html">Fill out Hauling Form</a></li>
                                <li><a class="waves-effect waves-blue" href="#">View Hauled Materials</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <li>
                    <div class="divider"></div>
                </li>
                <li>Report</li>
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
                <a href="#addmaterialModal" class="waves-effect waves-light btn modal-trigger">
                    <i class="material-icons left">add_circle_outline</i>Add Material</a>
                <a href="#editmaterialModal" class="waves-effect waves-light btn modal-trigger">
                    <i class="material-icons left">edit</i>Edit Material</a>
            </div>
        </div>
        
        <div class="container">
        <div class="row">
            <div class="col s12 light-blue lighten-5">
                <table>
                    <thead>
                        <tr>
                            <th>Particulars</th>
                            <th id="merge-two-cell">Previous Material Stock</th>
                            <th>Delivered Material as of
                                <!--DATE MONTH AND YEAR ONLY BACKEND-->
                            </th>
                            <th id="merge-two-cell">Material pulled out as of
                                <!--DATE MONTH AND YEAR ONLY BACKEND-->
                            </th>
                            <th>Accumulated Materials Delivered</th>
                            <th id="merge-two-cell">Material on site as of
                                <!--DATE MONTH AND YEAR ONLY BACKEND-->
                            </th>
                            <th>Project</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td id="merge-ten-cell">Category
                                <!--Category-->
                            </td>
                        </tr>
                        <tr>
                            <td>Sample
                                <!--MATERIAL-->
                            </td>
                            <td>
                                <!--Quantity-->
                            </td>
                            <td>
                                <!--Quantifier-->
                            </td>
                            <td>
                                <!--Quantity-->
                            </td>
                            <td>
                                <!--Quantity-->
                            </td>
                            <td>
                                <!--Quantifier-->
                            </td>
                            <td>
                                <!--Quantity-->
                            </td>
                            <td>
                                <!--Quantity-->
                            </td>
                            <td>
                                <!--Quantifier-->
                            </td>
                        </tr>
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
                    <input id="materialname" type="text" class="validate">
                    <label for="materialname">Material Name:</label>
                </div>
                <div class="col s12">
                    <label>Category:</label>

                    <div class="input-field col s12">
                        <select class="browser-default">
                            <option value="" disabled selected>Choose your option</option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                        </select>
                    </div>
                </div>
                <div class="input-field col s5">
                    <input id="quantifier" type="text" class="validate">
                    <label for="quantifier">Quantifier:</label>
                </div>
                <div class="input-field col s7">
                    <input id="minquantity" type="text" class="validate">
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
            <h4>Add Stockcard for SAMPLE MATERIAL</h4>
            <!--BACKEND--MAPAPALITAN YUNG "SAMPLE MATERIAL"-->
            <table class="centered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th id="merge-two-cell">Supplied By </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Sample DATE</td>
                        <td>Sample QUANTITY</td>
                        <td>Sample UNIT</td>
                        <td>Sample SUPPLIED BY</td>
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
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                </div>
                <div class="input-field col s5">
                    <input id="quantifier" type="text" class="validate">
                    <label for="quantifier">Quantifier:</label>
                </div>
                <div class="input-field col s7">
                    <input id="minquantity" type="text" class="validate">
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

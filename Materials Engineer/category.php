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
                <a href="#addcategoryModal" class="waves-effect waves-light btn category-btn modal-trigger">
                    <i class="material-icons left">add_circle_outline</i>Add Category</a>
                <a href="#editcategoryModal" class="waves-effect waves-light btn category-btn modal-trigger">
                    <i class="material-icons left">edit</i>Edit Category</a>
            </div>
        </div>
  


    <!-- ADD CATEGORY MODAL -->
    <div id="addcategoryModal" class="modal modal-fixed-footer">
        <form action="server.php" method="POST">
            <div class="modal-content">                                               
                <h4>Add Category</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="categoryname" type="text" class="validate" name="category_name">
                        <label for="categoryname">Category Name:</label>
                    </div>
                    <!-- <div class="input-field col s12">
                        <a href="#!">Add Category<i class="material-icons left">add_circle_outline</i></a>
                    </div> -->
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
                <button class="modal-close waves-effect waves-green btn-flat" type="submit" name="edit_category">Save</button>
            </div>
        </form>
    </div>

    <div class="row"></div>
    <?php
        $sql = "SELECT * FROM  categories ORDER BY categories_name;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)) {
    ?>
    <div class="row">
        <div class="col s3">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title">
                        <?php echo $row[1] ;?></span>
                </div>
                <div class="row">
                    <form action="server.php" method="POST">
                        <input type="hidden" name="categories_id" value="<?php echo $row[0]?>">
                        <button class="waves-effect waves-light btn" type="submit" name="view_category">View Inventory</button>
                    </form>
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

    </script>

</body>

</html>

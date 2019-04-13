<!DOCTYPE html>

<html>

<head>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css" media="screen,projection" />
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

    <div class="container">
        <div class="card">
            <table class="striped centered">
                <thead>
                    <tr>
                        <th>Hauling forms</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <td>asd</td>
                <td>asd</td>
                <td>adasd</td>
            </table>

            <?php
        $sql = "SELECT * FROM  categories;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)) {
    ?>
            <div class="row">
                <div class="col s3">
                    <div class="card blue-grey darken-1">
                        <!-- <a href=blade.html> -->
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
        </div>
    </div>


    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h4>Delete hauling form?</h4>
            <p>Are you sure you want to delete this form?</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">No</a>
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Yes</a>
        </div>
    </div>

    <div class="row">
                                            <a href="#editModal"
                                                class="waves-effect waves-light btn edit-btn modal-trigger">Edit</a>
                                        </div>
   <!--EDIT MODAL-->
    <div id="editModal" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Edit Project:
                <?php echo $row[1]; ?>
            </h4>
            <form action="server.php" method="POST">
                <div class="row">
                    <div class="input-field col s6">
                        <input placeholder="New project name" id="new_project_name" type="text" class="validate"
                            name="new_project_name">
                        <label class="active" for="new_project_name">Project Name:</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="New address" id="new_address" type="text" class="validate"
                            name="new_address">
                        <label for="new_address">Address:</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="New start date" id="new_sdate" type="text" class="validate"
                            name="new_sdate">
                        <label for="new_sdate">Start date:</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="New end date" id="new_edate" type="text" class="validate" name="new_edate">
                        <label for="new_edate">End date:</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
            <input type="hidden" name="project_name" value='<?php echo $row[1]; ?>'>
            <button name="edit_project" class="modal-action modal-close waves-effect waves-green btn-flat">Save
                Changes</button>
        </div>
    </div>
    
    <script src="js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.modal-trigger').leanModal();
        });

    </script>
</body>

</html>






































<?php
    include "db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
      header('Location: http://127.0.0.1/NGCB/Materials%20Engineer/loginpage.php');
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
                
                <ul class="">
                <?php echo $row[1]." ".$row[2]; ?>
                    <li>
                        <a class="dropdown-button" href="#!" data-activates="dropdown" data-beloworigin="true"><i
                                class="material-icons right">keyboard_arrow_down</i></a>
                    </li>
                </ul>
                <ul id="dropdown" class="dropdown-content collection">
                    <li><a class="waves-effect waves-blue" href="account.php">Account</a></li>
                    <li><a class="waves-effect waves-blue" href="logout.php">Logout</a></li>
                    
                </ul>
            </span>
            <ul class="side-nav" id="mobile-demo">

                <li class="collection-item avatar">
                    <ul>
                        <li class="acType">
                            <?php echo $row[5]; }?>
                        </li>
                    </ul>
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

    <!--Calendar and To do Row-->
    <div class="row">
        <div class="col s4 Calendar-Todo-Container">
            <div class="Panel-Header">
                <span>CALENDAR AND TO-DO</span>
            </div>
            <form action="server.php" method="POST">
                <div class="row">
                    <div class="input-field col s3">
                        <label>To-do Date:</label>
                    </div>
                    <div class="col s9">
                        <input placeholder="▼" type="text" class="datepicker">
                    </div>
                </div>
                <input type="hidden" name="todoOf"
                    value="<?php if(isset($_SESSION['tasks'])) {echo $_SESSION['tasks'];}?>">
                <div class="card card-content">
                    <div class="row">
                        <div class="input-field input-field-todo">
                            <textarea id="todo_task" name="todo_task" class="materialize-textarea todo"></textarea>
                            <label for="todo_task" id="todo-label">Input to-do here</label>
                        </div>
                    </div>
                </div>
                <button class="waves-effect waves-light btn green" type="submit" class="validate"
                    name="create_todo">Save</button>
            </form>
        </div>

        <!--Start Calendar and To-do Container-->
        <!--<div class="col s4 Calendar-Todo-Container">
            <div class="Panel-Header">
                <span>CALENDAR AND TO-DO</span>
         </div>
            <form action="server.php" method="POST">
                <div class="row">
                    <div class="input-field col s3">
                       <label>To-do Date:</label>
                    </div>
                       <div class="col s9">
                        <input placeholder="▼" type="text" class="datepicker">
                    </div>
                </div>
                
                <input type="hidden" name="todoOf" value="">
                
                    <div class="row">
                    <div class="input-field col s12">
                       
                        <input id="todo-task" name="todo-task" type="text" class="validate">
                        <label for="todo_task">Input task here:</label>
                    </div>
                    </div>
                
                <button class="waves-effect waves-light btn todo-btn" type="submit" class="validate" name="create_todo">Save</button>
            </form>
        </div>
        -->


        <!--To-do Container-->
        <div class="col s7 Task-Todo-Container">
            <div class="Panel-Header">
                <span>TO-DO TASK</span>
            </div>
            <div class="">
                <table class="striped centered view-inventory">
                    <thead class="view-inventory-head">
                        <tr>
                            <th>Date</th>
                            <th>Task</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                           $task = $_SESSION['tasks'];
                           $sql = "SELECT * FROM todo WHERE todo.todoOf = $task;";
                           $result = mysqli_query($conn, $sql);
                           while($row = mysqli_fetch_array($result)) {
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
                                <form action="server.php" method="POST">
                                    <?php
                                        if(strcasecmp($row[3], 'in progress') == 0) {
                                            ?>
                                    <input type="hidden" name="todo_id" value="<?php echo $row[0]?>">
                                    <input type="hidden" name="todo_status" value="<?php echo $row[3]?>">
                                    <button class="waves-effect waves-light btn modal-trigger"
                                        href="#doneBtn">Done</button>
                                    <div id="doneBtn" class="modal modal-fixed-footer">
                                        <span>Are you sure want to click done?</span>
                                        <div class="modal-footer">
                                            <button class="modal-close waves-effect waves-red btn-flat">No</button>
                                            <button type="submit" name="todo_update"
                                                class="modal-close waves-effect waves-red btn-flat">Yes</button>
                                        </div>
                                    </div>
                                    <?php
                                        } else {
                                            ?>
                                    <input type="hidden" name="todo_id" value="<?php echo $row[0]?>">
                                    <input type="hidden" name="todo_status" value="<?php echo $row[3]?>">
                                    <button class="waves-effect waves-light btn modal-trigger"
                                        href="#clearBtn">Clear</button>
                                    <div id="clearBtn" class="modal modal-fixed-footer">
                                        <span>Are you sure want to clear this task</span>
                                        <div class="modal-footer">
                                            <button class="modal-close waves-effect waves-red btn-flat">No</button>
                                            <button type="submit" name="todo_update"
                                                class="modal-close waves-effect waves-red btn-flat">Yes</button>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </form>
                            </td>
                        </tr>
                        <?php    
                            }
                        ?>
                    </tbody>
                </table>


            </div>
            <a class="waves-effect waves-light btn modal-trigger" href="#viewAllTask">View ALl Task</a>
        </div>

    </div>

    <!--Materials Container-->
    <div class="row ">
        <!--Table-->
        <div class="Material-Left-Container">
            <table class="striped responsive-table centered">
                <div class="Panel-Header">
                    <span>MATERIALS</span>
                </div>
                <thead>
                    <tr>
                        <th>Material Name</th>
                        <th>Category</th>
                        <th>Quantity Remaining</th>
                        <th>Unit</th>
                        <th>Project</th>
                    </tr>
                </thead>
                <?php 
                    $sql = "SELECT 
                    materials.mat_name, 
                    categories.categories_name, 
                    stockcard.stockcard_quantity, 
                    materials.mat_unit,
                    projects.projects_name
                    FROM materials 
                    INNER JOIN categories ON materials.mat_categ = categories.categories_id 
                    INNER JOIN stockcard ON materials.mat_id = stockcard.stockcard_id 
                    INNER JOIN projects ON materials.mat_project = projects_id
                    WHERE materials.mat_notif >= stockcard.stockcard_quantity AND projects.projects_status = 'open';";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_array($result)) {
                ?>
                <tbody>
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
                    </tr>
                </tbody>
                <?php
            }
        ?>
            </table>
        </div>
    </div>






    <div id="viewAllTask" class="modal modal-fixed-footer">
        <table class="striped centered view-inventory">
            <thead class="view-inventory-head">
                <tr>
                    <th>Date</th>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                           $task = $_SESSION['tasks'];
                           $sql = "SELECT * FROM todo WHERE todo.todoOf = $task;";
                           $result = mysqli_query($conn, $sql);
                           while($row = mysqli_fetch_array($result)) {
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
                        <button class="waves-effect waves-light btn modal-trigger" href="#doneBtn">Done</button>
                        <button class="waves-effect waves-light btn modal-trigger" href="#doneBtn">Clear</button>
                    </td>
                </tr>
                <?php    
                            }
                        ?>
            </tbody>
        </table>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>

        </div>
    </div>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script src="../datepicker.js"></script>
    <script>
        // SIDEBAR
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

        (function($) {
		$(function() {

				$(".dropdown-button").dropdown();

		}); // End Document Ready
})(jQuery);
    </script>

</body>

</html>
<?php
    include "db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
      header('Location: http://127.0.0.1/NGCB/Materials%20Engineer/loginpage.php');
    }
    $task = $_SESSION['tasks'];
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
                
                <ul >
                <?php echo $row[1]." ".$row[2]; ?>
                    <li class="down-arrow">
                    
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
                            <img src="../Images/NGCB_logo.png">
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
                        <a class="collapsible-header waves-effect waves-blue">Site<i class="material-icons right">keyboard_arrow_down</i></a>
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
                        <a class="collapsible-header waves-effect waves-blue">Hauling<i class="material-icons right">keyboard_arrow_down</i></a>
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
                    <div class="col s4">
                    <input placeholder="yyyy-mm-dd&emsp;▼" type="text" class="datepicker" name="tododate">
                    </div>
                </div>
                <input type="hidden" name="todoOf" value="<?php if(isset($_SESSION['tasks'])) {echo $_SESSION['tasks'];}?>">
                <div class="row">
                    <div class="input-field input-field-todo">
                        <textarea id="todo_task" name="todo_task" class="materialize-textarea todo" required></textarea>
                        <label for="todo_task" id="todo-label">Input to-do here:</label>
                    </div>
                </div>
                <button class="waves-effect waves-light btn green" type="submit" class="validate" name="create_todo">Save</button>
                <!--HINDI KO MAPAGANA
                   <div id="savetodo" class="modal">
                    <div class="modal-content">
                        <span>Are you sure want to save this task?</span>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class="modal-close waves-effect waves-red btn-flat">No</a>
                        <button type="submit" class="modal-close waves-effect waves-green btn-flat">Yes</button>
                    </div>
                </div>
                -->
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
                        <th>Threshold</th>
                    </tr>
                </thead>
                <?php 
                    $sql = "SELECT 
                    materials.mat_name, 
                    categories.categories_name, 
                    materials.currentQuantity, 
                    materials.mat_unit,
                    projects.projects_name,
                    materials.mat_notif
                    FROM materials 
                    INNER JOIN categories ON materials.mat_categ = categories.categories_id
                    INNER JOIN projects ON materials.mat_project = projects_id
                    WHERE materials.mat_notif >= currentQuantity AND projects.projects_status = 'open';";
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
                        <td>
                            <?php echo $row[5] ?>
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

        (function($) {
		$(function() {

				$(".dropdown-button").dropdown();

		}); // End Document Ready
})(jQuery);



    </script>

</body>
</html>

<?php
    include "../db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
      header('Location: http://127.0.0.1/NGCB/index.php');
    }
    $task = $_SESSION['tasks'];
?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCB</title>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.min.css" rel="stylesheet">

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
                                    <a class="waves-effect waves-blue" href="hauled%20items.php">View Hauled
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

    <!--Calendar and To do Row-->
    <div class="row">
        <div class="col s4 container container-addtask">
            <h5 id="panel-header">Add To-do Task</h5>
            <div class="container-to-do">
                <form action="../server.php" method="POST">
                    <div class="row container-date">
                        <div class="col s2">
                            <h5 id="panel-text">Date:</h5>
                        </div>
                        <div class="col s4">
                            <input placeholder="yyyy-mm-dd&emsp;▼" type="text" class="datepicker todo-picker"
                                name="tododate">
                        </div>
                    </div>
                    <input type="hidden" name="todoOf"
                        value="<?php if(isset($_SESSION['tasks'])) {echo $_SESSION['tasks'];}?>">

                    <div class="input-field input-field-todo">
                        <textarea id="todo_task" name="todo_task" class="materialize-textarea" minlength="2" maxlength="50" pattern="[A-Za-z0-9]{50}" required></textarea>
                        <div class="container-counter">
                            <span id="characters">50</span><span id="char"> characters</span>
                        </div>
                    </div>

                    <button class="btn waves-effect waves-light save-todo-btn" type="submit" class="validate"
                        name="create_todo">Save</button>
            </div>
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
            <form action="../server.php" method="POST">
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
        <h5 id="panel-header-task">To-do Task</h5>
        <div class="col s7 container-task-todo">
            <div class="container-all-task">
                <table class="striped centered view-tasks">
                    <thead class="view-tasks-head">
                        <tr class="task-headers">
                            <th>Date</th>
                            <th>Task</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody class="task-table-container">
                        <?php 
                           $sql = "SELECT * FROM todo WHERE todo.todoOf = $task;";
                           $result = mysqli_query($conn, $sql);
                           while($row = mysqli_fetch_array($result)) {
                        ?>

                        <tr >
                            <td class="task-data-table1">
                                <?php echo $row[1] ?>
                            </td>
                            <td class="task-data-table2">
                                <?php echo $row[2] ?>
                            </td>
                            <td class="task-data-table">
                                <?php echo $row[3] ?>
                            </td>
                            <td class="task-data-table">
                                <form action="../server.php" method="POST">
                                    <?php
                                        if(strcasecmp($row[3], 'in progress') == 0) {
                                            ?>
                                    <input type="hidden" name="todo_id" value="<?php echo $row[0]?>">
                                    <input type="hidden" name="todo_status" value="<?php echo $row[3]?>">
                                    <button class="waves-effect waves-light btn modal-trigger"
                                        href="#doneBtn">Done</button>
                                    <div id="doneBtn" class="modal">
                                        <div class="modal-content">
                                            <span>Are you sure want to click done?</span>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="modal-close waves-effect waves-red btn-flat">No</a>
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
                                    <div id="clearBtn" class="modal">
                                        <div class="modal-content">
                                            <span>Are you sure want to clear this task</span>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="modal-close waves-effect waves-red btn-flat">No</a>
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
                <a class="waves-effect waves-light btn modal-trigger task-btn" href="#viewAllTask">View ALl Task</a>
            </div>
        </div>

    </div>

    <!--Materials Container-->
    <div class="row ">
        <div class="container container-materialsLeft">
        <h5 id="panel-header">Material</h5>
            <table class="striped responsive-table centered">
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
    <table class="striped centered view-tasks">
                    <thead class="view-tasks-head">
                        <tr class="task-headers">
                            <th>Date</th>
                            <th>Task</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody class="task-table-container">
                        <?php 
                           $sql = "SELECT * FROM todo WHERE todo.todoOf = $task;";
                           $result = mysqli_query($conn, $sql);
                           while($row = mysqli_fetch_array($result)) {
                        ?>

                        <tr >
                            <td class="task-data-table1">
                                <?php echo $row[1] ?>
                            </td>
                            <td class="task-data-table2">
                                <?php echo $row[2] ?>
                            </td>
                            <td class="task-data-table">
                                <?php echo $row[3] ?>
                            </td>
                            <td class="task-data-table">
                                <form action="../server.php" method="POST">
                                    <?php
                                        if(strcasecmp($row[3], 'in progress') == 0) {
                                            ?>
                                    <input type="hidden" name="todo_id" value="<?php echo $row[0]?>">
                                    <input type="hidden" name="todo_status" value="<?php echo $row[3]?>">
                                    <button class="waves-effect waves-light btn modal-trigger"
                                        href="#doneBtn">Done</button>
                                    <div id="doneBtn" class="modal">
                                        <div class="modal-content">
                                            <span>Are you sure want to click done?</span>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="modal-close waves-effect waves-red btn-flat">No</a>
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
                                    <div id="clearBtn" class="modal">
                                        <div class="modal-content">
                                            <span>Are you sure want to clear this task</span>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="modal-close waves-effect waves-red btn-flat">No</a>
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
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.min.js">
    </script>
    <script type="text/javascript" src="../datepicker.js"></script>
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

        (function ($) {
            $(function () {

                $(".dropdown-button").dropdown();

            }); // End Document Ready
        })(jQuery);

        //For the length of textarea todo
        var maxLength = 50;
        $('textarea').keyup(function () {
            var length = $(this).val().length;
            var length = maxLength - length;
            $('#characters').text(length);
        });
    </script>

</body>

</html>
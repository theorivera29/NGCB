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
                    class="material-icons">menu</i></a>

            <ul class="side-nav" id="mobile-demo">
                <span id="NGCB">New Golden City Builders and Development Corporation</span>
                <span id="NGCB">New Golden City Builders and Development Corporation</span>
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
                                <a class="waves-effect waves-light btn modal-trigger" href="#clearBtn">Clear</a>
                                <a class="waves-effect waves-light btn modal-trigger" href="#doneBtn">Done</a>
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

    <div id="doneBtn" class="modal modal-fixed-footer">
        <span>Are you sure want to click done?</span>
        <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">No</a>
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Yes</a>
        </div>
    </div>

    <div id="clearBtn" class="modal modal-fixed-footer">
        <span>Are you sure want to clear this task</span>
        <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">No</a>
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Yes</a>
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
                        <button>SAMPLE</button>
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
    </script>

</body>

</html>
<?php
    include "../db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
        header('Location: http://127.0.0.1/NGCB/index.php');
    }
    $account_id = $_SESSION['account_id'];
?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../materialize/css/materialize.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
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


                <ul class="collapsible" data-collapsible="accordion">
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



                <ul class="collapsible" data-collapsible="accordion">
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
                            <input type="date" class="todo-picker" name="tododate" id="dateID" required>
                        </div>
                    </div>
                    <input type="hidden" name="todoOf"
                        value="<?php if(isset($_SESSION['account_id'])) {echo $_SESSION['account_id'];}?>">

                    <div class="input-field input-field-todo">
                        <textarea id="todo_task" name="todo_task" class="materialize-textarea" minlength="2"
                            maxlength="50" pattern="[A-Za-z0-9]{50}" required></textarea>
                        <div class="container-counter">
                            <span id="characters">50</span><span id="char"> characters</span>
                        </div>
                    </div>

                    <button class="btn waves-effect waves-light save-todo-btn" type="submit" class="validate"
                        name="create_todo">Save</button>
                </form>
            </div>
        </div>

        <!--To-do Container-->

        <h5 id="panel-header-task">Today's To-do Task</h5>
        <a class="waves-effect waves-light btn task-btn" href="viewalltasks.php">View All Task</a>

        <div class="col s7 container-task-todo">
            <div class="container-all-task">
                <table class="striped centered view-tasks">
                    <?php
                        $date_today = date("Y-m-d");
                        $sql = "SELECT * FROM todo WHERE todo.todoOf = $account_id && todo_date = '$date_today' ORDER BY todo_task;";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0){
                    ?>
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
                            while($row = mysqli_fetch_row($result)) {
                        ?>
                        <tr>
                            <td class="task-data-table1">
                                <?php echo $row[1] ;?>
                            </td>
                            <td class="task-data-table2">
                                <?php echo $row[2] ;?>
                            </td>
                            <td class="task-data-table">
                                <?php echo $row[3] ;?>
                            </td>
                            <td class="task-data-table">
                                <form action="../server.php" method="POST">
                                    <?php
                                        if(strcasecmp($row[3], 'in progress') == 0) {
                                    ?>
                                    <input type="hidden" name="todo_id" value="<?php echo $row[0];?>">
                                    <input type="hidden" name="todo_status" value="<?php echo $row[3];?>">
                                    <input type="hidden" name="update_from" value="dashboard">
                                    <button class="waves-effect waves-light btn modal-trigger doneBtn"
                                        href="#doneBtn<?php echo $row[0];?>">Done</button>
                                    <div id="doneBtn<?php echo $row[0];?>" class="modal modal-question">
                                        <div class="modal-content">
                                            <span class="modal-question-content">Are you sure you are done with this
                                                task?</span>
                                            <br>
                                            <?php echo $row[2];?>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="modal-close waves-effect waves-light btn btn-flat no-btn">No</a>
                                            <button type="submit" name="todo_update"
                                                class="modal-close waves-effect waves-light btn-flat yes-btn">Yes</button>
                                        </div>
                                    </div>
                                    <?php
                                        } else {
                                    ?>
                                    <input type="hidden" name="todo_id" value="<?php echo $row[0];?>">
                                    <input type="hidden" name="todo_status" value="<?php echo $row[3];?>">
                                    <input type="hidden" name="update_from" value="dashboard">
                                    <button class="waves-effect waves-light btn modal-trigger clearBtn"
                                        href="#clearBtn<?php echo $row[0];?>">Clear</button>
                                    <div id="clearBtn<?php echo $row[0];?>" class="modal modal-question">
                                        <div class="modal-content">
                                            <span class="modal-question-content">Are you sure you want to clear this
                                                task?</span>
                                            <br>
                                            <?php echo $row[2];?>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="modal-close waves-effect waves-red btn-flat no-btn">No</a>
                                            <button type="submit" name="todo_update"
                                                class="modal-close waves-effect waves-red btn-flat yes-btn">Yes</button>
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
                            } else {
                            ?>
                        <tr>
                            <h3 id="no-task-text">No task for today</h3>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--Materials Container-->
    <div class="row">
        <h5 id="panel-header-materials">Materials Low in Quantity</h5>
        <div class="col container-materials">
            <table id="sort" class="striped responsive-table materials-left centered">
                <thead class="view-materials-head">
                    <tr class="material-headers">
                        <th onclick="sortTable(0)">Material Name<i class="material-icons tiny sort-icon">code</i></th>
                        <th onclick="sortTable(1)">Category<i class="material-icons tiny sort-icon">code</i></th>
                        <th onclick="sortTable(2)">Quantity Remaining<i class="material-icons tiny sort-icon">code</i>
                        </th>
                        <th onclick="sortTable(3)">Unit<i class="material-icons tiny sort-icon">code</i></th>
                        <th onclick="sortTable(4)">Threshold<i class="material-icons tiny sort-icon">code</i></th>
                        <th onclick="sortTable(5)">Project<i class="material-icons tiny sort-icon">code</i></th>
                    </tr>
                </thead>
                <?php 
                    $sql = "SELECT DISTINCT
                    materials.mat_name, 
                    categories.categories_name,  
                    materials.currentQuantity,
                    unit.unit_name,
                    materials.mat_notif,
                    projects.projects_name
                    FROM materials 
                    INNER JOIN categories ON materials.mat_categ = categories.categories_id
                    INNER JOIN projects ON materials.mat_project = projects_id
                    INNER JOIN unit ON materials.mat_unit = unit.unit_id
                    INNER JOIN projacc ON projacc.projacc_project = materials.mat_project
                    WHERE  
                    projects.projects_status = 'open'
                    AND projacc.projacc_mateng = '$account_id'
                    AND materials.currentQuantity <= materials.mat_notif;";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_array($result)) {
                ?>
                <tbody class="materials-left-container">
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
                </tbody>
            </table>
        </div>
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

            //Display Only Date till today // 
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var today = year + '-' + month + '-' + day;
            $('#dateID').attr('min', today);

        });

        //For the length of textarea todo
        var maxLength = 50;
        $('textarea').keyup(function () {
            var length = $(this).val().length;
            var length = maxLength - length;
            $('#characters').text(length);
        });

        $('textarea').keypress(function (event) {
            if ((event.keyCode || event.which) == 13) {
                event.preventDefault();;
                return false;
            }
        });
        $('textarea').keyup(function () {
            var keyed = $(this).val().replace(/\n/g, '<br/>');

            $(this).html(keyed);

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
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
                        <a class="collapsible-header waves-effect waves-blue white-text">Hauling<i class="material-icons right">keyboard_arrow_down</i></a>
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
                <li><a class="waves-effect waves-blue white-text" href="report.php">Report</a></li>
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
        <!--Start Calendar and To-do Container-->
        <div class="col s6 Calendar-Todo-Container">
            <div class="Panel-Header">
                <span>CALENDAR AND TO-DO</span>
            </div>
            <div class="Calendar-Container">
                <span id="text-headers">Calendar:</span>
                <input type="text" class="datepicker">
            </div>
            <div class="card card-content">
                <div class="row">
                    <div class="input-field input-field-todo col s8">
                        <textarea id="todo_area" class="materialize-textarea todo"></textarea>
                        <label for="todo_area" id="todo-label">Input to-do here</label>
                    </div>
                </div>
            </div>
            <a class="waves-effect waves-light btn todo-btn"><i class="material-icons right">note_add</i>Add to-do</a>
        </div>

        <div class="col s5 Task-Container">
            <div class="Panel-Header">
                <span>TO-DO TASK</span>
            </div>
            <div class="">
                <span id="text-headers">Task Today:</span>
            </div>
            <div class="">
                <span id="text-headers">Task Tomorrow:</span>
            </div>
            <a class="waves-effect waves-light btn task-btn"><i class="material-icons right">note_add</i>View All Task</a>
        </div>
        <div class="col s5  Task-Container">
            <div class="Panel-Header">
                <span>CURRENT PROJECTS</span>
            </div>
            <div class="">
                <span id="text-headers">Expansion</span>
            </div>
            <div class="">
                <span id="text-headers">SAMPLE</span>
            </div>
            <a class="waves-effect waves-light btn task-btn"><i class="material-icons right">note_add</i>View All Project</a>
        </div>
    </div>

    <div class="row ">
        <!--Table-->
        <div class="col s10 Material-Left-Container">
            <table class="striped responsive-table ">

                <div class="Panel-Header">
                    <span>MATERIALS</span>
                </div>

                <thead>
                    <tr>
                        <th>Material Name</th>
                        <th>Category</th>
                        <th>Quantity Remaining</th>
                        <th>Unit</th>
                    </tr>
                </thead>
                <?php 
            $sql = "SELECT 
            materials.mat_name, 
            categories.categories_name, 
            stockcard.stockcard_quantity, 
            materials.mat_unit 
            FROM materials 
            INNER JOIN categories ON materials.mat_categ = categories.categories_id 
            INNER JOIN stockcard ON materials.mat_id = stockcard.stockcard_id 
            WHERE materials.mat_notif >= stockcard.stockcard_quantity;";
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
                    </tr>
                </tbody>
                <?php
            }
        ?>
            </table>
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
            });

            //DATEPICKER
            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 15, // Creates a dropdown of 15 years to control year,
                today: 'Today',
                clear: 'Clear',
                close: 'Ok',
                closeOnSelect: false // Close upon selecting a date,
            });

            const btn = document.querySelector('#li-generate');
            const inpt = document.querySelector('#inputValue');
            const ul = document.querySelector('.ulList');

            //const deleteLi = document.querySelector('.remove');

            btn.addEventListener('click', liGenerate);
            document.addEventListener('click', liDelete);

            function liGenerate(e) {
                const li = document.createElement('li');

                if (inpt.value !== "") {
                    li.className = "collection-item red-text lighten-2";
                    //const liContent = document.createTextNode(`${inpt.value}`);
                    li.innerHTML = `${inpt.value} <div class='remove'>X</div>`;

                    //li.appendChild(liContent);
                    ul.appendChild(li);

                    inpt.value = "";
                }
                e.preventDefault();
            }

            function liDelete(e) {
                if (e.target.className === 'remove') {
                    e.target.parentElement.remove();
                }
            }

        </script>

</body>

</html>

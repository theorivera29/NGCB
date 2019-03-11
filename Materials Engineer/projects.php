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
                <li><a class="waves-effect waves-blue white-text" href="dashboard.php">Dashboard</a></li>
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
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>


    <div class="row">
        <div class="col s12 right-align">
            <a href="#addProjectModal" class="waves-effect waves-light btn modal-trigger add-btn">
                <i class="material-icons left">add_circle_outline</i>Add Project</a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a href="#ongoing">Ongoing</a></li>
                    <li class="tab col s3"><a href="#closed">Closed</a></li>
                </ul>
            </div>

            <div id="ongoing" class="col s12">
                <div class="row">
                    <?php 
                        $sql = "SELECT * FROM projects WHERE projects_status = 'open';";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="col s12 m6">
                        <div class="card blue-grey darken-1 center">
                            <div class="card-content white-text">
                                <span class="card-title">
                                    <?php echo $row[1] ?> </span>
                                <p>
                                    <?php echo $row[2] ?>
                                </p>
                                <p>Start Date:
                                    <?php echo $row[3] ?>
                                </p>
                                <p>End Date:
                                    <?php echo $row[4] ?>
                                </p>
                                <div class="row">
                                    <form action="server.php" method="POST">
                                        <input type="hidden" name="projects_name" value="<?php echo $row[1]?>">
                                        <button class="waves-effect waves-light btn" type="submit" name="view_inventory">View Inventory</button>
                                    </form>
                                    <a href="#editModal" class="waves-effect waves-light btn modal-trigger">Edit</a>
                                </div>
                                <?php 
                                    if (strtotime($row[3]) > strtotime ($row[4])) {
                                ?>
                                <div class="row">
                                    <a href="#closeModal" class="waves-effect waves-light btn red modal-trigger">Close Project</a>
                                </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <h4>Edit Project:
                        <?php echo $row[1]; ?>
                    </h4>
                    <form action="server.php" method="POST">
                        <div class="row">
                            <div class="input-field col s6">
                                <input placeholder="New project name" id="new_project_name" type="text" class="validate" name="new_project_name">
                                <label class="active" for="new_project_name">Project Name:</label>
                            </div>
                            <div class="input-field col s6">
                                <input placeholder="New address" id="new_address" type="text" class="validate" name="new_address">
                                <label for="new_address">Address:</label>
                            </div>
                            <div class="input-field col s6">
                                <input placeholder="New start date" id="new_sdate" type="text" class="validate" name="new_sdate">
                                <label for="new_sdate">Start date:</label>
                            </div>
                            <div class="input-field col s6">
                                <input placeholder="New end date" id="new_edate" type="text" class="validate" name="new_edate">
                                <label for="new_edate">End date:</label>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="project_name" value='<?php echo $row[1]; ?>'>
                    <button name="edit_project" class="modal-action modal-close waves-effect waves-green btn-flat">Save Changes<button>
                            </form>
                </div>
            </div>

            <div id="closeModal" class="modal">
                <div class="modal-content">
                    <h4>Close Project?</h4>
                    <p>Are you sure you want to close this project?</p>
                </div>
                <div class="modal-footer">
                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">No</a>
                    <form action="server.php" method="POST">
                        <input type="hidden" name="project_name" value='<?php echo $row[1]; ?>'>
                        <button type="submit" name="close_project" class="modal-action modal-close waves-effect waves-green btn-flat">Yes</button>
                    </form>
                </div>
            </div>
            <?php
                        }
            ?>

            <div id="closed" class="col s12">
                <div class="row">
                    <?php 
                        $result = mysqli_query($conn, "SELECT * FROM projects WHERE projects_status = 'closed';");
                        $num_rows = mysqli_num_rows($result);
                        while($row = mysqli_fetch_array($result)) {
                            ?>
                    <div class="col s12 m6">
                        <div class="card blue-grey darken-1 center">
                            <div class="card-content white-text">
                                <span class="card-title">
                                    <?php echo $row[1] ?> </span>
                                <p>
                                    <?php echo $row[2] ?>
                                </p>
                                <p>Start Date:
                                    <?php echo $row[3] ?>
                                </p>
                                <p>End Date:
                                    <?php echo $row[4] ?>
                                </p>
                                <div class="row">
                                    <a href="#reopenModal" class="waves-effect waves-light btn green modal-trigger">Re-open Project</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="reopenModal" class="modal">
        <div class="modal-content">
            <h4>Re-open Project?</h4>
            <p>Are you sure you want to re-open this project?</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">No</a>
            <form action="server.php" method="POST">
                <input type="hidden" name="project_name" value='<?php echo $row[1]; ?>'>
                <button type="submit" name="reopen_project" class=" modal-action modal-close waves-effect waves-green btn-flat">Yes</button>
            </form>
        </div>
    </div>

    <div id="addProjectModal" class="modal">
        <div class="modal-content">
            <h4>Add Project</h4>
            <form action="server.php" method="POST">
                <div class="row">
                    <div class="input-field col s6">
                        <input placeholder="New project name" id="new_project_name" type="text" class="validate">
                        <label class="active" for="new_project_name">Project Name:</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="New address" id="new_address" type="text" class="validate">
                        <label for="new_address">Address:</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="New start date" id="new_sdate" type="text" class="validate">
                        <label for="new_sdate">Start date:</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="New end date" id="new_edate" type="text" class="validate">
                        <label for="new_edate">End date:</label>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button class=" modal-action modal-close waves-effect waves-green btn-flat">Save Changes</button>
        </div>
        </form>
    </div>

    <div id="deleteProjectModal" class="modal">
        <div class="modal-content">
            <h4>Delete Project?</h4>
            <p>Are you sure you want to delete this project? </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">No</a>
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Yes</a>
        </div>
    </div>
    <?php
                        }
    ?>

    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Modal Header</h4>
            <p>A bunch of text</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
        </div>
    </div>


    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js"></script>
    <script>
        $(document).ready(function() {
            $('.modal-trigger').leanModal();
        });

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

    </script>
</body>

</html>

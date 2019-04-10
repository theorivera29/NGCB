<?php 
    include "../db_connection.php";
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
            <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large pulse"><i class="material-icons">menu</i></a>
            <h4 id="NGCB">NEW GOLDEN CITY BUILDERS</h4>
            <ul class="side-nav" id="mobile-demo">
                <li class="collection-item avatar">
                    <span class="title">
                    </span>
                    <span class="title">
                    </span>
                </li>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="admindashboard.php">Dashboard</a></li>
                <li>
                    <div class="divider"></div>
                </li>

                <ul class="collapsible">
                    <li>
                        <a class="collapsible-header waves-effect waves-blue">Accounts<i class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a class="waves-effect waves-blue" href="accountcreation.php">Create Account</a>
                                </li>
                                <li>
                                    <a class="waves-effect waves-blue" href="listofaccounts.php">List of Accounts</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="projects.php">Projects</a></li>

                <li>
                <li>
                    <div class="divider"></div>
                </li>



                <li><a href="passwordrequest.php">Password Request</a></li>
                <li>
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
        <div class="row">

            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a href="#ongoing">Ongoing</a></li>
                    <li class="tab col s3"><a href="#closed">Closed</a></li>
                </ul>
            </div>
        </div>

        <!--ONGOING TAB-->
        <div id="ongoing" class="col s12">
                   <div class="col s11 right-align">
            <a href="#addProject" class="waves-effect waves-light btn button modal-trigger add-material-btn">
                <i class="material-icons left">add_circle_outline</i>Add Project</a>
        </div>
            <div class="row">
                <?php
                    $sql = "SELECT projects_name, projects_address, projects_sdate, projects_edate FROM projects
                    WHERE projects_status = 'open';";
                    $result = mysqli_query($conn, $sql);
                    $ctr = 0;
                    while($row = mysqli_fetch_row($result)) {
                ?>
                <div class="col s12 m6">
                    <div class="card blue-grey darken-1 center">
                        <div class="card-content white-text">
                            <span class="card-title">
                                <?php echo $row[0] ?></span>
                            <p>
                                <?php echo $row[1] ?>
                            </p>
                            <p>
                                <span>
                                    start date
                                </span>
                                <?php echo $row[2] ?>
                            </p>
                            <p>
                                <span>
                                    end date
                                </span>
                                <?php echo $row[3] ?>
                            </p>
                            <div class="row">
                                <div class="row">
                                    <button href="#editModal<?php echo $ctr; ?>" class="waves-effect waves-light btn edit-btn modal-trigger">Edit</button>
                                </div>
                            </div>
                            <!--
                                <div class="row">
                                    <form action="../server.php" method="POST">
                                        <input type="hidden" name="projects_name" value="<?php echo $row[0] ?>">
                                        <div class="row">
                                            <button class="waves-effect waves-light btn viewinventory-btn" type="submit"
                                                name="view_inventory">View Inventory</button>
                                        </div>
                                    </form>
                                </div>
-->
                            <?php 
                                if (strtotime($row[2]) > strtotime ($row[3])) {
                            ?>
                            <div class="row">
                                <a href="#closeModal" class="waves-effect waves-light btn red modal-trigger">Close
                                    Project</a>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <div id="closeModal<?php echo $ctr; ?>" class="modal modal-fixed-footer">
                    <div class="modal-content">
                        <h4>Close Project?</h4>
                        <p>Are you sure you want to close this project?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">No</a>
                        <form action="../server.php" method="POST">
                            <input type="hidden" name="project_name" value='<?php echo $row[0] ?>'>
                            <button type="submit" name="close_project" class="modal-action modal-close waves-effect waves-green btn-flat">Yes</button>
                        </form>
                    </div>
                </div>

                <!--EDIT MODAL-->
                <div id="editModal<?php echo $ctr; ?>" class="modal modal-fixed-footer">
                    <div class="modal-content">
                        <h4>Edit Project:</h4>
                        <form action="../server.php" method="POST">
                            <div class="row">
                                <input type="hidden" name="project_name" value="<?php echo $row[0] ?>">
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
                                <div class="modal-footer">
                                    <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
                                    <button name="edit_project" class="modal-action modal-close waves-effect waves-green btn-flat">Save
                                        Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php 
                    $ctr++;
                    }
                ?>
            </div>
        </div>
    </div>

    <!--CLOSE MODAL-->
    <div id="closeModal" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Close Project?</h4>
            <p>Are you sure you want to close this project?</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">No</a>
            <form action="server.php" method="POST">
                <input type="hidden" name="project_name">
                <button type="submit" name="close_project" class="modal-action modal-close waves-effect waves-green btn-flat">Yes</button>
            </form>
        </div>
    </div>


    <!--CLOSE TAB-->
    <div id="closed" class="col s12">
        <div class="row">
            <?php
                        $sql = "SELECT projects_name, projects_address, projects_sdate, projects_edate FROM projects
                        WHERE projects_status = 'closed';";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)){
                    ?>
            <div class="col s12 m6">
                <div class="card blue-grey darken-1 center">
                    <div class="card-content white-text">
                        <span class="card-title">
                            <?php echo $row[0] ?></span>
                        <p>
                            <?php echo $row[1] ?>
                        </p>
                        <p>
                            <span>
                                start date
                            </span>
                            <?php echo $row[2] ?>
                        </p>
                        <p>
                            <span>
                                end date
                            </span>
                            <?php echo $row[3] ?>
                        </p>
                        <div class="row">
                            <a href="#reopenModal" class="waves-effect waves-light btn red modal-trigger">Re-open project</a>
                        </div>
                        <!--
                                <div class="row">
                                    <form action="../server.php" method="POST">
                                        <input type="hidden" name="projects_name" value="<?php echo $row[0] ?>">
                                        <div class="row">
                                            <button class="waves-effect waves-light btn viewinventory-btn" type="submit"
                                                name="view_inventory">View Inventory</button>
                                        </div>
                                    </form>
                                </div>
-->
                        <?php 
                            if (strtotime($row[2]) > strtotime ($row[3])) {
                        ?>
                        <div class="row">
                            <a href="#reopenModal" class="waves-effect waves-light btn red modal-trigger">Reopen
                                Project</a>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div id="reopenModal" class="modal modal-fixed-footer">
                <div class="modal-content">
                    <h4>Reopen Project?</h4>
                    <p>Are you sure you want to reopen this project?</p>
                </div>
                <div class="modal-footer">
                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">No</a>
                    <form action="../server.php" method="POST">
                        <input type="hidden" name="project_name" value='<?php echo $row[0] ?>'>
                        <button type="submit" name="reopen_project" class="modal-action modal-close waves-effect waves-green btn-flat">Yes</button>
                    </form>
                </div>
            </div>

            <?php 
                }
            ?>
        </div>
    </div>

    <div id="addProject" class="modal modal-fixed-footer">
        <form action="../server.php" method="POST">
            <div class="modal-content">
                <h4>Add Project</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="projectname" name="projectname" type="text" class="validate">
                        <label for="projectname">Project Name:</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="projectaddress" name="projectaddress" type="text" class="validate">
                        <label for="projectaddress">Project Address</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="startdate" name="startdate" type="text" class="validate">
                        <label for="startdate">Start date:</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="enddate" name="enddate" type="text" class="validate">
                        <label for="enddate">End date:</label>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s12">
                            <span>Material Engineers Involved</span>
                            <select id="involved" class="browser-default" name="involved">
                                <option disabled selected>Choose your option</option>
                                <?php
                                    $sql = "SELECT accounts_id, accounts_fname, accounts_lname FROM accounts WHERE accounts_type = 'MatEng';";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_row($result)) {                         
                                ?>
                                <option value="<?php echo $row[0]; ?>">
                                    <?php echo $row[2]." ".$row[1]; ?>
                                </option>
                                <?php 
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="waves-effect waves-teal save-btn" name="create_project">SAVE</button>
                </div>
            </div>
        </form>
    </div>

    <div id="deleteProjectModal" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Delete Project?</h4>
            <p>Are you sure you want to delete this project? </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">No</a>
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Yes</a>
        </div>
    </div>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
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

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
            <a href="#" data-activates="navigation" class="button-collapse show-on-large menu-icon"><i
                    class="material-icons menuIcon">menu</i></a>
            <span id="NGCB">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</span>

            <ul>

                <li class="down-arrow">

                    <a class="dropdown-button" href="#!" data-activates="dropdown" data-beloworigin="true"><i
                            class="material-icons dropdown-button">keyboard_arrow_down</i></a>
                </li>

            </ul>
            <ul id="dropdown" class="dropdown-content collection">
                <li><a class="waves-effect waves-blue" href="account.php">Account</a></li>
                <li><a class="waves-effect waves-blue" href="logout.php">Logout</a></li>

            </ul>
            </span>
            <ul class="side-nav" id="navigation">
                <li class="icon-container">
                    <img src="../Images/NGCB_logo.png" class="sidenav-logo">
                </li>
                <h3 id="account-type">


                </h3>

                <li>
                    <i class="material-icons left">dashboard</i><a class="waves-effect waves-blue"
                        href="admindashboard.php">Dashboard</a>
                </li>


                <ul class="collapsible">
                    <li>
                        <i class="material-icons left">supervisor_account</i><a
                            class="collapsible-header waves-effect waves-blue">Accounts<i
                                class="material-icons right">keyboard_arrow_down</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a class="waves-effect waves-blue" href="accountcreation.php">Create Account</a>
                                </li>
                                <li><a class="waves-effect waves-blue" href="listofaccounts.php">List of Accounts</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <li>
                    <i class="material-icons left">insert_drive_file</i><a class="waves-effect waves-blue"
                        href="projects.php">Projects</a>
                </li>
                <li>
                    <i class="material-icons left">folder</i><a class="waves-effect waves-blue"
                        href="report.php">Logs</a>
                </li>
                <li>
                    <i class="material-icons left">receipt</i><a class="waves-effect waves-blue"
                        href="report.php">Report</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="row">
        <div class="col project-status">
            <ul class="tabs tabs-project">
                <li class="col s3 tab"><a href="#ongoing">Ongoing</a></li>
                <li class="col s3 tab"><a href="#closed">Closed</a></li>
            </ul>
        </div>

        <!--ONGOING TAB-->
        <div id="ongoing" class="col s12">
            <div class="row">
                <div class="col s11 right-align">
                    <a href="#addProject" class="waves-effect waves-light btn button modal-trigger add-material-btn">
                        <i class="material-icons left">add_circle_outline</i>Add Project</a>
                </div>
                <div class="col s12 m5 project-container">
                    <div class="card center project-container-card">
                        <div class="card-content">
                            <span class="card-title">

                            </span>
                            <p>
                                End Date:
                            </p>
                            <p>

                                Start Date:

                            </p>

                            <div class="row">
                                <form action="../server.php" method="POST">
                                    <input type="hidden" name="projects_name" value="">
                                    <input type="hidden" name="account_type" value="">
                                    <div class="row">
                                        <button href="#editModal"
                                            class="waves-effect waves-light btn edit-btn modal-trigger">Edit</button>
                                    </div>
                                    <div class="row">
                                        <a href="#closeModal"
                                            class="waves-effect waves-light btn red modal-trigger">Close
                                            Project</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--CLOSE MODAL-->
                <div id="closeModal" class="modal">
                    <div class="modal-content">
                        <h4>Close Project?</h4>
                        <p>Are you sure you want to close this project?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">No</a>
                        <form action="../server.php" method="POST">
                            <input type="hidden" name="project_name" value="">
                            <button type="submit" name="close_project"
                                class="modal-action modal-close waves-effect waves-green btn-flat">Yes</button>
                        </form>
                    </div>
                </div>

                <!--EDIT MODAL-->
                <div id="editModal" class="modal modal-fixed-footer">
                    <div class="modal-content">
                        <h4>Edit Project:</h4>
                        <form action="../server.php" method="POST">
                            <div class="row">
                                <input type="hidden" name="project_name" value="">
                                <div class="input-field col s6">
                                    <input placeholder="New project name" id="new_project_name" type="text"
                                        class="validate" name="new_project_name">
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
                                    <input placeholder="New end date" id="new_edate" type="text" class="validate"
                                        name="new_edate">
                                    <label for="new_edate">End date:</label>
                                </div>
                                <div class="modal-footer">
                                    <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
                                    <button name="edit_project"
                                        class="modal-action modal-close waves-effect waves-green btn-flat">Save
                                        Changes</button>
                                </div>
                            </div>
                        </form>
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

                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="waves-effect waves-teal save-btn"
                                        name="create_project">SAVE</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>

        <!--CLOSED-->
        <div id="closed" class="col s12">
            <div class="row">

                <div class="col s12 m5 project-container">
                    <div class="card center project-container-card">
                        <div class="card-content">
                            <span class="card-title">
                            </span>
                            <p>
                                End Date:
                            </p>
                            <p>

                                Start Date:
                                </span>
                            </p>
                            <p>

                            </p>
                            <div class="row">
                                <form action="../server.php" method="POST">
                                    <input type="hidden" name="projects_name" value="">
                                    <input type="hidden" name="account_type" value="">
                                    <div class="row">
                                        <a href="#reopenModal"
                                            class="waves-effect waves-light btn red modal-trigger">Re-open
                                            project</a>
                                    </div>
                                    <div class="row">
                                        <a href="#deleteProjectModal"
                                            class="waves-effect waves-light btn red modal-trigger">Delete
                                        </a>

                                    </div>
                                </form>
                            </div>
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
                            <button type="submit" name="reopen_project"
                                class="modal-action modal-close waves-effect waves-green btn-flat">Yes</button>
                        </form>
                    </div>
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


            </div>
        </div>


    </div>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script>
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
        });
    </script>

</body>

</html>
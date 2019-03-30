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
        <nav>
            <div class="nav-wrapper">
                <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large"><i
                        class="material-icons">menu</i></a>
                <span id="NGCB">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</span>

                <ul class="side-nav" id="mobile-demo">
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
                                    <li><a class="waves-effect waves-blue" href="sitematerials.php">Site Materials</a>
                                    </li>
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



        <div class="container">
            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s3"><a href="#ongoing">Ongoing</a></li>
                        <li class="tab col s3"><a href="#closed">Closed</a></li>
                    </ul>
                </div>
                <!--ONGOING TAB-->
                <div id="ongoing" class="col s12">
                    <div class="row">

                        <div class="col s12 m6">
                            <div class="card blue-grey darken-1 center">
                                <div class="card-content white-text">
                                    <span class="card-title"></span>
                                    <p>NGCB SAMPLE PROJECT
                                        <p>start date</p>
                                        <p>end date</p>
                                        <div class="row">
                                            <form action="server.php" method="POST">
                                                <input type="hidden" name="projects_name" value="">
                                                <div class="row">
                                                    <button class="waves-effect waves-light btn viewinventory-btn"
                                                        type="submit" name="view_inventory">View Inventory</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="row">
                                            <a href="#closeModal"
                                                class="waves-effect waves-light btn red modal-trigger">Close
                                                Project</a>
                                        </div>

                                </div>
                            </div>
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
                            <input type="hidden" name="project_name" value=''>
                            <button type="submit" name="close_project"
                                class="modal-action modal-close waves-effect waves-green btn-flat">Yes</button>
                        </form>
                    </div>
                </div>


                <!--CLOSE TAB-->
                <div id="closed" class="col s12">
                    <div class="row">
                        <div class="col s12 m6">
                            <div class="card blue-grey darken-1 center">
                                <div class="card-content white-text">
                                    <span class="card-title">
                                    </span>
                                    <p>

                                    </p>
                                    <p>Start Date:

                                    </p>
                                    <p>End Date:
                                    </p>
                                    <div class="row">
                                        <a href="#reopenModal"
                                            class="waves-effect waves-light btn reopen-btn modal-trigger">Re-open
                                            Project</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div id="reopenModal" class="modal modal-fixed-footer">
                    <div class="modal-content">
                        <h4>Re-open Project?</h4>
                        <p>Are you sure you want to re-open this project?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">No</a>
                        <form action="server.php" method="POST">
                            <input type="hidden" name="project_name" value=''>
                            <button type="submit" name="reopen_project"
                                class=" modal-action modal-close waves-effect waves-green btn-flat">Yes</button>
                        </form>
                    </div>
                </div>

                <div id="addProjectModal" class="modal modal-fixed-footer">
                    <div class="modal-content ">
                        <h4>Add Project</h4>
                        <form action="server.php" method="POST">
                            <div class="row">
                                <div class="input-field col s6">
                                    <input placeholder="New project name" id="new_project_name" type="text"
                                        class="validate" name="project_name">
                                    <label class="active" for="new_project_name">Project Name:</label>
                                </div>
                                <div class="input-field col s6">
                                    <input placeholder="New address" id="new_address" type="text" class="validate"
                                        name="project_address">
                                    <label for="new_address">Address:</label>
                                </div>
                                <div class="input-field col s6">
                                    <input placeholder="New start date" id="new_sdate" type="date" class="validate"
                                        name="start_date">
                                    <label for="new_sdate">Start date:</label>
                                </div>
                                <div class="input-field col s6">
                                    <input placeholder="New end date" id="new_edate" type="date" class="validate"
                                        name="end_date">
                                    <label for="new_edate">End date:</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class=" modal-action modal-close waves-effect waves-green btn-flat" type="submit"
                            name="create_project">Save Changes</button>
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


                <!--Import jQuery before materialize.js-->
                <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
                <script type="text/javascript"
                    src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
                </script>
                <script>
                    $(document).ready(function () {
                        $('.modal-trigger').leanModal();
                    });

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
                    });
                </script>
</body>

</html>
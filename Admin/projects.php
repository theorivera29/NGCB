<?php
    include "../db_connection.php";
    session_start();
    if(!isset($_SESSION['loggedin'])) {
        header('Location: http://127.0.0.1/NGCB/index.php');
    }

    $accounts_id = "";
    if(!isset($_SESSION['loggedin'])) {
        header('Location: http://127.0.0.1/NGCB/index.php');
    }
?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../materialize/css/materialize.css">
    <link rel="stylesheet" text="type/css" href="../style.css">
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="navigation" class="button-collapse show-on-large menu-icon"><i class="material-icons menuIcon">menu</i></a>
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

                        <a class="dropdown-button" href="#!" data-activates="dropdown" data-beloworigin="true"><i class="material-icons dropdown-button">keyboard_arrow_down</i></a>
                    </li>

                </ul>
                <ul id="dropdown" class="dropdown-content collection">
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
                    <i class="material-icons left">dashboard</i><a class="waves-effect waves-blue" href="admindashboard.php">Dashboard</a>
                </li>


                <ul class="collapsible">
                    <li>
                        <i class="material-icons left">supervisor_account</i><a class="collapsible-header waves-effect waves-blue">Accounts<i class="material-icons right">keyboard_arrow_down</i></a>
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
                    <i class="material-icons left">vpn_key</i><a class="waves-effect waves-blue" href="passwordrequest.php">Password Request</a>
                </li>
                <li>
                    <i class="material-icons left">insert_drive_file</i><a class="waves-effect waves-blue" href="projects.php">Projects</a>
                </li>
                <li>
                    <i class="material-icons left">folder</i><a class="waves-effect waves-blue" href="logs.php">Logs</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="row">

        <div id="addProject" class="modal modal-fixed-footer">
            <form action="../server.php" method="POST">
                <div class="modal-content">
                    <h4>Add Project</h4>
                    <div class="row add-proj">
                        <div class="input-field col s12">
                            <input id="projectname" name="projectname" type="text" class="validate">
                            <label for="projectname">Project Name:</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="projectaddress" name="projectaddress" type="text" class="validate">
                            <label for="projectaddress">Project Address</label>
                        </div>
                        <div class="input-field col s12 m5">
                            <span>Start date:</span>
                            <input id="startdate" name="startdate" type="date">
                        </div>
                        <div class="input-field col s12 m6 offset-m1">
                            <span>End date:</span>
                            <input id="enddate" name="enddate" type="date">
                        </div>
                        <div class="col s12"> 
                        <select class="browser-default" name="mateng">
                            <option>Materials engineer involved</option>
                            <?php
                                $sqlmateng = "SELECT accounts_username, accounts_id FROM accounts WHERE accounts_type = 'MatEng';";
                                $resultmateng = mysqli_query($conn, $sqlmateng);
                            while($rowmateng = mysqli_fetch_row($resultmateng)){
                            ?>
                            <option value="<?php echo $rowmateng[1]; ?>">
                                <?php echo $rowmateng[0]; ?>
                            </option>

                            <?php 
                                }
                            ?>
                        </select>                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="modal-close waves-effect waves-light btn btn-flat no-btn">Cancel</a>
                    <button type="submit" class="waves-effect waves-light btn save-proj-btn" name="create_project">Save</button>
                </div>
            </form>
        </div>
        <div class="col project-status">
            <ul class="tabs tabs-project">
                <li class="col s3 tab"><a href="#ongoing">Ongoing</a></li>
                <li class="col s3 tab"><a href="#closed">Closed</a></li>
            </ul>
        </div>


        <!--ONGOING TAB-->
        <div id="ongoing" class="col s12">
            <div class="col s11 right-align">
                <a href="#addProject" class="waves-effect waves-light btn button modal-trigger add-project-btn">Add
                    Project</a>
            </div>
            <div class="row">
                <?php
                    $sql = "SELECT * FROM projects WHERE projects_status = 'open';";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_row($result)) {
                ?>
                <div class="col s12 m5 project-container">
                    <div class="card center project-container-card">
                        <div class="card-content">
                            <span class="card-title">
                                <?php echo $row[1] ;?>
                            </span>
                            <p>
                                <span class="card-text">
                                    <?php echo $row[2] ;?>
                                </span>
                            </p>
                            <p>
                                <span class="card-text">
                                    Start Date:
                                </span>
                                <?php echo $row[3] ;?>

                            </p>
                            <p>
                                <span class="card-text">
                                    End Date:
                                </span>
                                <?php echo $row[4] ;?>

                            </p>
                            <div class="row">
                                <div class="row">
                                    <button href="#editModal<?php echo $row[0] ;?>" class="waves-effect waves-light btn modal-trigger edit-proj-btn">Edit</button>
                                </div>
                                <div class="row">
                                    <a href="#closeModal<?php echo $row[0] ;?>" class="waves-effect waves-light btn modal-trigger close-proj-btn">Close
                                        Project</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--CLOSE MODAL-->
                <div id="closeModal<?php echo $row[0] ;?>" class="modal">
                    <div class="modal-content">
                        <h4>Close Project</h4>
                        <p>Are you sure you want to close this project?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class=" modal-action modal-close waves-effect waves-light btn-flat no-btn">No</a>
                        <form action="../server.php" method="POST">
                            <input type="hidden" name="project_name" value="<?php echo $row[1] ;?>">
                            <button type="submit" name="close_project" class="modal-action modal-close waves-effect waves-light btn-flat yes-btn">Yes</button>
                        </form>
                    </div>
                </div>

                <!--EDIT MODAL-->
                <div id="editModal<?php echo $row[0] ;?>" class="modal modal-fixed-footer">
                    <form action="../server.php" method="POST">
                        <div class="modal-content">
                            <h4>Edit Project</h4>
                            <div class="row add-proj">
                                <input type="hidden" name="project_name" value="<?php echo $row[1];?>">
                                <div class="input-field col s12">
                                    <span>Project Name:</span>
                                    <input id="newprojectname" type="text" placeholder="New Project Name" name="new_project_name">
                                </div>
                                <div class="input-field col s12">
                                    <span>Project Address:</span>
                                    <input id="newprojectaddress" type="text" placeholder="New Project Address" name="new_address">
                                </div>
                                <div class="input-field col s12 m5">
                                    <span>Start date:</span>
                                    <input id="newstartdate" type="date" placeholder="New start date" name="new_sdate">
                                </div>
                                <div class="input-field col s12 m6 offset-m1">
                                    <span>End date:</span>
                                    <input id="newenddate" type="date" placeholder="New start date" name="new_edate">
                                </div>
                                <div class="col s12">
                                    <div class="input-field col s12">
                                        <span>Materials Engineer Involved</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="" class="modal-close waves-effect waves-light btn btn-flat no-btn" name="cancel-create-project">Cancel</a>
                            <button type="submit" class="waves-effect waves-light btn save-proj-btn" name="edit_project">Save</button>
                        </div>
                    </form>
                </div>
                <?php 
                    }
                ?>
            </div>
        </div>

        <!--CLOSED-->
        <div id="closed" class="col s12">
            <div class="row">
                <?php
                    $sql = "SELECT * FROM projects WHERE projects_status = 'closed';";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_row($result)) {
                ?>
                <div class="col s12 m5 project-container">
                    <div class="card center project-container-card">
                        <div class="card-content">
                            <span class="card-title">
                                <?php echo $row[1] ;?>
                            </span>
                            <p>
                                <span class="card-text">
                                    <?php echo $row[2] ;?>
                                </span>
                            </p>
                            <p>
                                <span class="card-text">
                                    Start Date:
                                </span>
                                <?php echo $row[3] ;?>
                            </p>
                            <p>
                                <span class="card-text">
                                    End Date:
                                </span>
                                <?php echo $row[4] ;?>
                            </p>
                            <div class="row">
                                <div class="row">
                                    <a href="#reopenModal<?php echo $row[0] ;?>" class="waves-effect waves-light btn modal-trigger reopen-btn">Re-open
                                        project</a>
                                </div>
                                <div class="row">
                                    <a href="#deleteProjectModal<?php echo $row[0] ;?>" class="waves-effect waves-light btn modal-trigger delete-btn ">Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="reopenModal<?php echo $row[0] ;?>" class="modal">
                    <div class="modal-content">
                        <h4>Reopen Project</h4>
                        <p>Are you sure you want to reopen this project?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class=" modal-action modal-close waves-effect waves-light btn-flat no-btn">No</a>
                        <form action="../server.php" method="POST">
                            <input type="hidden" name="project_name" value='<?php echo $row[1] ;?>'>
                            <button type="submit" name="reopen_project" class="modal-action modal-close waves-effect waves-light btn-flat yes-btn">Yes</button>
                        </form>
                    </div>
                </div>

                <div id="deleteProjectModal<?php echo $row[0] ;?>" class="modal">
                    <div class="modal-content">
                        <h4>Delete Project?</h4>
                        <p>Are you sure you want to delete this project? </p>
                    </div>
                    <div class="modal-footer">
                        <form action="../server.php" method="POST">
                            <input type="hidden" name="project_name" value='<?php echo $row[1] ;?>'>
                            <a href="#!" class="modal-close waves-effect waves-light btn btn-flat no-btn">No</a>
                            <button class="modal-action modal-close waves-effect waves-light btn-flat yes-btn" type="submit" name="delete_project">Yes</button>
                        </form>
                    </div>
                </div>
                <?php 
                    }
                ?>
            </div>
        </div>
    </div>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.button-collapse').sideNav({
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
            });
            $('.collapsible').collapsible();
            $('.modal-trigger').leanModal();
        });
        
          $(document).ready(function() {
      $('input[type=checkbox]').each(function() {
        if(this.nextSibling.nodeName != 'label') {
          $(this).after('<label for="'+this.id+'"></label>')
        }
      })
    })

    </script>

</body>

</html>

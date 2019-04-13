<?php
    include "../db_connection.php";
    session_start();

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
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
                            $stmt = $mysqli->prepare("SELECT * FROM accounts WHERE accounts_username = '$username'");
                            if (!$stmt->execute()) {
                                 echo "Error while executing query: (" . $stmt->errno . ") " . $stmt->error;
                            }
                            else {
                                if (!($rows = $stmt->get_result())) {
                                    echo "Error while retrieving results: (" . $stmt->errno . ") " . $stmt->error;
                                }
                            }
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
                <?php
                        $stmt = $mysqli->prepare(ELECT projects_name, projects_address, projects_sdate, projects_edate FROM projects
                        WHERE projects_mateng =  (SELECT accounts_id FROM accounts WHERE accounts_username = '$username')
                        && projects_status = 'open';");
                            if (!$stmt->execute()) {
                                 echo "Error while executing query: (" . $stmt->errno . ") " . $stmt->error;
                            }
                            else {
                                if (!($rows = $stmt->get_result())) {
                                    echo "Error while retrieving results: (" . $stmt->errno . ") " . $stmt->error;
                                }
                            }
                
                        foreach($row as $rows){
                    ?>
                <div class="col s12 m5 project-container">
                    <div class="card center project-container-card">
                        <div class="card-content">
                            <span class="card-title">
                                <?php echo $row[0] ?>
                            </span>
                            <p>
                                <?php echo $row[1] ?>
                            </p>
                            <p>
                                <span class="card-text">
                                    Start Date:
                                </span>
                                <?php echo $row[2] ?>
                            </p>
                            <p>
                                <span class="card-text">
                                    End Date:
                                </span><?php echo $row[3] ?>
                            </p>
                            <div class="row">
                                <form action="../server.php" method="POST">
                                    <input type="hidden" name="projects_name" value="<?php echo $row[0] ?>">
                                    <input type="hidden" name="account_type"
                                        value="<?php echo $_SESSION['account_type']; ?>">
                                    <div class="row">
                                        <button class="waves-effect waves-light btn viewinventory-btn" type="submit"
                                            name="view_inventory">View Inventory</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                        }
                    ?>
            </div>
        </div>

        <div id="closed" class="col s12">
            <div class="row">
                <?php
                        $sql = "SELECT projects_name, projects_address, projects_sdate, projects_edate FROM projects
                        WHERE projects_mateng =  (SELECT accounts_id FROM accounts WHERE accounts_username = '$username')
                        && projects_status = 'closed';";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)){
                    ?>
                <div class="col s12 m5 project-container">
                    <div class="card center project-container-card">
                        <div class="card-content">
                            <span class="card-title">
                                <?php echo $row[0] ?></span>
                            <p>
                                <?php echo $row[1] ?>
                            </p>
                            <p>
                                <span class="card-text">
                                    Start Date:
                                </span>
                                <?php echo $row[2] ?>
                            </p>
                            <p>
                                <span class="card-text">
                                    End Date:
                                </span><?php echo $row[3] ?>
                            </p>
                            <div class="row">
                                <form action="../server.php" method="POST">
                                    <input type="hidden" name="projects_name" value="<?php echo $row[0] ?>">
                                    <input type="hidden" name="account_type"
                                        value="<?php echo $_SESSION['account_type']; ?>">
                                    <div class="row">
                                        <button class="waves-effect waves-light btn viewinventory-btn" type="submit"
                                            name="view_inventory">View Inventory</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                        }
                    ?>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script>
        $(document).ready(function () {
            $('.modal-trigger').leanModal();
        });

        $(document).ready(function () {
            $('.button-collapse').sideNav({
                menuWidth: 300,
                edge: 'left',
                closeOnClick: false,
                draggable: true
            });
            $('.button-collapse').sideNav('show');
        });
    </script>
</body>

</html>

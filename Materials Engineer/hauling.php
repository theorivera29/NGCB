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
    <link rel="stylesheet" text="type/css" href="../materialize/css/materialize.css">
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
    <?php
        $row = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT projects.projects_name, projects.projects_address, projects.projects_sdate, projects.projects_edate, projects.projects_id, projacc.projacc_mateng  FROM projects
                        INNER JOIN projacc WHERE projects_status = 'open' AND projacc.projacc_mateng = '2';"));
        if($row == 0) {
            echo "You don't have any project.";
        } else {
    ?>


    <div class="container hauling-projects">
        <div class="row">
            <div id="ongoing" class="col s12">
                <div class="row">
                    <?php

                            $sql = "SELECT DISTINCT projects.projects_name, projects.projects_address, projects.projects_sdate, projects.projects_edate, projects.projects_id, projacc.projacc_mateng  FROM projects
                        INNER JOIN projacc WHERE projects_status = 'open' AND projacc.projacc_mateng = '2';";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)){
                        ?>
                    <div class="col s12 m6">
                        <div class="card hauling-project-card">
                            <div class="card-content hauling-project-card-content">
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
                                    <?php echo $row[2] ?></p>
                                <p>
                                    <span class="card-text">
                                        End Date:
                                    </span><?php echo $row[3] ?></p>
                                <div class="row">
                                    <form action="../server.php" method="POST">
                                        <input type="hidden" name="projects_name" value="<?php echo $row[0] ?>">
                                        <div class="row">
                                            <button class="waves-effect waves-light btn viewinventory-btn" type="submit"
                                                name="fillout_hauling">Open</button>
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
    </div>
    <?php  
        }
    ?>  
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
    <script>
       $(document).ready(function () {
            $('.button-collapse').sideNav({
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
            });
            $('.collapsible').collapsible();
            $('.modal-trigger').leanModal();
        });
    </script>
</body>

</html>
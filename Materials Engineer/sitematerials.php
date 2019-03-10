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
            <h4 id="NGCB">New Golden City Builders</h4>
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
                <li>Dashboard</li>
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
                                <li><a class="waves-effect waves-blue" href="#">Fill out Hauling Form</a></li>
                                <li><a class="waves-effect waves-blue" href="#">View Hauled Materials</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <li>
                    <div class="divider"></div>
                </li>
                <li>Report</li>
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
        <table>
            <thead>
                <tr>
                    <th>Particulars</th>
                    <th id="merge-two-cell">Previous Material Stock</th>
                    <th>Delivered Material as of
                        <?php echo date("M. Y"); ?>
                        <!--DATE MONTH AND YEAR ONLY BACKEND-->
                    </th>
                    <th id="merge-two-cell">Material pulled out as of
                        <?php echo date("M. Y"); ?>
                        <!--DATE MONTH AND YEAR ONLY BACKEND-->
                    </th>
                    <th>Accumulated Materials Delivered</th>
                    <th id="merge-two-cell">Material on site as of
                        <?php echo date("M. Y"); ?>
                        <!--DATE MONTH AND YEAR ONLY BACKEND-->
                    </th>
                    <th>Project</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                    $sql_categ = "SELECT DISTINCT mat_categ FROM materials;";
                    $result = mysqli_query($conn, $sql_categ);
                    $categories = array();
                    while($row_categ = mysqli_fetch_assoc($result)){
                        $categories[] = $row_categ;
                    }

                    foreach($categories as $data) {
                    $categ = $data['mat_categ'];
                ?>
                <tr>
                    <td id="merge-ten-cell"> <b>
                            <?php echo $categ; ?></b></td>
                </tr>
                <?php 
                        $sql = "SELECT * FROM materials WHERE mat_categ = '$categ';";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)){
                    ?>
                <tr>
                    <td>
                        <form action="server.php" method="POST">
                            <input type="hidden" name="projects_name" value="<?php echo $row[1]?>">
                            <a class="waves-effect waves-light btn modal-trigger" href="#modal1">
                                <?php echo $row[1] ?></a>
                        </form>

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
                    <td>
                        <?php echo $row[6] ?>
                    </td>
                    <td>
                        <?php echo $row[7] ?>
                    </td>
                    <?php 
                        }
                    ?>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div id="modal1" class="modal">
        <div class="modal-content">
            <div class="content">
                <div class="row">
                    <div class="col s12 light-blue lighten-3">
                        <h4>DELIVER IN</h4>
                        <table class="centered blue-grey lighten-5">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Supplied By</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col s12 light-blue lighten-3">
                        <h4>USAGE IN</h4>
                        <table class="centered blue-grey lighten-5">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Pulled Out By</th>
                                    <th>Area of Usage</th>

                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">SAVE</a>
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">CANCEL</a>
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

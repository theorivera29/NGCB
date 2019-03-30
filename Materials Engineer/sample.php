<!DOCTYPE html>

<html>

<head>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
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
            <ul class="side-nav" id="mobile-demo">
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
                        <a class="collapsible-header waves-effect waves-blue">Site<i class="material-icons right">keyboard_arrow_down</i></a>
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
                        <a class="collapsible-header waves-effect waves-blue">Hauling<i class="material-icons right">keyboard_arrow_down</i></a>
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
                <li><a class="waves-effect waves-blue" href="report.php">Report</a></li>
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
        <div class="card">
            <table class="striped centered">
                <thead>
                    <tr>
                        <th>Hauling forms</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <td>asd</td>
                <td>asd</td>
                <td>adasd</td>
            </table>

            <?php
        $sql = "SELECT * FROM  categories;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)) {
    ?>
            <div class="row">
                <div class="col s3">
                    <div class="card blue-grey darken-1">
                        <!-- <a href=blade.html> -->
                        <div class="card-content white-text">
                            <span class="card-title">
                                <?php echo $row[1] ;?></span>
                        </div>
                        <div class="row">
                            <form action="server.php" method="POST">
                                <input type="hidden" name="categories_id" value="<?php echo $row[0]?>">
                                <button class="waves-effect waves-light btn" type="submit" name="view_category">View Inventory</button>
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


    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h4>Delete hauling form?</h4>
            <p>Are you sure you want to delete this form?</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">No</a>
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Yes</a>
        </div>
    </div>

    <div class="row">
                                            <a href="#editModal"
                                                class="waves-effect waves-light btn edit-btn modal-trigger">Edit</a>
                                        </div>
   <!--EDIT MODAL-->
    <div id="editModal" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Edit Project:
                <?php echo $row[1]; ?>
            </h4>
            <form action="server.php" method="POST">
                <div class="row">
                    <div class="input-field col s6">
                        <input placeholder="New project name" id="new_project_name" type="text" class="validate"
                            name="new_project_name">
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
                        <input placeholder="New end date" id="new_edate" type="text" class="validate" name="new_edate">
                        <label for="new_edate">End date:</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
            <input type="hidden" name="project_name" value='<?php echo $row[1]; ?>'>
            <button name="edit_project" class="modal-action modal-close waves-effect waves-green btn-flat">Save
                Changes</button>
        </div>
    </div>
    
    <script src="js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.modal-trigger').leanModal();
        });

    </script>
</body>

</html>

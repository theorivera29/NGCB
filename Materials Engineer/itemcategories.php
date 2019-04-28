<?php
    include "../db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
        header('Location: http://127.0.0.1/NGCB/index.php');
    }
    $projects_name = $_GET['projects_name'];
    $categories_id = $_GET['categories_id'];
    
    $sql = "SELECT projects_status FROM projects WHERE projects_name = '$projects_name'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $projects_status = $row[0];

    $sql = "SELECT projects_id FROM projects WHERE projects_name = '$projects_name'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $projects_id = $row[0];
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
                    <i class="material-icons left">dashboard</i><a class="waves-effect waves-blue" href="dashboard.php">Dashboard</a>
                </li>


                <ul class="collapsible">
                    <li>
                        <i class="material-icons left">place</i><a class="collapsible-header waves-effect waves-blue">Site<i class="material-icons right">keyboard_arrow_down</i></a>
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
                        <i class="material-icons left">local_shipping</i><a class="collapsible-header waves-effect waves-blue">Hauling<i class="material-icons right">keyboard_arrow_down</i></a>
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
                    <i class="material-icons left">receipt</i><a class="waves-effect waves-blue" href="report.php">Report</a>
                </li>
            </ul>
        </div>
    </nav>

    <?php 
        if(strcmp($projects_status, "open") == 0) {
    ?>

    <?php 
        }
    ?>

    <div class="item-categories">
        <div class="category-name-container">
            <?php
        $categories_id = $_GET['categories_id'];
        $sql = "SELECT * FROM  categories WHERE categories_id = '$categories_id';";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)) {
    ?>
            <h3 class="categ-name-title">
                <?php echo $row[1] ;?>
            </h3>
            <?php
        }
    ?>
        </div>
        <div class="row">
            <div class="col s6 m6">
                <input class="input search-bar mat-eng-search-bar" id="myInput" onkeyup="myFunction()" type="search" placeholder="Search...">
            </div>
            <div class="col s6 right-align">
                <a href="#addmaterialModal" class="waves-effect waves-light btn modal-trigger add-mat-btn add-mat-btn-viewinventory">
                    Add Material</a>

            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <table id="sort" class="centered striped category-items-table">
                    <thead class="item-categories-head">
                        <tr>
                            <th onClick="javascript:SortTable(0,'T');" id="particular-cell">Particulars</th>
                            <th onClick="javascript:SortTable(0,'N');">Previous Material Stock</th>
                            <th onClick="javascript:SortTable(0,'T');">Unit</th>
                            <th onClick="javascript:SortTable(0,'N');">Delivered Material as of
                                <?php echo date("F Y"); ?>
                            </th>
                            <th onClick="javascript:SortTable(0,'N');">Material Pulled out as of
                                <?php echo date("F Y"); ?>
                            </th>
                            <th onClick="javascript:SortTable(0,'T');">Unit</th>
                            <th onClick="javascript:SortTable(0,'N');">Accumulate of Materials Delivered</th>
                            <th onClick="javascript:SortTable(0,'N');">Material on Site as of
                                <?php echo date("F Y"); ?>
                            </th>
                            <th onClick="javascript:SortTable(0,'T');">Unit</th>
                            <?php 
                                if(strcmp($projects_status, "open") == 0) {
                            ?>
                            <?php
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $categories_id = $_GET['categories_id'];
                            $sql = "SELECT 
                        materials.mat_name, 
                        materials.mat_prevStock, 
                        projects.projects_name,
                        unit.unit_name
                        FROM materials 
                        INNER JOIN categories ON materials.mat_categ = categories.categories_id
                        INNER JOIN projects ON materials.mat_project = projects.projects_id 
                        INNER JOIN unit ON materials.mat_unit = unit.unit_id
                        WHERE mat_categ = '$categories_id';";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)){
                            $sql1 = "SELECT delivered_quantity FROM deliveredin
                            INNER JOIN materials ON deliveredin.delivered_matName = materials.mat_id
                            WHERE materials.mat_name = '$row[0]';";
                            $result1 = mysqli_query($conn, $sql1);
                            $row1 = mysqli_fetch_row($result1);
                            $sql2 = "SELECT usage_quantity FROM usagein
                            INNER JOIN materials ON usagein.usage_matName = materials.mat_id
                            WHERE materials.mat_name = '$row[0]';";
                            $result2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_row($result2);
                        ?>
                        <tr>
                            <td>
                                <form action="../server.php" method="POST">
                                    <input type="hidden" name="projects_name" value="<?php echo $projects_name; ?>">
                                    <input type="hidden" name="mat_name" value="<?php echo urlencode($row[0])?>">
                                    <button class="waves-effect waves-light btn matname-btn" name="open_stockcard">
                                        <?php echo $row[0] ?></button>
                                </form>
                            </td>
                            <td>
                                <?php echo $row[1] ?>
                            </td>
                            <td>
                                <?php echo $row[3] ?>
                            </td>
                            <td>
                                <?php 
                                    if($row1[0] == null ){
                                        echo 0;
                                    } else {
                                        echo $row1[0];
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($row2[0] == null ){
                                        echo 0;
                                    } else {
                                        echo $row2[0];
                                    }
                                ?>
                            </td>
                            <td>
                                <?php echo $row[3] ?>
                            </td>
                            <td>
                                <?php echo $row[1]+$row1[0] ?>
                            </td>
                            <td>
                                <?php echo ($row[1]+$row1[0])-$row2[0]  ?>
                            </td>
                            <td>
                                <?php echo $row[3] ?>
                            </td>
                            <?php 
                                if(strcmp($projects_status, "open") == 0) {
                            ?>
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
        </div>
    </div>



    <!-- ADD SITE MATERIAL MODAL -->
    <div id="addmaterialModal" class="modal modal-fixed-footer add-mat-modal">
        <form action="../server.php" method="POST">
            <input type="hidden" name="projects_name" value="<?php echo $projects_name; ?>">
            <div class="modal-content">
                <span id="modal-title">Add Material</span>
                <div class="row">
                    <div class="input-field col add-material-name">
                        <input name="projects_id" type="hidden" value="<?php echo $projects_id; ?>">
                        <input id="mat_name" name="mat_name" type="text" class="validate" required>
                        <label for="mat_name">Material Name:</label>
                    </div>
                    <div class="col s5">
                        <label>Category:</label>
                        <div class="input-field col s12">
                            <?php
                                $sql = "SELECT categories_name FROM categories WHERE categories_id = $categories_id";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_row($result);                       

                            ?>
                            <input type="hidden" name="mat_categ" value="<?php echo $categories_id ;?>">
                            <input id="mat_categ" type="text" class="validate" value="<?php echo $row[0]?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s5 material-add-unit">
                        <label>Unit:</label>
                        <select class="browser-default" name="mat_unit">
                            <option selected>Choose unit</option>
                            <?php
                                    $sql = "SELECT * FROM unit;";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_row($result)) {                         

                                ?>
                            <option value="<?php echo $row[0]; ?>">
                                <?php echo $row[1]; ?>
                            </option>
                            <?php 
                                    }
                                ?>
                        </select>
                    </div>
                    <div class="input-field col add-threshold">
                        <input id="mat_notif" name="mat_notif" type="text" class="validate view-inventory" pattern="[0-9]*" title="Input only numbers" required>
                        <label for="mat_notif">Item threshold:</label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-light btn-flat cancel-mat-btn">Cancel</a>
                <button type="submit" class="waves-effect waves-light btn-flat save-mat-btn" name="create_materials">Save</button>
            </div>
        </form>
    </div>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
    <script>
        // SIDEBAR
        $(document).ready(function() {
            $('.button-collapse').sideNav({
                closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
            });
            $('.collapsible').collapsible();
            $('.modal-trigger').leanModal();
        });

        var TableIDvalue = "sort";
        var TableLastSortedColumn = -1;

        function SortTable() {
            var sortColumn = parseInt(arguments[0]);
            var type = arguments.length > 1 ? arguments[1] : 'T';
            var dateformat = arguments.length > 2 ? arguments[2] : '';
            var table = document.getElementById(TableIDvalue);
            var tbody = table.getElementsByTagName("tbody")[0];
            var rows = tbody.getElementsByTagName("tr");
            var arrayOfRows = new Array();
            type = type.toUpperCase();
            dateformat = dateformat.toLowerCase();
            for (var i = 0, len = rows.length; i < len; i++) {
                arrayOfRows[i] = new Object;
                arrayOfRows[i].oldIndex = i;
                var celltext = rows[i].getElementsByTagName("td")[sortColumn].innerHTML.replace(/<[^>]*>/g, "");
                if (type == 'D') {
                    arrayOfRows[i].value = GetDateSortingKey(dateformat, celltext);
                } else {
                    var re = type == "N" ? /[^\.\-\+\d]/g : /[^a-zA-Z0-9]/g;
                    arrayOfRows[i].value = celltext.replace(re, "").substr(0, 25).toLowerCase();
                }
            }
            if (sortColumn == TableLastSortedColumn) {
                arrayOfRows.reverse();
            } else {
                TableLastSortedColumn = sortColumn;
                switch (type) {
                    case "N":
                        arrayOfRows.sort(CompareRowOfNumbers);
                        break;
                    default:
                        arrayOfRows.sort(CompareRowOfText);
                }
            }
            var newTableBody = document.createElement("tbody");
            for (var i = 0, len = arrayOfRows.length; i < len; i++) {
                newTableBody.appendChild(rows[arrayOfRows[i].oldIndex].cloneNode(true));
            }
            table.replaceChild(newTableBody, tbody);
        } // function SortTable()

        function CompareRowOfText(a, b) {
            var aval = a.value;
            var bval = b.value;
            return (aval == bval ? 0 : (aval > bval ? 1 : -1));
        } // function CompareRowOfText()

        function CompareRowOfNumbers(a, b) {
            var aval = /\d/.test(a.value) ? parseFloat(a.value) : 0;
            var bval = /\d/.test(b.value) ? parseFloat(b.value) : 0;
            return (aval == bval ? 0 : (aval > bval ? 1 : -1));
        } // function CompareRowOfNumbers()

        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("sort");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

    </script>

</body>

</html>

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
    <title>NGCB</title>
    <link rel="icon" type="image/png" href="../Images/NGCB_logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/css/materialize.css" rel="stylesheet">
    <link rel="stylesheet" text="type/css" href="../style.css">
</head>

<body>
<nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="mobile-demo" class="button-collapse show-on-large pulse"><i
                    class="material-icons">menu</i></a>
            <h4 id="NGCB">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</h4>
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
                <li>
                    <a href="adminprojects.php">Projects</a>
                </li>
                <li>
                    <div class="divider"></div>
                </li>
                <li>
                    <a href="hauledmaterials.php">Hauled Materials</a>
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
    
    <div class="">
        <?php 
           $projects_name = $_GET['projects_name'];
        ?>
        <div class="row">
            <h5>Project Name:
                <?php echo $projects_name; ?>
            </h5>
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a href="#sitematerials">Site Materials</a></li>
                    <li class="tab col s3"><a href="#categories">Categories</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!--SITE MATERIALS-->
    <div id="sitematerials" class="col s12">
        <div class="view-inventory-container">
            <div class="light-blue lighten-5 ">
                <table class="striped centered view-inventory">
                    <thead class="view-inventory-head">
                        <tr>
                            <th>Particulars</th>
                            <th>Previous Material Stock</th>
                            <th>Delivered Material as of
                                <?php echo date("F Y"); ?>
                            </th>
                            <th>Material Pulled out as of
                                <?php echo date("F Y"); ?>
                            </th>
                            <th>Accumulate of Materials Delivered</th>
                            <th>Material on Site as of
                                <?php echo date("F Y"); ?>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $sql = "SELECT
                            materials.mat_name, 
                            materials.mat_prevStock, 
                            stockcard.stockcard_totalDelivered, 
                            stockcard.stockcard_totalPulledOut, 
                            (stockcard.stockcard_totalDelivered + materials.mat_prevStock), 
                            stockcard.stockcard_quantity 
                            FROM materials 
                            INNER JOIN projects ON materials.mat_project = projects.projects_id 
                            INNER JOIN stockcard ON materials.mat_id = stockcard.stockcard_id
                            WHERE projects.projects_name = '$projects_name';";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)){
                        ?>

                        <tr>
                            <td>
                                <?php echo $row[0] ?>
                            </td>
                            <td>
                                <?php echo $row[1] ?>
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
                        </tr>
                        <?php    
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--SITE CATEGORIES-->
    <div id="categories" class="col s12">
        <div class="row">
            <?php
        $sql = "SELECT * FROM  categories ORDER BY categories_name;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)) {
    ?>
            <div class="col s3 m3 category-container">
                <div class="card center">
                    <div class="card-content category-cards">
                        <span class="card-title category-title">
                            <?php echo $row[1] ;?>
                        </span>
                        <div class="row">
                            <form action="server.php" method="POST">
                                <input type="hidden" name="categories_id" value="<?php echo $row[0]?>">
                                <button class="waves-effect waves-light btn view-inventory-btn" type="submit"
                                    name="view_category">View Inventory</button>
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

            $(".add-row").click(function () {
                var quantity = $("#name").val();
                var unit = $("#email").val();
                var articles = $('#articles').val();
                var markup = "<tr>" +
                    "<td><input type=\"text\" name=\"category_name[]\"></td>" +
                    "</tr>;"
                $("table tbody").append(markup);
            });
        });
    </script>

</body>

</html>

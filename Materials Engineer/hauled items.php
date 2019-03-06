<!DOCTYPE html>

<html>

<head>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css"  media="screen,projection"/>
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
          <span class="title"><?php echo $row[1]." ".$row[2]; ?></span>
          <span class="title"><?php echo $row[5]; }?></span>
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
                <li><a class="waves-effect waves-blue" href="sitematerials.html">Site Materials</a></li>
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

                <tbody>
                    <tr>
                        <td>12345</td>
                        <td>August 8, 2019</td>
                        <td><a class="waves-effect waves-light btn green">View</a>
                            <a href="#deleteModal" class="waves-effect waves-light btn red modal-trigger">Delete</a></td>
                    </tr>
                    <tr>
                        <td>67890</td>
                        <td>Januray 1, 2019</td>
                        <td><a class="waves-effect waves-light btn green">View</a>
                            <a href="#deleteModal" class="waves-effect waves-light btn red modal-trigger">Delete</a></td>
                    </tr>
                </tbody>
            </table>
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

    <script src="js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.modal-trigger').leanModal();
        });

    </script>
</body>

</html>

<?php
    include "../db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
      header('Location: http://127.0.0.1/NGCB/index.php');
    }
$mat_name = $_GET['mat_name'];
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
        <a href="sitematerials.php"
                class="button-collapse show-on-large menu-icon back-btn"><i class="material-icons menuIcon">arrow_back</i>
                </a>
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
            </ul>
        </div>
    </nav>


    <div class="col view-inventory-slider">
        <ul class="tabs tabs-inventory">
            <li class="tab col s3"><a href="#deliverin">Deliver In</a></li>
            <li class="tab col s3"><a href="#usagein">Usage In</a></li>
        </ul>
    </div>

    <div id="deliverin" class="col s12">
        <div class="deliverin-container">
            <form action="../server.php" method="POST">
                <table id="sort" class="centered deliverin striped">
                    <thead class="deliverin-head">
                        <tr>
                            <th onClick = "javascript:SortTable(0,'D');">Date</th>
                            <th onClick = "javascript:SortTable(1,'N');">Quantity</th>
                            <th onClick = "javascript:SortTable(2,'T');">Unit</th>
                            <th onClick = "javascript:SortTable(3,'T');">Supplied By</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="stockcard-entry">
                            <?php 
                        $sql = "SELECT 
                        unit.unit_name, materials.mat_id, unit.unit_id FROM materials 
                        INNER JOIN unit ON materials.mat_unit = unit.unit_id
                        WHERE mat_name = '$mat_name';";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)){
                        $mat_id = $row[1];
                        ?>
                            <input type="hidden" name="mat_name" value="<?php echo htmlentities($mat_name); ?>">
                            <input type="hidden" name="mat_id" value="<?php echo $row[1]; ?>">
                        </tr>

                        <?php 
                        $sql_devIn = "SELECT deliveredin.delivered_date, 
                        deliveredin.delivered_quantity, 
                        unit.unit_name, 
                        deliveredin.suppliedBy, 
                        deliveredin.delivered_matName 
                        FROM deliveredin 
                        INNER JOIN unit ON deliveredin.delivered_unit = unit.unit_id 
                        WHERE delivered_matName = '$mat_id'";
                        $result_devIn = mysqli_query($conn, $sql_devIn);
                        while($row_devIn = mysqli_fetch_row($result_devIn)){
                        ?><tr class="deliverin-data">
                            <td>
                                <?php echo $row_devIn[0] ?>
                            </td>
                            <td>
                                <?php echo $row_devIn[1] ?>
                            </td>
                            <td>
                                <?php echo $row_devIn[2] ?>
                            </td>
                            <td>
                                <?php echo $row_devIn[3] ?>
                            </td>
                        </tr>
                        <?php 
                        }
                        ?>
                    </tbody>
                </table>
                <div>
                <?php 
                        $sql_total = "SELECT SUM(delivered_quantity) FROM deliveredin as total_deliveredin  WHERE delivered_matname = '$mat_id';";
                        $result_total = mysqli_query($conn, $sql_total);
                        while($row_total = mysqli_fetch_row($result_total)){
                        ?>
                            <span>TOTAL:</span>
                            <span><?php echo $row_total[0]?></span>
                            <?php 
                        }
                    }   
                        ?>
                    </div>
            </form>
        </div>
    </div>

    <div id="usagein" class="col s12">
        <div class="usagein-container">
            <form action="../server.php" method="POST">
                <table id = "sort" class="centered usagein striped">
                    <thead class="usagein-head">
                        <tr>
                            <th onClick = "javascript:SortTable(0,'D');">Date</th>
                            <th onClick = "javascript:SortTable(1,'N');">Quantity</th>
                            <th onClick = "javascript:SortTable(2,'T');">Unit</th>
                            <th onClick = "javascript:SortTable(3,'T');">Pulled Out By</th>
                            <th onClick = "javascript:SortTable(4,'T');">Area of Usage</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $sql = "SELECT 
                        unit.unit_name, materials.mat_id, unit.unit_id FROM materials 
                        INNER JOIN unit ON materials.mat_unit = unit.unit_id
                        WHERE mat_name = '$mat_name';";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_row($result)){
                        $mat_id = $row[1];
                        ?>
                        <?php 
                        $sql_useIn = "SELECT usagein.usage_date, usagein.usage_quantity, unit.unit_name, usagein.pulledOutBy, usagein.usage_areaOfUsage FROM usagein INNER JOIN unit ON usagein.usage_unit = unit.unit_id WHERE usage_matname = '$mat_id';";
                        $result_useIn = mysqli_query($conn, $sql_useIn);
                        while($row_useIn = mysqli_fetch_row($result_useIn)){
                        ?>
                        <tr class="usagein_data">
                            <td>
                                <?php echo $row_useIn[0] ?>
                            </td>
                            <td>
                                <?php echo $row_useIn[1] ?>
                            </td>
                            <td>
                                <?php echo $row_useIn[2] ?>
                            </td>
                            <td>
                                <?php echo $row_useIn[3] ?>
                            </td>
                            <td>
                                <?php echo $row_useIn[4] ?>
                            </td>
                        </tr>
                        <?php 
                        }
                        ?>
                        </tbody>
                </table>
                <div>
                <?php 
                        $sql_total = "SELECT SUM(usage_quantity) FROM usagein as total_usagein  WHERE usage_matname = '$mat_id';";
                        $result_total = mysqli_query($conn, $sql_total);
                        while($row_total = mysqli_fetch_row($result_total)){
                        ?>
                            <span>TOTAL:</span>
                            <span><?php echo $row_total[0]?></span>
                            <?php 
                        }
                    }   
                        ?>
                    </div>
            </form>
        </div>
                </div>


    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script>
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
for(var i=0, len=rows.length; i<len; i++) {
	arrayOfRows[i] = new Object;
	arrayOfRows[i].oldIndex = i;
	var celltext = rows[i].getElementsByTagName("td")[sortColumn].innerHTML.replace(/<[^>]*>/g,"");
	if( type=='D' ) { 
        arrayOfRows[i].value = GetDateSortingKey(dateformat,celltext);
    } else {
		var re = type=="N" ? /[^\.\-\+\d]/g : /[^a-zA-Z0-9]/g;
		arrayOfRows[i].value = celltext.replace(re,"").substr(0,25).toLowerCase();
		}
	}
if (sortColumn == TableLastSortedColumn) { 
    arrayOfRows.reverse(); 
} else {
	TableLastSortedColumn = sortColumn;
	switch(type) {
		case "N" : arrayOfRows.sort(CompareRowOfNumbers); break;
        case "D" : arrayOfRows.sort(CompareRowOfNumbers); break;
		default  : arrayOfRows.sort(CompareRowOfText);
	}
}
var newTableBody = document.createElement("tbody");
for(var i=0, len=arrayOfRows.length; i<len; i++) {
	newTableBody.appendChild(rows[arrayOfRows[i].oldIndex].cloneNode(true));
}
table.replaceChild(newTableBody,tbody);
} // function SortTable()

function CompareRowOfText(a,b) {
var aval = a.value;
var bval = b.value;
return( aval == bval ? 0 : (aval > bval ? 1 : -1) );
} // function CompareRowOfText()

function CompareRowOfNumbers(a,b) {
var aval = /\d/.test(a.value) ? parseFloat(a.value) : 0;
var bval = /\d/.test(b.value) ? parseFloat(b.value) : 0;
return( aval == bval ? 0 : (aval > bval ? 1 : -1) );
} // function CompareRowOfNumbers()

function GetDateSortingKey(format,text) {
if( format.length < 1 ) { return ""; }
format = format.toLowerCase();
text = text.toLowerCase();
text = text.replace(/^[^a-z0-9]*/,"");
text = text.replace(/[^a-z0-9]*$/,"");
if( text.length < 1 ) { return ""; }
text = text.replace(/[^a-z0-9]+/g,",");
var date = text.split(",");
if( date.length < 3 ) { return ""; }
var d=0, m=0, y=0;
for( var i=0; i<3; i++ ) {
	var ts = format.substr(i,1);
	if( ts == "d" ) { d = date[i]; }
	else if( ts == "m" ) { m = date[i]; }
	else if( ts == "y" ) { y = date[i]; }
	}
d = d.replace(/^0/,"");
if( d < 10 ) { d = "0" + d; }
m = m.replace(/^0/,"");
if( m < 10 ) { m = "0" + m; }
y = parseInt(y);
if( y < 100 ) { y = parseInt(y) + 2000; }
return "" + String(y) + "" + String(m) + "" + String(d) + "";
} // function GetDateSortingKey()
        </script>
</body>

</html>
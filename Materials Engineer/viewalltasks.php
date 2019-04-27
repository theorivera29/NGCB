<?php
    include "../db_connection.php";
    session_start();

    if(!isset($_SESSION['loggedin'])) {
        header('Location: http://127.0.0.1/NGCB/index.php');
    }

    $account_id = "";
    if(isset($_SESSION['account_id'])) {
        $account_id = $_SESSION['account_id'];
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
            <form action="../server.php" method="POST">
                <a href="dashboard.php" class="button-collapse show-on-large menu-icon back-btn"><i
                        class="material-icons menuIcon">arrow_back</i>
                    <input type="hidden" name="account_id" value="<?php echo $account_id?>">
                </a>
            </form>
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

    <div id="viewAllTask">
        <span class="task-text">ALL TASK</span>
        <table id="sort" class="striped centered view-all-tasks">
            <thead class="view-tasks-head">
                <tr class="task-headers">
                    <th onClick="javascript:SortTable(0,'D');">Date<i
                        class="material-icons tiny sort-icon">code</i></th>
                    <th onClick="javascript:SortTable(1,'T');">Task<i
                        class="material-icons tiny sort-icon">code</i></th>
                    <th onClick="javascript:SortTable(2,'T');">Status<i
                        class="material-icons tiny sort-icon">code</i></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="all-task-table-container">
                <?php 
                    $sql = "SELECT * FROM todo WHERE todoOf = '$account_id' ORDER BY todo_date;";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td class="all-task-data-table1">
                        <?php echo $row[1] ;?>
                    </td>
                    <td class="all-task-data-table2">
                        <?php echo $row[2] ;?>
                    </td>
                    <td class="all-task-data-table">
                        <?php echo $row[3] ;?>
                    </td>
                    <td class="all-task-data-table">
                        <form action="../server.php" method="POST">
                            <?php
                                if(strcasecmp($row[3], 'in progress') == 0) {
                            ?>
                            <input type="hidden" name="todo_id" value="<?php echo $row[0] ;?>">
                            <input type="hidden" name="todo_status" value="<?php echo $row[3] ;?>">
                            <input type="hidden" name="update_from" value="viewall">
                            <button class="waves-effect waves-light btn modal-trigger doneBtn"
                                href="#doneBtn<?php echo $row[0] ;?>">Done</button>
                            <div id="doneBtn<?php echo $row[0] ;?>" class="modal">
                                <div class="modal-content">
                                    <span>Are you sure want to click done?</span>
                                    <br>
                                    <?php echo $row[2];?>
                                </div>
                                <div class="modal-footer">
                                    <a class="modal-close waves-effect waves-red btn-flat no-btn">No</a>
                                    <button type="submit" name="todo_update"
                                        class="modal-close waves-effect waves-red btn-flat yes-btn">Yes</button>
                                </div>
                            </div>
                            <?php
                                } else {
                            ?>
                            <input type="hidden" name="todo_id" value="<?php echo $row[0] ;?>">
                            <input type="hidden" name="todo_status" value="<?php echo $row[3] ;?>">
                            <input type="hidden" name="update_from" value="viewall">
                            <button class="waves-effect waves-light btn modal-trigger clearBtn"
                                href="#clearBtn<?php echo $row[0] ;?>">Clear</button>
                            <div id="clearBtn<?php echo $row[0] ;?>" class="modal">
                                <div class="modal-content">
                                    <span>Are you sure want to clear this task</span>
                                    <br>
                                    <?php echo $row[2];?>
                                </div>
                                <div class="modal-footer">
                                    <a class="modal-close waves-effect waves-red btn-flat no-btn">No</a>
                                    <button type="submit" name="todo_update"
                                        class="modal-close waves-effect waves-red btn-flat yes-btn">Yes</button>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </form>
                    </td>
                </tr>
                <?php    
                    }
                ?>
            </tbody>
        </table>
    </div>


    <!--Import jQuery materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.js">
    </script>
    <script>
        $(document).ready(function () {
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
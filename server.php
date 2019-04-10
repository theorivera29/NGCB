<?php
    include "db_connection.php";
    
    if (isset($_POST['login'])) {
        session_start();
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']); 
        $sql = "SELECT accounts_id, accounts_password, accounts_type FROM accounts WHERE accounts_username = '$username'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $hash_password = $row[1];
        if(/*password_verify($password, $hash_password)*/true) {
            $_SESSION['tasks']= $row[0];
            $_SESSION['username'] = $username; 
            $_SESSION['loggedin' ] = true;
            $_SESSION['account_type'] = $row[2];
            if (strcmp($row[2],"Admin") == 0) {
                header("location: http://127.0.0.1/NGCB/Admin/admindashboard.php");
                exit;
            } else if (strcmp($row[2],"MatEng") == 0) {
                header("location: http://127.0.0.1/NGCB/Materials%20Engineer/dashboard.php");
                exit;
            } else {
                header("location: http://127.0.0.1/NGCB/View%20Only/projects.php");
                exit;
            }
        } else {
            $_SESSION['login_error'] = true;
            header("location: http://127.0.0.1/NGCB/index.php");
            exit;
        } 
    }

    if (isset($_POST['logout'])) {
        session_start();
        session_unset();
        session_destroy();
        header('Location: http://127.0.0.1/NGCB/index.php');
        exit;
    }  

    if (isset($_POST['create_account'])) {
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
	    $username = mysqli_real_escape_string($conn, $_POST['username']);
	    $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
	    $password = password_hash($password, PASSWORD_DEFAULT);
        $account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
        $sql = "SELECT account_id from accounts;";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        if($count != 1) {
            $sql = "INSERT INTO accounts (accounts_fname, accounts_lname, accounts_username, accounts_password, accounts_type, accounts_email, accounts_deletable, accounts_status)
                    VALUES ('$firstname', '$lastname', '$username', '$password', '$account_type', '$email', 'yes', 'active');";
            mysqli_query($conn,$sql);
            header("Location: http://127.0.0.1/NGCB/Admin/listofaccounts.php");
            exit;
        }
    }
    
    if (isset($_POST['create_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projectname']);
        $projects_address = mysqli_real_escape_string($conn, $_POST['projectaddress']);
		$start_date = mysqli_real_escape_string($conn, $_POST['startdate']);
		$end_date = mysqli_real_escape_string($conn, $_POST['enddate']);
        $sql = "SELECT projects_name from projects WHERE = '$projects_name';";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        if($count != 1) {
            $sql = "INSERT INTO projects (projects_name, projects_address, projects_sdate, projects_edate, projects_status, projects_mateng)
                    VALUES ('$projects_name', '$projects_address', '$start_date', '$end_date', 'open', 2);";
            mysqli_query($conn,$sql);
            header("Location: http://127.0.0.1/NGCB/Admin/projects.php");
            exit;
        }
    }
    
    if (isset($_POST['close_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['project_name']);
        $sql = "UPDATE projects SET projects_status = 'closed' WHERE projects_name = '$projects_name';";
        mysqli_query($conn,$sql);
        header("location: http://127.0.0.1/NGCB/Admin/projects.php");
    }

    if (isset($_POST['reopen_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['project_name']);
        $sql = "UPDATE projects SET projects_status = 'open' WHERE projects_name = '$projects_name';";
        mysqli_query($conn,$sql);
        header("location: http://127.0.0.1/NGCB/Admin/projects.php");
    }

    if(isset($_POST['edit_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['project_name']);

        if(isset($_POST['new_project_name'])) {
            $new_project_name = mysqli_real_escape_string($conn, $_POST['new_project_name']);
            if(!strcmp($new_project_name, null) == 0) {
                $sql = "UPDATE projects SET projects_name = '$new_project_name' WHERE projects_name = '$projects_name';";
                mysqli_query($conn,$sql);
                
        echo "Old: ".$projects_name;
        echo "<br /> New: ".$new_project_name;
            }
        }

        if(isset($_POST['new_address'])) {
            $new_address = mysqli_real_escape_string($conn, $_POST['new_address']);
            if(!strcmp($new_address, null) == 0) {
                $sql = "UPDATE projects SET projects_address = '$new_address' WHERE projects_name = '$projects_name';";
                mysqli_query($conn, $sql);
            }
        }

        if(isset($_POST['new_sdate'])) {
            $new_sdate = mysqli_real_escape_string($conn, $_POST['new_sdate']);
            if(!strcmp($new_sdate, null) == 0) {
                $sql = "UPDATE projects SET projects_sdate = '$new_sdate' WHERE projects_name = '$projects_name';";
                mysqli_query($conn, $sql);
            }
        }

        if(isset($_POST['new_edate'])) {
            $new_edate = mysqli_real_escape_string($conn, $_POST['new_edate']);
            if(!strcmp($new_edate, null) == 0) {
                $sql = "UPDATE projects SET projects_edate = '$new_edate' WHERE projects_name = '$projects_name';";
                mysqli_query($conn, $sql);
            }
        }
        header("location: http://127.0.0.1/NGCB/Admin/projects.php");
    } 

    if(isset($_POST['view_inventory'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        $account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
        if(strcmp($account_type,'MatEng') == 0) {
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");
            exit();
        } else {
            header("location: http://127.0.0.1/NGCB/View%20Only/viewinventory.php?projects_name=$projects_name");
            exit();
        }
    }

    if(isset($_POST['fillout_hauling'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/fillouthauling.php?projects_name=$projects_name");
    }

    if(isset($_POST['open_report'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/reportpage.php?projects_name=$projects_name");
    }

    if(isset($_POST['disable_account'])) {
        $accounts_id = mysqli_real_escape_string($conn, $_POST['accounts_id']);
        $sql = "UPDATE accounts SET accounts_status = 'disabled' WHERE accounts_id = '$accounts_id';";
        mysqli_query($conn, $sql);
        header("location: http://127.0.0.1/NGCB/Admin/listofaccounts.php");
    }

    if(isset($_POST['view_category'])) {
        $categories_id = mysqli_real_escape_string($conn, $_POST['categories_id']);
        $account_type =  mysqli_real_escape_string($conn, $_POST['account_type']);
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        if(strcmp($account_type,'MatEng') == 0) {
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/itemcategories.php?categories_id=$categories_id&projects_name=$projects_name");
            exit();
        } else {
            header("location: http://127.0.0.1/NGCB/View%20Only/itemcategories.php?categories_id=$categories_id&projects_name=$projects_name");
            exit();
        }
    }

    if(isset($_POST['view_hauled'])) {
        $hauling_no = mysqli_real_escape_string($conn, $_POST['hauling_no']);
        $account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
        if(strcmp($account_type,'MatEng') == 0) {
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/openhauling.php?hauling_no=$hauling_no");
            exit();
        } else {
        header("location: http://127.0.0.1/NGCB/View%20Only/openhauling.php?hauling_no=$hauling_no");
            exit();
        }
    }

    if (isset($_POST['create_hauling'])) {
        $hauling_no = mysqli_real_escape_string($conn, $_POST['formnumber']);
        $hauling_date = mysqli_real_escape_string($conn, $_POST['haulingdate']);
		$hauling_deliverTo = mysqli_real_escape_string($conn, $_POST['delivername']);
        $hauling_hauledFrom = mysqli_real_escape_string($conn, $_POST['hauledfrom']);
        $hauling_quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $hauling_unit = mysqli_real_escape_string($conn, $_POST['unit']);
        $hauling_matname = mysqli_real_escape_string($conn, $_POST['articles']);
        $hauling_hauledBy = mysqli_real_escape_string($conn, $_POST['hauledby']);
        $hauling_warehouseman = mysqli_real_escape_string($conn, $_POST['warehouseman']);
        $hauling_approvedBy = mysqli_real_escape_string($conn, $_POST['approvedby']);
        $hauling_truckDetailsType = mysqli_real_escape_string($conn, $_POST['truck_type']);
        $hauling_truckDetailsPlateNo = mysqli_real_escape_string($conn, $_POST['truck_plate']);
        $hauling_truckDetailsPo = mysqli_real_escape_string($conn, $_POST['truck_po']);
        $hauling_truckDetailsHaulerDr = mysqli_real_escape_string($conn, $_POST['truck_hauler']);
        
        $sql = "SELECT * from hauling;";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
            $sql = "INSERT INTO hauling (hauling_no, hauling_date, hauling_deliverTo, hauling_hauledFrom, hauling_quantity, hauling_unit, hauling_matname, hauling_hauledBy, hauling_warehouseman, hauling_approvedBy, hauling_truckDetailsType, hauling_truckDetailsPlateNo, hauling_truckDetailsPo, hauling_truckDetailsHaulerDr) VALUES ($hauling_no, '$hauling_date', '$hauling_deliverTo', '$hauling_hauledFrom', $hauling_quantity, '$hauling_unit', '$hauling_matname', '$hauling_hauledBy', '$hauling_warehouseman', '$hauling_approvedBy', '$hauling_truckDetailsType', '$hauling_truckDetailsPlateNo', $hauling_truckDetailsPo, $hauling_truckDetailsHaulerDr);";
            mysqli_query($conn, $sql);
        
        $sql = "SELECT currentQuantity FROM materials WHERE mat_name='$hauling_matname';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $currentQuantity = $row[0];
        $newQuantity = $currentQuantity-$hauling_quantity;
        $sql = "UPDATE materials SET mat_prevStock = ('$newQuantity') WHERE mat_name = '$hauling_matname';";
        mysqli_query($conn, $sql);
        
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('2019-03-18 11:27:40', 'Added hauling', 1, 1);";
        mysqli_query($conn,$sql);
        
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/hauleditems.php");
            exit();
    }

    if(isset($_POST['create_category'])) {
        $arr_size = count($_POST['category_name']);
        for ($x = 0; $x != $arr_size; $x++) {
            $category_name = $_POST['category_name'][$x];
            $sql = "SELECT categories_name FROM categories WHERE categories_name = '$category_name'; ";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);
            if ($count != 1) {
                $sql = "INSERT INTO categories (categories_name) VALUES ('$category_name');";
                mysqli_query($conn, $sql);
            }
        }
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/projects.php");
        exit();
    }

    if (isset($_POST['edit_category'])) {
        $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
        $new_category_name = mysqli_real_escape_string($conn, $_POST['new_category_name']);
        $sql = "SELECT categories_name FROM categories WHERE categories_name = '$category_name'";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_row($result);
        $projects_id = $row[0];
        if($count == 1) {
            $sql = "UPDATE categories SET categories_name = '$new_category_name' WHERE categories_name = '$category_name';";
            mysqli_query($conn, $sql);
            header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/category.php");
            exit();
        }
    }


    if(isset($_POST['viewtodo'])) {
        $todoOf = mysqli_real_escape_string($conn, $_POST['todoOf']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/dashboard.php?todoOf=$todoOf");
    }
    
        if (isset($_POST['create_todo'])) {
        $todo_date = mysqli_real_escape_string($conn, $_POST['tododate']);
        $todo_task = mysqli_real_escape_string($conn, $_POST['todo_task']);
        $todoOf = mysqli_real_escape_string($conn, $_POST['todoOf']);
        $sql = "SELECT * from todo;";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
            $sql = "INSERT INTO todo (todo_date, todo_task, todo_status, todoOf) VALUES ('$todo_date', '$todo_task', 'in progress', '$todoOf');";
            mysqli_query($conn, $sql);
            header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/dashboard.php");
            exit();
    }

    if (isset($_POST['create_materials'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $mat_unit = mysqli_real_escape_string($conn, $_POST['mat_unit']);
        $mat_categ = mysqli_real_escape_string($conn, $_POST['mat_categ']);
        $mat_notif = mysqli_real_escape_string($conn, $_POST['mat_notif']);
        $delivered_date = mysqli_real_escape_string($conn, $_POST['delivered_date']);
        $delivered_quantity = mysqli_real_escape_string($conn, $_POST['delivered_quantity']);
        $supplied_by = mysqli_real_escape_string($conn, $_POST['suppliedBy']);
        
        $sql = "SELECT * from materials;";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
            
        $sql = "INSERT INTO deliveredin (delivered_date, delivered_quantity, delivered_unit, suppliedBy, delivered_matName) VALUES ('$delivered_date', $delivered_quantity, 1, '$supplied_by', 1);";
        mysqli_query($conn, $sql);
        
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('2019-03-18 11:27:40', 'Added material', 1, 1);";
        mysqli_query($conn, $sql);
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/projects.php");
        exit();
    }

    if(isset($_POST['edit_account'])) {
        $username = mysqli_real_escape_string($conn, $_POST['userid']);
        
        if(isset($_POST['newusername'])) {
            $newusername = $_POST['newusername'];
            $sql = "UPDATE accounts SET accounts_username = '$newusername' WHERE accounts_id = '$username';";
            mysqli_query($conn,$sql);
        }
        if(isset($_POST['newfname'])) {
            $newfname = mysqli_real_escape_string($conn, $_POST['newfname']);
            $sql = "UPDATE accounts SET accounts_fname = '$newfname' WHERE accounts_id = '$username';";
            mysqli_query($conn, $sql);
        }

        if(isset($_POST['newlname'])) {
            $newlname = mysqli_real_escape_string($conn, $_POST['newlname']);
            $sql = "UPDATE accounts SET accounts_lname = '$newlname' WHERE accounts_id = '$username';";
            mysqli_query($conn, $sql);
        }

        if(isset($_POST['newemail'])) {
            $newemail = mysqli_real_escape_string($conn, $_POST['newemail']);
            $sql = "UPDATE accounts SET accounts_email = '$newemail' WHERE accounts_id = '$username';";
            mysqli_query($conn, $sql);
        }
        
        if(isset($_POST['newpassword'])) {
            $newpassword = mysqli_real_escape_string($conn, $_POST['newpassword']);
            $sql = "UPDATE accounts SET accounts_password = '$newpassword' WHERE accounts_id = '$username';";
            mysqli_query($conn, $sql);
        }
        
     header("location: http://127.0.0.1/NGCB/Materials%20Engineer/account.php");
    }

    if(isset($_POST['todo_update'])) {
        $todo_id = $_POST['todo_id'];
        $todo_status = $_POST['todo_status'];

        if(strcasecmp($todo_status, 'in progress') == 0) {
            $sql = "UPDATE todo SET todo_status = 'done' WHERE todo_id = '$todo_id';";
            mysqli_query($conn, $sql);
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/dashboard.php");
        } else {
            $sql = "DELETE FROM todo WHERE todo_id = '$todo_id';";
            mysqli_query($conn, $sql);
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/dashboard.php");
        }
    }

        if (isset($_POST['add_deliveredin'])) {
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $delivered_date = mysqli_real_escape_string($conn, $_POST['dev_date']);
        $delivered_quantity = mysqli_real_escape_string($conn, $_POST['dev_quantity']);
        $delivered_unit = mysqli_real_escape_string($conn, $_POST['dev_unit']);
        $suppliedBy = mysqli_real_escape_string($conn, $_POST['dev_supp']);
        $sql = "SELECT * from deliveredin;";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        $sql = "INSERT INTO deliveredin (delivered_date, delivered_quantity, delivered_unit, suppliedBy, delivered_matName) VALUES ('$delivered_date', $delivered_quantity, 1, '$suppliedBy', 1);";
        mysqli_query($conn, $sql);
            
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('2019-03-18 11:27:40', 'Added delivered in', 1, 1);";
        mysqli_query($conn, $sql);    
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/sitematerials.php");
        exit();
    }

        if (isset($_POST['add_usagein'])) {
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $usage_date = mysqli_real_escape_string($conn, $_POST['us_date']);
        $usage_quantity = mysqli_real_escape_string($conn, $_POST['us_quantity']);
        $usage_unit = mysqli_real_escape_string($conn, $_POST['us_unit']);
        $pulloutby = mysqli_real_escape_string($conn, $_POST['pulloutby']);
        $us_area = mysqli_real_escape_string($conn, $_POST['us_area']);
        $sql = "SELECT * from usagein;";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        $sql = "INSERT INTO usagein (usage_date, usage_quantity, usage_unit, pulledOutBy, usage_areaOfUsage, usage_matname) VALUES ('$usage_date', $usage_quantity, 1, '$pulloutby', '$us_area', 1);";
        mysqli_query($conn, $sql);
            
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('2019-03-18 11:27:40', 'Added usage in', 1, 1);";
        mysqli_query($conn, $sql);
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/sitematerials.php");
        exit();
    }


        if(isset($_POST['edit_materials'])) {
        $materialname = mysqli_real_escape_string($conn, $_POST['materialname']);
        
        if(isset($_POST['newmaterialname'])) {
            $newmaterialname = $_POST['newmaterialname'];
            $sql = "UPDATE materials SET mat_name = '$newmaterialname' WHERE mat_name = '$materialname';";
            mysqli_query($conn,$sql);
        }
        if(isset($_POST['mat_unit'])) {
            $mat_unit = mysqli_real_escape_string($conn, $_POST['mat_unit']);
            $sql = "UPDATE materials SET mat_unit = '$mat_unit' WHERE mat_name = '$materialname';";
            mysqli_query($conn, $sql);
        }

        if(isset($_POST['minquantity'])) {
            $minquantity = mysqli_real_escape_string($conn, $_POST['minquantity']);
            $sql = "UPDATE materials SET mat_notif = '$minquantity' WHERE mat_name = '$materialname';";
            mysqli_query($conn, $sql);
        }
    }

    if(isset($_POST['generate_report'])) {
        $projects_name = $_POST['projects_name'];
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/generate_report.php?projects_name=$projects_name");
    }


    // API
    header("Access-Control-Allow-Origin: *");
    if (isset($_GET['category_id'])) {
        $id = $_GET['category_id'];
        $sql = "SELECT mat_id, mat_name FROM materials WHERE mat_categ = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_all($result);
        echo json_encode($row);
    }

    if (isset($_GET['mat_name'])) {
        $name = $_GET['mat_name'];
        $sql = "SELECT mat_unit FROM materials WHERE mat_id = '$name'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_all($result);
        echo json_encode($row);
    }
?>

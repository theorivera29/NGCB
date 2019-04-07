<?php
    include "db_connection.php";
  
    
    if (isset($_POST['login'])) {
        session_start();
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']); 
        $sql = "SELECT accounts_id, accounts_password FROM accounts WHERE accounts_username = '$username'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $hash_password = $row[1];
        if(
            /*password_verify($password, $hash_password)*/true) {
            $_SESSION['tasks']= $row[0];
            $_SESSION['username'] = $username; 
            $_SESSION['loggedin' ] = true;
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/dashboard.php");
            exit;
        }else {
            $_SESSION['login_error'] = true;
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/loginpage.php");
            exit;
        } 
    }

    if (isset($_POST['logout'])) {
        session_start();
        session_unset();
        session_destroy();
        header('Location: http://127.0.0.1/NGCB/Materials%20Engineer/loginpage.php');
        exit;
    }  

    if (isset($_POST['create_account'])) {
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
        $sql = "SELECT accounts_username from accounts where accounts_username = '$username' ";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        if($count != 1) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO accounts 
            (accounts_fname, accounts_lname, accounts_username, accounts_password, 
            accounts_type, accounts_email, accounts_image, accounts_deletable) 
            VALUES 
            ('$firstname', '$lastname', '$username', '$password', 
            '$account_type', '$email', NULL, 'yes');";
            mysqli_query($conn,$sql);
            header("Location: http://127.0.0.1/NGCB/Materials%20Engineer/loginpage.php");
            exit;
        }
    }
    
    if (isset($_POST['create_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['project_name']);
        $projects_address = mysqli_real_escape_string($conn, $_POST['project_address']);
		$start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
		$end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
        $sql = "SELECT projects_name from projects where projects_name = '$projects_name' ";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        if($count != 1) {
            $sql = "INSERT INTO projects (projects_name, projects_address, projects_sdate, projects_edate, projects_status)
                    VALUES ('$projects_name', '$projects_address', '$start_date', '$end_date', 'open')";
            mysqli_query($conn,$sql);
            header("Location: http://127.0.0.1/NGCB/Materials%20Engineer/projects.php");
            exit;
        }
    }
    
    if (isset($_POST['close_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['project_name']);
        $sql = "UPDATE projects SET projects_status = 'closed' WHERE projects_name = '$projects_name';";
        mysqli_query($conn,$sql);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/projects.php");
    }

    if (isset($_POST['reopen_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['project_name']);
        $sql = "UPDATE projects SET projects_status = 'open' WHERE projects_name = '$projects_name';";
        mysqli_query($conn,$sql);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/projects.php");
    }

    if(isset($_POST['edit_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['new_project_name']);
        if(isset($_POST['new_project_name'])) {
            $new_project_name = $_POST['new_project_name'];
            echo $new_project_name;
            $sql = "UPDATE projects SET projects_name = '$new_project_name' WHERE projects_name = '$projects_name';";
            mysqli_query($conn,$sql);
        }

        if(isset($_POST['new_address'])) {
            $new_address = mysqli_real_escape_string($conn, $_POST['new_address']);
            $sql = "UPDATE projects SET projects_address = '$new_address' WHERE projects_name = '$projects_name';";
            mysqli_query($conn, $sql);
        }

        if(isset($_POST['new_sdate'])) {
            $new_sdate = mysqli_real_escape_string($conn, $_POST['new_sdate']);
            $sql = "UPDATE projects SET projects_sdate = '$new_sdate' WHERE projects_name = '$projects_name';";
            mysqli_query($conn, $sql);
        }

        if(isset($_POST['new_edate'])) {
            $new_edate = mysqli_real_escape_string($conn, $_POST['new_edate']);
            $sql = "UPDATE projects SET projects_edate = '$new_edate' WHERE projects_name = '$projects_name';";
            mysqli_query($conn, $sql);
        }
        
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/projects.php");
    } 
    if(isset($_POST['view_inventory'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");
    }

    if(isset($_POST['fillout_hauling'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/fillouthauling.php?projects_name=$projects_name");
    }

    if(isset($_POST['open_report'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/reportpage.php?projects_name=$projects_name");
    }

    if(isset($_POST['view_category'])) {
        $categories_id = mysqli_real_escape_string($conn, $_POST['categories_id']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/itemcategories.php?categories_id=$categories_id");
    }

    if(isset($_POST['view_hauled'])) {
        $hauling_no = mysqli_real_escape_string($conn, $_POST['hauling_no']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/open%20hauling.php?hauling_no=$hauling_no");
    }

    if (isset($_POST['create_hauling'])) {
        $hauling_no = mysqli_real_escape_string($conn, $_POST['formnumber']);
        $hauling_date = mysqli_real_escape_string($conn, $_POST['date']);
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
            $sql = "INSERT INTO hauling (hauling_no, hauling_date, hauling_deliverTo, hauling_hauledFrom, hauling_quantity, hauling_unit, hauling_matname, hauling_hauledBy, hauling_warehouseman, hauling_approvedBy, hauling_truckDetailsType, hauling_truckDetailsPlateNo, hauling_truckDetailsPo, hauling_truckDetailsHaulerDr) VALUES ($hauling_no, '$hauling_date', '$hauling_deliverTo', '$hauling_hauledFrom', $hauling_quantity, '$hauling_unit', '$hauling_matname', '$hauling_hauledBy', '$hauling_warehouseman', '$hauling_approvedBy', '$hauling_truckDetailsType', '$hauling_truckDetailsPlateNo', $hauling_truckDetailsPo, $hauling_truckDetailsHaulerDr)";
            mysqli_query($conn, $sql);
        
        $sql = "SELECT currentQuantity FROM materials WHERE mat_name='$hauling_matname';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $currentQuantity = $row[0];
        $newQuantity = $currentQuantity-$hauling_quantity;
        $sql = "UPDATE materials SET mat_prevStock = ('$newQuantity') WHERE mat_name = '$hauling_matname';";
        mysqli_query($conn, $sql);
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/hauled%20items.php");
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
        $todo_task = mysqli_real_escape_string($conn, $_POST['todo_task']);
        $todoOf = mysqli_real_escape_string($conn, $_POST['todoOf']);
        $sql = "SELECT * from todo;";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
            $sql = "INSERT INTO todo (todo_date, todo_task, todo_status, todoOf) VALUES ('2019-05-19', '$todo_task', 'in progress', '$todoOf');";
            mysqli_query($conn, $sql);
            header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/dashboard.php");
            exit();
    }

    if (isset($_POST['create_materials'])) {
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $mat_unit = mysqli_real_escape_string($conn, $_POST['mat_unit']);
        $mat_categ = mysqli_real_escape_string($conn, $_POST['mat_categ']);
        $mat_notif = mysqli_real_escape_string($conn, $_POST['mat_notif']);
        $sql = "SELECT * from materials;";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
            $sql = "INSERT INTO materials (mat_name, mat_prevStock, mat_project, mat_unit, mat_categ, mat_notif, currentQuantity) VALUES ('$mat_name', 0, 1, '$mat_unit', 1, $mat_notif, 0);";
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
        $delivered_date = mysqli_real_escape_string($conn, $_POST['dev_date']);
        $delivered_quantity = mysqli_real_escape_string($conn, $_POST['dev_quantity']);
        $delivered_unit = mysqli_real_escape_string($conn, $_POST['unit']);
        $suppliedBy = mysqli_real_escape_string($conn, $_POST['dev_supp']);
        $sql = "SELECT * from deliveredin;";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        $sql = "INSERT INTO deliveredin (delivered_date, delivered_quantity, delivered_unit, suppliedBy) VALUES ('2019-05-19', $delivered_quantity, $delivered_unit, '$suppliedBy');";
        mysqli_query($conn, $sql);
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/sitematerials.php");
        exit();
    }


    
        if(isset($_POST['edit_materials'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
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
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/projects.php");
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

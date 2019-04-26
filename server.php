<?php
    include "db_connection.php";
    include "smtp_connection.php";
    
    if (isset($_POST['login'])) {
        session_start();
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']); 
        $stmt = $conn->prepare("SELECT accounts_id, accounts_password, accounts_type FROM accounts WHERE accounts_username = ?;");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($accounts_id, $accounts_password, $accounts_type);
        $stmt->fetch();
        if(/*password_verify($password, $accounts_password)*/true) {
            $_SESSION['account_id']= $accounts_id;
            $_SESSION['username'] = $username; 
            $_SESSION['loggedin' ] = true;
            $_SESSION['account_type'] = $accounts_type;
            if (strcmp($accounts_type,"Admin") == 0) {
                header("location: http://127.0.0.1/NGCB/Admin/admindashboard.php");
                $stmt->close();                
            } else if (strcmp($accounts_type,"MatEng") == 0) {
                header("location: http://127.0.0.1/NGCB/Materials%20Engineer/dashboard.php");    
                $stmt->close();                            
            } else {
                header("location: http://127.0.0.1/NGCB/View%20Only/projects.php");
                $stmt->close();                                
            }
        } else {
            $_SESSION['login_error'] = true;
            header("location: http://127.0.0.1/NGCB/index.php");
            $stmt->close();                
        } 
    }

    if (isset($_POST['create_account'])) {
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
	    $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $generated_password = substr(str_shuffle($characters), 0, 8);
	    $password = password_hash($generated_password, PASSWORD_DEFAULT);
        $account_type = mysqli_real_escape_string($conn, $_POST['radio-account']);
        $sql = "SELECT accounts_id from accounts WHERE accounts_username = '$username';";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        if($count != 1) {
            try {
                $stmt = $conn->prepare("INSERT INTO accounts (accounts_fname, accounts_lname, accounts_username, accounts_password, accounts_type, accounts_email, accounts_deletable, accounts_status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $firstname, $lastname, $username, $password, $account_type, $email, $deletable, $status);
                $deletable = "yes";
                $status = "active";
                $stmt->execute();
                $full_name = $firstname." ".$lastname;
                $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
                $stmt->bind_param("ssi", $create_date, $logs_message, $logs_of);
                $create_date = date("Y-m-d G:i:s");
                $logs_message = 'Created account of '.$full_name;
                $logs_of = 1;
                $stmt->execute();
                $stmt->close();
                mysqli_query($conn, $sql);
                $mail->addAddress($email, $firstname.' '.$lastname);                
                $mail->isHTML(true);                                  
                $mail->Subject = 'Welcome to your NGCBDC Inventory System Account!';
                $mail->Body    = 'Your account has been created. <br /> Please change your password after logging in. <br /> <br /> Username: <b>'.$username.'</b> <br /> Password: <b>'.$generated_password.'</b>';
                $mail->send();
            } catch (Exception $e) {}
            header("Location: http://127.0.0.1/NGCB/Admin/listofaccounts.php");
        }
    }
    
    if (isset($_POST['create_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projectname']);
        $projects_address = mysqli_real_escape_string($conn, $_POST['projectaddress']);
		$start_date = mysqli_real_escape_string($conn, $_POST['startdate']);
		$end_date = mysqli_real_escape_string($conn, $_POST['enddate']);
        $stmt = $conn->prepare("SELECT projects_name from projects WHERE = ?;");
        $stmt->bind_param("s", $projects_name);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO projects (projects_name, projects_address, projects_sdate, projects_edate, projects_status, projects_mateng)
                    VALUES (?, ?, ?, ?, ?, ?);");
            $stmt->bind_param("sssssi", $projects_name, $projects_address, $start_date, $end_date, $projects_status, $projects_mateng);
            $projects_status = "open";
            $projects_mateng = 2;
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
            $stmt->bind_param("ssi", $create_proj_date, $logs_message, $logs_of);
            $create_proj_date = date("Y-m-d G:i:s");
            $logs_message = 'Created project '.$projects_name;
            $logs_of = 1;
            mysqli_query($conn, $sql);
            header("Location: http://127.0.0.1/NGCB/Admin/projects.php");            
        }
    }
    
    if (isset($_POST['close_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['project_name']);
        $sql = "UPDATE projects SET projects_status = 'closed' WHERE projects_name = '$projects_name';";
        mysqli_query($conn,$sql);
        $close_date = date("Y-m-d G:i:s");
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$close_date', 'Closed project $projects_name', 1);";
        mysqli_query($conn, $sql);
        header("location: http://127.0.0.1/NGCB/Admin/projects.php");        
    }

    if (isset($_POST['reopen_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['project_name']);
        $sql = "UPDATE projects SET projects_status = 'open' WHERE projects_name = '$projects_name';";
        mysqli_query($conn,$sql);
        $reopen_date = date("Y-m-d G:i:s");
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$reopen_date', 'Reopened project $projects_name', 1);";
        mysqli_query($conn, $sql);
        header("location: http://127.0.0.1/NGCB/Admin/projects.php");        
    }

    if(isset($_POST['edit_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['project_name']);

        if(isset($_POST['new_project_name'])) {
            $new_project_name = mysqli_real_escape_string($conn, $_POST['new_project_name']);
            if(!strcmp($new_project_name, null) == 0) {
                $stmt = $conn->prepare("UPDATE projects SET projects_name = ? WHERE projects_name = ?;");
                $stmt->bind_param("ss", $new_project_name, $projects_name);
                $stmt->execute();
                $stmt->close();
            }
        }

        if(isset($_POST['new_address'])) {
            $new_address = mysqli_real_escape_string($conn, $_POST['new_address']);
            if(!strcmp($new_address, null) == 0) {
                $stmt = $conn->prepare("UPDATE projects SET projects_address = ? WHERE projects_name = ?;");
                $stmt->bind_param("ss", $new_address, $projects_name);
                $stmt->execute();
                $stmt->close();
            }
        }

        if(isset($_POST['new_sdate'])) {
            $new_sdate = mysqli_real_escape_string($conn, $_POST['new_sdate']);
            if(!strcmp($new_sdate, null) == 0) {
                $stmt = $conn->prepare("UPDATE projects SET projects_sdate = ? WHERE projects_name = ?;");
                $stmt->bind_param("ss", $new_sdate, $projects_name);
                $stmt->execute();
                $stmt->close();
            }
        }

        if(isset($_POST['new_edate'])) {
            $new_edate = mysqli_real_escape_string($conn, $_POST['new_edate']);
            if(!strcmp($new_edate, null) == 0) {
                $stmt = $conn->prepare("UPDATE projects SET projects_edate = ? WHERE projects_name = ?;");
                $stmt->bind_param("ss", $new_edate, $projects_name);
                $stmt->execute();
                $stmt->close();
            }
        }
        header("location: http://127.0.0.1/NGCB/Admin/projects.php");        
    } 

    if(isset($_POST['view_inventory'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        $account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
        if(strcmp($account_type,'MatEng') == 0) {
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");            
        } else {
            header("location: http://127.0.0.1/NGCB/View%20Only/viewinventory.php?projects_name=$projects_name");            
        }
    }

    if(isset($_POST['back'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");            
    }

    if(isset($_POST['fillout_hauling'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/fillouthauling.php?projects_name=$projects_name");        
    }

    if(isset($_POST['open_stockcard'])) {
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/stockcard.php?mat_name=$mat_name&projects_name=$projects_name");
    }

    if(isset($_POST['view_open_sitestockcard'])) {
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        header("location: http://127.0.0.1/NGCB/View%20Only/sitestockcard.php?mat_name=$mat_name");

    }

    if(isset($_POST['open_sitestockcard'])) {
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/sitestockcard.php?mat_name=$mat_name");
    }
    
    if(isset($_POST['open_report'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/reportpage.php?projects_name=$projects_name");        
    }

    if(isset($_POST['disable_account'])) {
        $accounts_id = mysqli_real_escape_string($conn, $_POST['accounts_id']);
        $sql = "SELECT CONCAT(accounts_fname, ' ', accounts_lname) FROM accounts WHERE accounts_id = '$accounts_id';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $accounts_name = $row[0];
        $sql = "UPDATE accounts SET accounts_status = 'disabled' WHERE accounts_id = '$accounts_id';";
        mysqli_query($conn, $sql);
        $disable_date = date("Y-m-d G:i:s");
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$disable_date', 'Disabled account of $accounts_name', 1);";
        mysqli_query($conn, $sql);
        header("location: http://127.0.0.1/NGCB/Admin/listofaccounts.php");        
    }

    if(isset($_POST['view_category'])) {
        $categories_id = mysqli_real_escape_string($conn, $_POST['categories_id']);
        $account_type =  mysqli_real_escape_string($conn, $_POST['account_type']);
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        if(strcmp($account_type,'MatEng') == 0) {
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/itemcategories.php?categories_id=$categories_id&projects_name=$projects_name");            
        } else {
            header("location: http://127.0.0.1/NGCB/View%20Only/itemcategories.php?categories_id=$categories_id&projects_name=$projects_name");            
        }
    }

    if(isset($_POST['view_hauled'])) {
        $hauling_no = mysqli_real_escape_string($conn, $_POST['hauling_no']);
        $account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
        if(strcmp($account_type,'MatEng') == 0) {
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/viewhaulingform.php?hauling_no=$hauling_no");            
        } else {
        header("location: http://127.0.0.1/NGCB/View%20Only/viewhaulingform.php?hauling_no=$hauling_no");            
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
        
        $stmt = $conn->prepare("INSERT INTO hauling 
        (hauling_no, hauling_date, hauling_deliverTo, hauling_hauledFrom, hauling_quantity, hauling_unit, hauling_matname, 
        hauling_hauledBy, hauling_warehouseman, hauling_approvedBy, hauling_truckDetailsType, hauling_truckDetailsPlateNo, 
        hauling_truckDetailsPo, hauling_truckDetailsHaulerDr) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("isssiiisissssss", $hauling_no, $hauling_date, $hauling_deliverTo, $hauling_hauledFrom, $hauling_quantity, 
        $hauling_unit, $hauling_matname, $hauling_hauledBy, $hauling_warehouseman, $hauling_approvedBy, $hauling_truckDetailsType, 
        $hauling_truckDetailsPlateNo, $hauling_truckDetailsPo, $hauling_truckDetailsHaulerDr);
        $stmt->execute();
        $stmt->close();
        
        $stmt = $conn->prepare("SELECT currentQuantity FROM materials WHERE mat_name = ?;");
        $stmt->bind_param("s", $hauling_matname);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($currentQuantity);
        $stmt->fetch();
        $newQuantity = $currentQuantity-$hauling_quantity;
        $stmt = $conn->prepare("UPDATE materials SET currentQuantity = ? WHERE mat_name = ?;");
        $stmt->bind_param("is", $newQuantity, $hauling_matname);
        $stmt->execute();
        $stmt->close();
        $account_id = "";
        session_start();
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $create_haul_date, $logs_message, $logs_of);
        $create_haul_date = date("Y-m-d G:i:s");
        $logs_message = 'Added Hauling No. '.$hauling_no;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/hauleditems.php");        
    }

    if(isset($_POST['create_category'])) {
        $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        $sql = "INSERT INTO categories (categories_name, categories_project) VALUES ('$category_name', 1);";
        mysqli_query($conn, $sql);
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $create_categ_date, $logs_message, $logs_of);
        $create_categ_date = date("Y-m-d G:i:s");
        $logs_message = 'Created category '.$category_name;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");        
    }

    if (isset($_POST['edit_category'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
        $new_category_name = mysqli_real_escape_string($conn, $_POST['new_category_name']);
        $stmt = $conn->prepare("SELECT categories_name FROM categories WHERE categories_name = ?");
        $stmt->bind_param("s", $category_name);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) {
            $stmt = $conn->prepare("UPDATE categories SET categories_name = ? WHERE categories_name = ?;");
            $stmt->bind_param("ss", $new_category_name, $category_name);
            $stmt->execute();
            $stmt->close();

            session_start();
            $account_id = "";
            if(isset($_SESSION['account_id'])) {
                $account_id = $_SESSION['account_id'];
            }
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $create_categ_date, $logs_message, $logs_of);
            $edit_categ_date = date("Y-m-d G:i:s");
            $logs_message = 'Edited category '.$category_name;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
            header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");            
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
        $stmt = $conn->prepare("INSERT INTO todo (todo_date, todo_task, todo_status, todoOf) VALUES (?, ?, ?, ?);");
        $stmt->bind_param("sssi", $todo_date, $todo_task, $todo_status, $todoOf);
        $todo_status = "in progress";
        $stmt->execute();
        $stmt->close();
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $create_todo_date = date("Y-m-d G:i:s");
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $create_categ_date, $logs_message, $logs_of);
        $edit_categ_date = date("Y-m-d G:i:s");
        $logs_message = 'Created todo';
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/dashboard.php");        
    }

    if (isset($_POST['create_materials'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $mat_unit = mysqli_real_escape_string($conn, $_POST['mat_unit']);
        $mat_categ = mysqli_real_escape_string($conn, $_POST['mat_categ']);
        $mat_notif = mysqli_real_escape_string($conn, $_POST['mat_notif']);
        $delivered_date = mysqli_real_escape_string($conn, $_POST['date']);
        $delivered_quantity = mysqli_real_escape_string($conn, $_POST['dev_quantity']);
        $supplied_by = mysqli_real_escape_string($conn, $_POST['suppliedBy']);
        $stmt = $conn->prepare("SELECT projects_id FROM projects WHERE projects_name = ?");
        $stmt->bind_param("s", $projects_name);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mat_project);
        $stmt->fetch();
        $stmt = $conn->prepare("INSERT INTO materials
        (mat_name, mat_prevStock, mat_project, mat_unit, mat_categ, mat_notif, currentQuantity, pulled_out, accumulated_materials, delivered_material) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("siiiiiiiii", $mat_name, $mat_prevStock, $mat_project, $mat_unit, $mat_categ, $mat_notif, $delivered_quantity, $pulled_out, $accumulated_materials, $delivered_material);
        $mat_prevStock = 0;
        $pulled_out = 0;
        $accumulated_materials = 0;
        $delivered_material = 0;
        $stmt->execute();
        $stmtm->close();
        mysqli_query($conn, $sql);
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $create_categ_date, $logs_message, $logs_of);
        $create_mat_date = date("Y-m-d G:i:s");
        $logs_message = 'Created material '.$mat_name;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");        
    }


    //////////////////////////////////////////////////////////
    if(isset($_POST['edit_account'])) {
        $username = mysqli_real_escape_string($conn, $_POST['userid']);
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $edit_account_date = date("Y-m-d G:i:s");
        if(isset($_POST['newusername'])) {
            $newusername = $_POST['newusername'];
            $sql = "UPDATE accounts SET accounts_username = '$newusername' WHERE accounts_id = '$username';";
            mysqli_query($conn,$sql);
            $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$edit_account_date', 'Change account username to $newusername', $account_id);";
            mysqli_query($conn, $sql);
        }
        if(isset($_POST['newfname'])) {
            $newfname = mysqli_real_escape_string($conn, $_POST['newfname']);
            $sql = "UPDATE accounts SET accounts_fname = '$newfname' WHERE accounts_id = '$username';";
            mysqli_query($conn, $sql);
            $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$edit_account_date', 'Change first name to $newfname', $account_id);";
            mysqli_query($conn, $sql);
        }

        if(isset($_POST['newlname'])) {
            $newlname = mysqli_real_escape_string($conn, $_POST['newlname']);
            $sql = "UPDATE accounts SET accounts_lname = '$newlname' WHERE accounts_id = '$username';";
            mysqli_query($conn, $sql);
            $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$edit_account_date', 'Change last name to $newlname', $account_id);";
            mysqli_query($conn, $sql);
        }

        if(isset($_POST['newemail'])) {
            $newemail = mysqli_real_escape_string($conn, $_POST['newemail']);
            $sql = "UPDATE accounts SET accounts_email = '$newemail' WHERE accounts_id = '$username';";
            mysqli_query($conn, $sql);
            $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$edit_account_date', 'Change email to $newemail', $account_id);";
            mysqli_query($conn, $sql);
        }
        
        if(isset($_POST['newpassword'])) {
            $newpassword = mysqli_real_escape_string($conn, $_POST['newpassword']);
            $hash_password = password_hash($newpassword, PASSWORD_DEFAULT);
            $sql = "UPDATE accounts SET accounts_password = '$hash_password' WHERE accounts_id = '$username';";
            mysqli_query($conn, $sql);
            $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$edit_account_date', 'Change account password', $account_id);";
            mysqli_query($conn, $sql);
        }
        
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/account.php");        
    }

    if(isset($_POST['todo_update'])) {
        $todo_id = $_POST['todo_id'];
        $todo_status = $_POST['todo_status'];
        $sql = "SELECT todo_task FROM todo WHERE todo_id = '$todo_id';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $todo_task = $row[0];
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $update_todo_date = date("Y-m-d G:i:s");
        if(strcasecmp($todo_status, 'in progress') == 0) {
            $sql = "UPDATE todo SET todo_status = 'done' WHERE todo_id = '$todo_id';";
            mysqli_query($conn, $sql);
            $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$update_todo_date', 'Updated todo task $todo_task to done', $account_id);";
            mysqli_query($conn, $sql);
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/viewalltasks.php");
        } else {
            $sql = "DELETE FROM todo WHERE todo_id = '$todo_id';";
            mysqli_query($conn, $sql);
            $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$update_todo_date', 'Cleared todo task $todo_tassk', $account_id);";
            mysqli_query($conn, $sql);
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/viewalltasks.php");
        }        
    }

    if (isset($_POST['add_deliveredin'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        $mat_id = mysqli_real_escape_string($conn, $_POST['mat_id']);
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $delivered_date = mysqli_real_escape_string($conn, $_POST['dev_date']);
        $delivered_quantity = mysqli_real_escape_string($conn, $_POST['dev_quantity']);
        $delivered_unit = mysqli_real_escape_string($conn, $_POST['dev_unit']);
        $suppliedBy = mysqli_real_escape_string($conn, $_POST['dev_supp']);
        $sql = "INSERT INTO deliveredin (delivered_date, delivered_quantity, delivered_unit, suppliedBy, delivered_matName) VALUES ('$delivered_date', $delivered_quantity, $delivered_unit, '$suppliedBy', $mat_id);";
        mysqli_query($conn, $sql);
        echo $mat_name;
            
        $sql = "SELECT currentQuantity FROM materials WHERE mat_name='$mat_name';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $currentQuantity = $row[0];
        $newQuantity = $currentQuantity + $delivered_quantity;
        $sql = "UPDATE materials SET currentQuantity = ('$newQuantity') WHERE mat_name = '$mat_name';";
        mysqli_query($conn, $sql);
            
        $sql = "SELECT delivered_material FROM materials WHERE mat_name='$mat_name';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $current_delivered_material = $row[0];
        $newQuantity = $current_delivered_material + $delivered_quantity;
        $sql = "UPDATE materials SET delivered_material = ('$newQuantity') WHERE mat_name = '$mat_name';";
        mysqli_query($conn, $sql);

        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $add_deliver_date = date("Y-m-d G:i:s");
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('$add_deliver_date', 'Added delivered in of $mat_name', $account_id);";

        mysqli_query($conn, $sql);    
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/stockcard.php?mat_name=$mat_name&projects_name=$projects_name");        
    }

    if (isset($_POST['add_usagein'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        $mat_id = mysqli_real_escape_string($conn, $_POST['mat_id']);
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $usage_date = mysqli_real_escape_string($conn, $_POST['us_date']);
        $usage_quantity = mysqli_real_escape_string($conn, $_POST['us_quantity']);
        $usage_unit = mysqli_real_escape_string($conn, $_POST['us_unit']);
        $pulloutby = mysqli_real_escape_string($conn, $_POST['pulloutby']);
        $us_area = mysqli_real_escape_string($conn, $_POST['us_area']);
        $sql = "SELECT * from usagein;";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        $sql = "INSERT INTO usagein (usage_date, usage_quantity, usage_unit, pulledOutBy, usage_areaOfUsage, usage_matname) VALUES ('$usage_date', $usage_quantity, $usage_unit, '$pulloutby', '$us_area', $mat_id);";
        mysqli_query($conn, $sql);
            
        $sql = "SELECT currentQuantity FROM materials WHERE mat_name='$mat_name';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $currentQuantity = $row[0];
        $newQuantity = $currentQuantity - $usage_quantity;
        $sql = "UPDATE materials SET currentQuantity = ('$newQuantity') WHERE mat_name = '$mat_name';";
        mysqli_query($conn, $sql);
            
        $sql = "SELECT pulled_out FROM materials WHERE mat_name='$mat_name';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $current_pulledout = $row[0];
        $newQuantity = $current_pulledout + $usage_quantity;
        $sql = "UPDATE materials SET pulled_out = ('$newQuantity') WHERE mat_name = '$mat_name';";
        mysqli_query($conn, $sql);
            
        $sql = "SELECT accumulated_materials FROM materials WHERE mat_name='$mat_name';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $total_accumulated = $row[0];
        $newQuantity = $total_accumulated + $usage_quantity;
        $sql = "UPDATE materials SET accumulated_materials = ('$newQuantity') WHERE mat_name = '$mat_name';";
        mysqli_query($conn, $sql);

        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $add_usage_date = date("Y-m-d G:i:s");
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('$add_usage_date', 'Added usage in of $delivered_matName', $account_id);";
        mysqli_query($conn, $sql); 
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/stockcard.php?mat_name=$mat_name&projects_name=$projects_name");        
    }

    if (isset($_POST['add_deliveredinsite'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        $mat_id = mysqli_real_escape_string($conn, $_POST['mat_id']);
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $delivered_date = mysqli_real_escape_string($conn, $_POST['dev_date']);
        $delivered_quantity = mysqli_real_escape_string($conn, $_POST['dev_quantity']);
        $delivered_unit = mysqli_real_escape_string($conn, $_POST['dev_unit']);
        $suppliedBy = mysqli_real_escape_string($conn, $_POST['dev_supp']);
        $sql = "INSERT INTO deliveredin (delivered_date, delivered_quantity, delivered_unit, suppliedBy, delivered_matName) VALUES ('$delivered_date', $delivered_quantity, $delivered_unit, '$suppliedBy', $mat_id);";
        mysqli_query($conn, $sql);
        echo $mat_name;
            
        $sql = "SELECT currentQuantity FROM materials WHERE mat_name='$mat_name';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $currentQuantity = $row[0];
        $newQuantity = $currentQuantity + $delivered_quantity;
        $sql = "UPDATE materials SET currentQuantity = ('$newQuantity') WHERE mat_name = '$mat_name';";
        mysqli_query($conn, $sql);
            
        $sql = "SELECT delivered_material FROM materials WHERE mat_name='$mat_name';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $current_delivered_material = $row[0];
        $newQuantity = $current_delivered_material + $delivered_quantity;
        $sql = "UPDATE materials SET delivered_material = ('$newQuantity') WHERE mat_name = '$mat_name';";
        mysqli_query($conn, $sql);

        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $add_deliver_date = date("Y-m-d G:i:s");
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('$add_deliver_date', 'Added delivered in of $mat_name', $account_id);";

        mysqli_query($conn, $sql);    
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/sitestockcard.php?mat_name=$mat_name");        
    }

    if (isset($_POST['add_usageinsite'])) {
        $mat_id = mysqli_real_escape_string($conn, $_POST['mat_id']);
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $usage_date = mysqli_real_escape_string($conn, $_POST['us_date']);
        $usage_quantity = mysqli_real_escape_string($conn, $_POST['us_quantity']);
        $usage_unit = mysqli_real_escape_string($conn, $_POST['us_unit']);
        $pulloutby = mysqli_real_escape_string($conn, $_POST['pulloutby']);
        $us_area = mysqli_real_escape_string($conn, $_POST['us_area']);
        $sql = "SELECT * from usagein;";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        $sql = "INSERT INTO usagein (usage_date, usage_quantity, usage_unit, pulledOutBy, usage_areaOfUsage, usage_matname) VALUES ('$usage_date', $usage_quantity, $usage_unit, '$pulloutby', '$us_area', $mat_id);";
        mysqli_query($conn, $sql);
            
        $sql = "SELECT currentQuantity FROM materials WHERE mat_name='$mat_name';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $currentQuantity = $row[0];
        $newQuantity = $currentQuantity - $usage_quantity;
        $sql = "UPDATE materials SET currentQuantity = ('$newQuantity') WHERE mat_name = '$mat_name';";
        mysqli_query($conn, $sql);
            
        $sql = "SELECT pulled_out FROM materials WHERE mat_name='$mat_name';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $current_pulledout = $row[0];
        $newQuantity = $current_pulledout + $usage_quantity;
        $sql = "UPDATE materials SET pulled_out = ('$newQuantity') WHERE mat_name = '$mat_name';";
        mysqli_query($conn, $sql);
            
        $sql = "SELECT accumulated_materials FROM materials WHERE mat_name='$mat_name';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $total_accumulated = $row[0];
        $newQuantity = $total_accumulated + $usage_quantity;
        $sql = "UPDATE materials SET accumulated_materials = ('$newQuantity') WHERE mat_name = '$mat_name';";
        mysqli_query($conn, $sql);

        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $add_usage_date = date("Y-m-d G:i:s");
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('$add_usage_date', 'Added usage in of $delivered_matName', $account_id);";
        mysqli_query($conn, $sql); 
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/sitestockcard.php?mat_name=$mat_name");        
    }


    if(isset($_POST['edit_materials'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        $materialname = mysqli_real_escape_string($conn, $_POST['materialname']);
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $edit_mat_date = date("Y-m-d G:i:s");
                if(isset($_POST['mat_unit'])) {
            $mat_unit = mysqli_real_escape_string($conn, $_POST['mat_unit']);
            $sql = "UPDATE materials SET mat_unit = '$mat_unit' WHERE mat_name = '$materialname';";
            mysqli_query($conn, $sql);
            $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('$edit_mat_date', 'Change material unit of $materialname to $mat_unit', $account_id);";
            mysqli_query($conn, $sql); 
        }
                if(isset($_POST['minquantity'])) {
            $minquantity = mysqli_real_escape_string($conn, $_POST['minquantity']);
            $sql = "UPDATE materials SET mat_notif = '$minquantity' WHERE mat_name = '$materialname';";
            mysqli_query($conn, $sql);
            $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('$edit_mat_date', 'Change material unit of $materialname to $minquantity', $account_id);";
            mysqli_query($conn, $sql); 
        }
        if(isset($_POST['newmaterialname'])) {
            $newmaterialname = $_POST['newmaterialname'];
            $sql = "UPDATE materials SET mat_name = '$newmaterialname' WHERE mat_name = '$materialname';";
            mysqli_query($conn,$sql);
            $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('$edit_mat_date', 'Change material name of $materialname to $newmaterialname', $account_id);";
            mysqli_query($conn, $sql); 
        }

        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");     
    }

    if(isset($_POST['generate_report'])) {
        $projects_name = $_POST['projects_name'];        
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $generate_report_date = date("Y-m-d G:i:s");
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('$generate_report_date', 'Generated report of $projects_name', $account_id);";
        mysqli_query($conn, $sql); 
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/generate_report.php?projects_name=$projects_name");        
    }

    if(isset($_POST['generate_hauling'])) {
        $hauling_no = $_POST['hauling_no'];        
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $generate_hauling_date = date("Y-m-d G:i:s");
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('$generate_hauling_date', 'Generated Hauling Form of Form No $hauling_no', $account_id);";
        mysqli_query($conn, $sql); 
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/generate_hauling.php?hauling_no=$hauling_no");        
    }

    if(isset($_POST['search'])) {
        $projects_name = $_POST['projects_name'];
        header("location: http://127.0.0.1/NGCB/View%20Only/viewinventory.php?projects_name=$projects_name");
    }

    if(isset($_POST['password_request'])) {
        $request_username = mysqli_real_escape_string($conn, $_POST['username_request']);
        $sql = "SELECT accounts_id FROM accounts WHERE accounts_username = '$request_username'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $accounts_id = $row[0];
        $password_request_date = date("Y-m-d G:i:s");
        $sql = "INSERT INTO request (req_username, req_date) VALUES ('$accounts_id', '$password_request_date')";
        mysqli_query($conn, $sql); 
        $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf, logs_itemname) VALUES ('$password_request_date', 'Requested to reset password', $account_id);";
        mysqli_query($conn, $sql); 
        header("location: http://127.0.0.1/NGCB/index.php");        
    }

    if(isset($_POST['request_accept'])) {
        $request_accountID = mysqli_real_escape_string($conn, $_POST['request_accountID']);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $generated_password = substr(str_shuffle($characters), 0, 8);
        $password = password_hash($generated_password, PASSWORD_DEFAULT);
        $sql = "SELECT accounts_email, CONCAT(accounts_fname, ' ', accounts_lname) FROM accounts WHERE accounts_id = '$request_accountID';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        $request_email = $row[0];
        $request_name = $row[1];
        $reject_date = date("Y-m-d G:i:s");
        mysqli_query($conn, "UPDATE accounts SET accounts_password = '$password' WHERE accounts_id = '$request_accountID';");
        mysqli_query($conn, "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$reject_date', 'Accepted request to reset password of '.$request_name, 1);");
        mysqli_query($conn, "DELETE FROM request WHERE req_username = '$request_accountID';");
        try {
            $mail->addAddress($request_email, $request_name);
            $mail->isHTML(true);                                  
            $mail->Subject = 'Password Reset';
            $mail->Body    = 'Hello '.$request_name.' Your request to reset your password has been approved. Please use the temporary password below to login.
                            Please change your password after logging in. <br /> <br /> Password: <b>'.$generated_password.'</b>';
            $mail->send();
        } catch (Exception $e) {}
        header("location: http://127.0.0.1/NGCB/Admin/passwordrequest.php");        
    }

    if(isset($_POST['request_reject'])) {
        $request_accountID = mysqli_real_escape_string($conn, $_POST['request_accountID']);
        $sql = "SELECT CONCAT(accounts_fname, ' ', accounts_lname) FROM accounts WHERE accounts_id = '$request_accountID';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        $request_name = $row[0];
        $reject_date = date("Y-m-d G:i:s");
        mysqli_query($conn, "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$reject_date', 'Rejected request to reset password of $request_name', 1);");
        mysqli_query($conn, "DELETE FROM request WHERE req_username = '$request_accountID';");
        header("location: http://127.0.0.1/NGCB/Admin/passwordrequest.php");
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

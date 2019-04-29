<?php
    include "db_connection.php";
    include "smtp_connection.php";
    
    if (isset($_POST['login'])) {
        session_start();
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']); 
        $stmt = $conn->prepare("SELECT accounts_id, accounts_password, accounts_type FROM accounts WHERE accounts_username = ? AND accounts_status ='active';");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($accounts_id, $accounts_password, $accounts_type);
        $stmt->fetch();
        if(password_verify($password, $accounts_password)) {
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
        $account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
        $stmt = $conn->prepare("SELECT accounts_id from accounts WHERE accounts_username = ?;");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 0) {
            try {
                $stmt->close();
                $stmt = $conn->prepare("INSERT INTO accounts (accounts_fname, accounts_lname, accounts_username, accounts_password, accounts_type, accounts_email, accounts_deletable, accounts_status)
                VALUES (?, ?, ?, ?, ?, ?, 'yes', 'active')");
                $stmt->bind_param("ssssss", $firstname, $lastname, $username, $password, $account_type, $email);
                $stmt->execute();
                $full_name = $firstname." ".$lastname;
                $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
                $stmt->bind_param("ssi", $create_date, $logs_message, $logs_of);
                $create_date = date("Y-m-d G:i:s");
                $logs_message = 'Created account of '.$full_name;
                $logs_of = 1;
                $stmt->execute();
                $stmt->close();
                $mail->addAddress($email, $firstname.' '.$lastname);                
                $mail->isHTML(true);                                  
                $mail->Subject = 'Welcome to your NGCBDC Inventory System Account!';
                $mail->Body    = 'Your account has been created. <br /> Please change your password after logging in. <br /> <br /> Username: <b>'.$username.'</b> <br /> Password: <b>'.$generated_password.'</b>';
                $mail->send();
            } catch (Exception $e) {}
        } 
        header("Location: http://127.0.0.1/NGCB/Admin/listofaccounts.php");
    }
    
    if (isset($_POST['create_project'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projectname']);
        $projects_address = mysqli_real_escape_string($conn, $_POST['projectaddress']);
		$start_date = mysqli_real_escape_string($conn, $_POST['startdate']);
        $end_date = mysqli_real_escape_string($conn, $_POST['enddate']);
        $mateng = mysqli_real_escape_string($conn, $_POST['mateng']);
        if(strtotime($start_date) == strtotime($end_date)) {
            header("Location: http://127.0.0.1/NGCB/Admin/projects.php");      
        }
        $stmt = $conn->prepare("SELECT projects_name FROM projects WHERE projects_name = ?;");
        $stmt->bind_param("s", $projects_name);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO projects (projects_name, projects_address, projects_sdate, projects_edate, projects_status)
                    VALUES (?, ?, ?, ?, ?);");
            $stmt->bind_param("sssss", $projects_name, $projects_address, $start_date, $end_date, $projects_status);
            $projects_status = "open";
            $stmt->execute();
            $stmt->close();
            
            $stmt = $conn->prepare("SELECT projects_id FROM projects WHERE projects_name = ?;");
            $stmt->bind_param("s", $projects_name);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($account_id);
            $stmt->fetch();
            
            
            
             $stmt = $conn->prepare("INSERT INTO projacc (projacc_project, projacc_mateng)
                    VALUES (?, ?);");
            $stmt->bind_param("ii", $account_id, $mateng);
            $stmt->execute();
            $stmt->close();
            
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
            $stmt->bind_param("ssi", $create_proj_date, $logs_message, $logs_of);
            $create_proj_date = date("Y-m-d G:i:s");
            $logs_message = 'Created project '.$projects_name;
            $logs_of = 1;
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

            $new_project_name = mysqli_real_escape_string($conn, $_POST['new_project_name']);
            $new_address = mysqli_real_escape_string($conn, $_POST['new_address']);
            $new_sdate = mysqli_real_escape_string($conn, $_POST['new_sdate']);
            $new_edate = mysqli_real_escape_string($conn, $_POST['new_edate']);

            if(!strcmp($new_address, null) == 0) {
                $stmt1 = $conn->prepare("UPDATE projects SET projects_address = ? WHERE projects_name = ?");
                $stmt1->bind_param("ss", $new_address, $projects_name);
                $stmt1->execute();
                $stmt1->close();
            }

            if(!strcmp($new_sdate, null) == 0) {
                $stmt2 = $conn->prepare("UPDATE projects SET projects_sdate = ? WHERE projects_name = ?");
                $stmt2->bind_param("ss", $new_sdate, $projects_name);
                $stmt2->execute();
                $stmt2->close();
            }

            if(!strcmp($new_edate, null) == 0) {
                $stmt3 = $conn->prepare("UPDATE projects SET projects_edate = ? WHERE projects_name = ?");
                $stmt3->bind_param("ss", $new_edate, $projects_name);
                $stmt3->execute();
                $stmt3->close();
            } 

            if(!strcmp($new_project_name, null) == 0) {
                $stmt = $conn->prepare("UPDATE projects SET projects_name = ? WHERE projects_name = ?");
                $stmt->bind_param("ss", $new_project_name, $projects_name);
                $stmt->execute();
                $stmt->close();
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

    if(isset($_POST['backsite-view-only'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");            
    }

    if(isset($_POST['backsite-mat-eng'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");            
    }

    if(isset($_POST['backsitestockcard-view-only'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
            header("location: http://127.0.0.1/NGCB/View%20Only/sitematerials.php?projects_name=$projects_name");            
    }

    if(isset($_POST['ok-account-creation'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
            header("location: http://127.0.0.1/NGCB/Admin/listofaccounts.php");            
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

    if(isset($_POST['view_open_stockcard'])) {
        $view_from = $_POST['view_from'];
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        if(strcmp($view_from, "projects" ) == 0) {
            header("location: http://127.0.0.1/NGCB/View%20Only/stockcard.php?mat_name=$mat_name&projects_name=$projects_name");
        } else if (strcmp($view_from, "categories" ) == 0) {
            header("location: http://127.0.0.1/NGCB/View%20Only/stockcard.php?mat_name=$mat_name&projects_name=$projects_name");
        }else {
            header("location: http://127.0.0.1/NGCB/View%20Only/sitestockcard.php?mat_name=$mat_name");
        }
    }

    if(isset($_POST['open_sitestockcard'])) {
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $mat_id = mysqli_real_escape_string($conn, $_POST['mat_id']);
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/sitestockcard.php?mat_name=$mat_name&mat_id=$mat_id");
    }
    
    if(isset($_POST['open_report'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/reportpage.php?projects_name=$projects_name");        
    }

    if(isset($_POST['update_account_status'])) {
        $accounts_id = mysqli_real_escape_string($conn, $_POST['accounts_id']);
        $sql = "SELECT CONCAT(accounts_fname, ' ', accounts_lname), accounts_status FROM accounts WHERE accounts_id = '$accounts_id';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $accounts_name = $row[0];
        $accounts_status = $row[1];
        $update_date = date("Y-m-d G:i:s");
        if(strcmp($accounts_status, "disabled") == 0) {
            $sql = "UPDATE accounts SET accounts_status = 'active' WHERE accounts_id = $accounts_id;";
            mysqli_query($conn, $sql);
            $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$update_date', 'Enabled account of $accounts_name', 1);";
            mysqli_query($conn, $sql);
        } else {
            $sql = "UPDATE accounts SET accounts_status = 'disabled' WHERE accounts_id = $accounts_id;";
            mysqli_query($conn, $sql);
            $sql = "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$update_date', 'Disabled account of $accounts_name', 1);";
            mysqli_query($conn, $sql);
        }
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
        $hauling_requested = mysqli_real_escape_string($conn, $_POST['requested']);
        $hauling_warehouseman = mysqli_real_escape_string($conn, $_POST['warehouseman']);
        $hauling_approvedBy = mysqli_real_escape_string($conn, $_POST['approvedby']);
        $hauling_truckDetailsType = mysqli_real_escape_string($conn, $_POST['truck_type']);
        $hauling_truckDetailsPlateNo = mysqli_real_escape_string($conn, $_POST['truck_plate']);
        $hauling_truckDetailsPo = mysqli_real_escape_string($conn, $_POST['truck_po']);
        $hauling_truckDetailsHaulerDr = mysqli_real_escape_string($conn, $_POST['truck_hauler']);

        $row = mysqli_fetch_row(mysqli_query($conn, "SELECT unit_id FROM unit WHERE unit_name = '$hauling_unit';"));
        $hauling_unit = $row[0];

        $stmt = $conn->prepare("INSERT INTO hauling (hauling_no, hauling_date, hauling_deliverTo, hauling_hauledFrom, hauling_quantity, 
        hauling_unit, hauling_matname, hauling_hauledBy, hauling_requestedBy, hauling_warehouseman, hauling_approvedBy, hauling_truckDetailsType, 
        hauling_truckDetailsPlateNo, hauling_truckDetailsPo, hauling_truckDetailsHaulerDr)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("isssiiissssssss", $hauling_no, $hauling_date, $hauling_deliverTo, $hauling_hauledFrom, $hauling_quantity, 
        $hauling_unit, $hauling_matname, $hauling_hauledBy, $hauling_requested, $hauling_warehouseman, $hauling_approvedBy, $hauling_truckDetailsType, 
        $hauling_truckDetailsPlateNo, $hauling_truckDetailsPo, $hauling_truckDetailsHaulerDr);
        $stmt->execute();
        $stmt->close();
        echo $hauling_unit;

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
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $create_haul_date, $logs_message, $logs_of);
        $create_haul_date = date("Y-m-d G:i:s");
        $logs_message = 'Added Hauling No. '.$hauling_no;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/hauleditems.php");        
    }

    if(isset($_POST['create_category'])) {
        $category_name = $_POST['category_name'];
        $projects_name = $_POST['projects_name'];
        $stmt = $conn->prepare("SELECT categories_name FROM categories WHERE categories_name = ?");
        $stmt->bind_param("s", $category_name);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 0) {
            $stmt = $conn->prepare("SELECT projects_id FROM projects WHERE projects_name = ?");
            $stmt->bind_param("s", $projects_name);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($projects_id);
            $stmt->fetch();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO categories (categories_name, categories_project) VALUES (?, ?);");
            $stmt->bind_param("si", $category_name, $projects_id);
            $stmt->execute();
            $stmt->close();
            session_start();
            $account_id = "";
            if(isset($_SESSION['account_id'])) {
                $account_id = $_SESSION['account_id'];
            }
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $create_categ_date, $logs_message, $logs_of);
            $create_categ_date = date("Y-m-d G:i:s");
            $logs_message = 'Created category '.$category_name;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
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
        if($stmt->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE categories SET categories_name = ? WHERE categories_name = ?;");
            $stmt->bind_param("ss", $new_category_name, $category_name);
            $stmt->execute();
            $stmt->close();
            session_start();
            $account_id = "";
            if(isset($_SESSION['account_id'])) {
                $account_id = $_SESSION['account_id'];
            }
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $create_categ_date, $logs_message, $logs_of);
            $edit_categ_date = date("Y-m-d G:i:s");
            $logs_message = 'Edited category '.$category_name;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");
    }

    if(isset($_POST['create_unit'])) {
        $unit_name = $_POST['unit_name'];
        $projects_name = $_POST['projects_name'];
        $stmt = $conn->prepare("SELECT unit_name FROM unit WHERE unit_name = ?");
        $stmt->bind_param("s", $category_name);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 0) {
            $stmt = $conn->prepare("SELECT projects_id FROM projects WHERE projects_name = ?");
            $stmt->bind_param("s", $projects_name);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($projects_id);
            $stmt->fetch();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO unit (unit_name) VALUES (?);");
            $stmt->bind_param("s", $unit_name);
            $stmt->execute();
            $stmt->close();
            session_start();
            $account_id = "";
            if(isset($_SESSION['account_id'])) {
                $account_id = $_SESSION['account_id'];
            }
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $create_categ_date, $logs_message, $logs_of);
            $create_categ_date = date("Y-m-d G:i:s");
            $logs_message = 'Created category '.$category_name;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");        
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
        $logs_message = 'Created todo task';
        $logs_of = $account_id;
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $create_todo_date, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/dashboard.php");        
    }

    if (isset($_POST['create_materials'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        $projects_id = mysqli_real_escape_string($conn, $_POST['projects_id']);
        $mat_name = str_replace("\\", '', mysqli_real_escape_string($conn, $_POST['mat_name']));
        $mat_unit = mysqli_real_escape_string($conn, $_POST['mat_unit']);
        $mat_categ = mysqli_real_escape_string($conn, $_POST['mat_categ']);
        $mat_notif = mysqli_real_escape_string($conn, $_POST['mat_notif']);
        $stmt = $conn->prepare("SELECT projects_id FROM projects WHERE projects_name = ?");
        $stmt->bind_param("s", $projects_name);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mat_project);
        $stmt->fetch();
        $stmt = $conn->prepare("INSERT INTO materials
        (mat_name, mat_prevStock, mat_project, mat_unit, mat_categ, mat_notif, currentQuantity) 
        VALUES (?, ?, ?, ?, ?, ?, 0);");
        $stmt->bind_param("siiiii", $mat_name, $mat_prevStock, $projects_id,  $mat_unit, $mat_categ, $mat_notif);
        $mat_prevStock = 0;
        $stmt->execute();
        $stmt->close();
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $create_categ_date, $logs_message, $logs_of);
        $create_mat_date = date("Y-m-d G:i:s");
        $logs_message = 'Created material '.$mat_name;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");        
    }

    if(isset($_POST['edit_account'])) {
        $username = mysqli_real_escape_string($conn, $_POST['userid']);
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $edit_account_date = date("Y-m-d G:i:s");
        if(isset($_POST['newusername']) && $_POST['newusername'] != null) {
            $newusername = $_POST['newusername'];
            $stmt = $conn->prepare("UPDATE accounts SET accounts_username = ? WHERE accounts_id = ?;");
            $stmt->bind_param("si", $newusername, $account_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change account username to '.$newusername;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
            $_SESSION['username'] = $newusername; 
        }
        if(isset($_POST['newfname']) && $_POST['newfname'] != null) {
            $newfname = mysqli_real_escape_string($conn, $_POST['newfname']);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_fname = ? WHERE accounts_id = ?;");
            $stmt->bind_param("si", $newfname, $account_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change first name to '.$account_id;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }

        if(isset($_POST['newlname']) && $_POST['newlname'] != null) {
            $newlname = mysqli_real_escape_string($conn, $_POST['newlname']);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_lname = ? WHERE accounts_id = ?;");
            $stmt->bind_param("si", $newlname, $account_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change last name to '.$newlname;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }

        if(isset($_POST['newemail']) && $_POST['newemail'] != null) {
            $newemail = mysqli_real_escape_string($conn, $_POST['newemail']);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_email = ? WHERE accounts_id = ?;");
            $stmt->bind_param("si", $newemail, $account_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change email to '.$newemail;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        
        if(isset($_POST['newpassword']) && $_POST['newpassword'] != null) {
            $newpassword = mysqli_real_escape_string($conn, $_POST['newpassword']);
            $hash_password = password_hash($newpassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_password = ? WHERE accounts_id = ?;");
            $stmt->bind_param("si", $hash_password, $account_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change account password ';
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/account.php");        
    }

    if(isset($_POST['todo_update'])) {
        $todo_id = $_POST['todo_id'];
        $todo_status = $_POST['todo_status'];
        $update_from = $_POST['update_from'];
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
            $stmt = $conn->prepare("UPDATE todo SET todo_status = 'done' WHERE todo_id = ?;");
            $stmt->bind_param("i", $todo_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $update_todo_date, $logs_message, $logs_of);
            $logs_message = 'Updated todo task '.$todo_task.' to done';
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        } else {
            $stmt = $conn->prepare("DELETE FROM todo WHERE todo_id = ?;");
            $stmt->bind_param("i", $todo_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $update_todo_date, $logs_message, $logs_of);
            $logs_message = 'Cleared todo task '.$todo_tassk;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        if(strcasecmp($update_from, 'dashboard') == 0) {   
            header("location: http://127.0.0.1/NGCB/Materials%20Engineer/dashboard.php");  
        } else {
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
        $stmt = $conn->prepare("INSERT INTO deliveredin (delivered_date, delivered_quantity, delivered_unit, suppliedBy, delivered_matName) VALUES (?, ?, ?, ?, ?);");
        $stmt->bind_param("siisi", $delivered_date, $delivered_quantity, $delivered_unit, $suppliedBy, $mat_id);
        $stmt->execute();
        $stmt->close();
            
        $stmt = $conn->prepare("SELECT currentQuantity FROM materials WHERE mat_name = ?;");
        $stmt->bind_param("s", $mat_name);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($currentQuantity);
        $stmt->fetch();
        $newQuantity = $currentQuantity + $delivered_quantity;
        $stmt->close();
        $stmt = $conn->prepare("UPDATE materials SET currentQuantity = ? WHERE mat_name = ?;");
        $stmt->bind_param("is", $newQuantity, $mat_name);
        $stmt->execute();
        $stmt->close();

        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $add_deliver_date = date("Y-m-d G:i:s");
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $add_deliver_date, $logs_message, $logs_of);
        $logs_message = 'Added delivered in of '.$mat_name;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/stockcard.php?mat_name=$mat_name&projects_name=$projects_name");        
    }

    if (isset($_POST['add_deliveredinsite'])) {
        $mat_id = mysqli_real_escape_string($conn, $_POST['mat_id']);
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $delivered_date = mysqli_real_escape_string($conn, $_POST['dev_date']);
        $delivered_quantity = mysqli_real_escape_string($conn, $_POST['dev_quantity']);
        $delivered_unit = mysqli_real_escape_string($conn, $_POST['dev_unit']);
        $suppliedBy = mysqli_real_escape_string($conn, $_POST['dev_supp']);
        $stmt = $conn->prepare("INSERT INTO deliveredin (delivered_date, delivered_quantity, delivered_unit, suppliedBy, delivered_matName) VALUES (?, ?, ?, ?, ?);");
        $stmt->bind_param("siisi", $delivered_date, $delivered_quantity, $delivered_unit, $suppliedBy, $mat_id);
        $stmt->execute();
        $stmt->close();
            
        $stmt = $conn->prepare("SELECT currentQuantity FROM materials WHERE mat_name = ?;");
        $stmt->bind_param("s", $mat_name);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($currentQuantity);
        $stmt->fetch();
        $newQuantity = $currentQuantity + $delivered_quantity;
        $stmt->close();
        $stmt = $conn->prepare("UPDATE materials SET currentQuantity = ? WHERE mat_name = ?;");
        $stmt->bind_param("is", $newQuantity, $mat_name);
        $stmt->execute();
        $stmt->close();

        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $add_deliver_date = date("Y-m-d G:i:s");
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $add_deliver_date, $logs_message, $logs_of);
        $logs_message = 'Added delivered in of '.$mat_name;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/sitestockcard.php?mat_name=$mat_name&mat_id=$mat_id");        
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
        $update_from = $_POST['update_from'];
        $stmt = $conn->prepare("INSERT INTO usagein (usage_date, usage_quantity, usage_unit, pulledOutBy, usage_areaOfUsage, usage_matname) VALUES (?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("siissi", $usage_date, $usage_quantity, $usage_unit, $pulloutby, $us_area, $mat_id);
        $stmt->execute();
        $stmt->close();
        
        $stmt = $conn->prepare("SELECT currentQuantity FROM materials WHERE mat_name=' ?';");
        $stmt->bind_param("s", $mat_name);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($currentQuantity);
        $stmt->fetch();
        $newQuantity = $currentQuantity - $usage_quantity;
        $stmt->close();
        $stmt = $conn->prepare("UPDATE materials SET currentQuantity = ? WHERE mat_name = ?;");
        $stmt->bind_param("is", $newQuantity, $mat_name);
        $stmt->execute();
        $stmt->close();

        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $add_usage_date = date("Y-m-d G:i:s");        
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $add_usage_date, $logs_message, $logs_of);
        $logs_message = 'Added usage in of '.$mat_name;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
            header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/stockcard.php?mat_name=$mat_name&projects_name=$projects_name");
    }

    if (isset($_POST['add_usageinsite'])) {
        $mat_id = mysqli_real_escape_string($conn, $_POST['mat_id']);
        $mat_name = mysqli_real_escape_string($conn, $_POST['mat_name']);
        $usage_date = mysqli_real_escape_string($conn, $_POST['us_date']);
        $usage_quantity = mysqli_real_escape_string($conn, $_POST['us_quantity']);
        $usage_unit = mysqli_real_escape_string($conn, $_POST['us_unit']);
        $pulloutby = mysqli_real_escape_string($conn, $_POST['pulloutby']);
        $us_area = mysqli_real_escape_string($conn, $_POST['us_area']);
        $update_from = $_POST['update_from'];
        $stmt = $conn->prepare("INSERT INTO usagein (usage_date, usage_quantity, usage_unit, pulledOutBy, usage_areaOfUsage, usage_matname) VALUES (?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("siissi", $usage_date, $usage_quantity, $usage_unit, $pulloutby, $us_area, $mat_id);
        $stmt->execute();
        $stmt->close();
        
        $stmt = $conn->prepare("SELECT currentQuantity FROM materials WHERE mat_name=' ?';");
        $stmt->bind_param("s", $mat_name);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($currentQuantity);
        $stmt->fetch();
        $newQuantity = $currentQuantity - $usage_quantity;
        $stmt->close();
        $stmt = $conn->prepare("UPDATE materials SET currentQuantity = ? WHERE mat_name = ?;");
        $stmt->bind_param("is", $newQuantity, $mat_name);
        $stmt->execute();
        $stmt->close();

        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $add_usage_date = date("Y-m-d G:i:s");        
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $add_usage_date, $logs_message, $logs_of);
        $logs_message = 'Added usage in of '.$mat_name;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
            header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/sitestockcard.php?mat_name=$mat_name&mat_id=$mat_id");
    }

    if(isset($_POST['edit_materials'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        $materialname = urldecode(mysqli_real_escape_string($conn, $_POST['materialname']));
        $update_from = $_POST['update_from'];   
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        echo $materialname;
        $edit_mat_date = date("Y-m-d G:i:s");
        if(isset($_POST['mat_unit'])) {
            $mat_unit = mysqli_real_escape_string($conn, $_POST['mat_unit']);
            $stmt = $conn->prepare("UPDATE materials SET mat_unit = ? WHERE mat_name = ?;");
            $stmt->bind_param("is", $mat_unit, $materialname);
            $stmt->execute();
            $stmt->close(); 
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_mat_date, $logs_message, $logs_of);
            $logs_message = 'Change material unit of '.$materialname.' to '.$mat_unit;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        if(isset($_POST['minquantity'])) {
            $minquantity = mysqli_real_escape_string($conn, $_POST['minquantity']);            
            $stmt = $conn->prepare("UPDATE materials SET mat_notif = ? WHERE mat_name = ?;");
            $stmt->bind_param("is", $minquantity, $materialname);
            $stmt->execute();
            $stmt->close(); 
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_mat_date, $logs_message, $logs_of);
            $logs_message = 'Change minimum quantity of '.$materialname.' to '.$minquantity;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        if(isset($_POST['newmaterialname'])) {
            $newmaterialname = $_POST['newmaterialname'];
            $stmt = $conn->prepare("UPDATE materials SET mat_name = ? WHERE mat_name = ?;");
            $stmt->bind_param("ss", $newmaterialname, $materialname);
            $stmt->execute();
            $stmt->close(); 
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_mat_date, $logs_message, $logs_of);
            $logs_message = 'Change material name of '.$materialname.' to '.$newmaterialname;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        if(strcasecmp($update_from, 'stockcard') == 0) {   
            header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/viewinventory.php?projects_name=$projects_name");   
        } else {
            header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/sitematerials.php");     
        }         
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
        $stmt = $conn->prepare("SELECT accounts_id FROM accounts WHERE accounts_username = ?");
        $stmt->bind_param("s", $request_username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($accounts_id);
        $stmt->fetch();
        $stmt->close();
        $stmt = $conn->prepare("SELECT * FROM request WHERE req_username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 0) {
            $stmt->close();
            $password_request_date = date("Y-m-d");
            $stmt = $conn->prepare("INSERT INTO request (req_username, req_date) VALUES (?, ?)");
            $stmt->bind_param("is", $accounts_id, $password_request_date);
            $stmt->execute();
            $stmt->close();
            $password_request_date_logs = date("Y-m-d G:i:s");
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $password_request_date_logs, $logs_message, $logs_of);
            $logs_message = 'Requested to reset password';
            $logs_of = $accounts_id;
            $stmt->execute();
        }
        $stmt->close();
        header("location: http://127.0.0.1/NGCB/index.php");        
    }

    if(isset($_POST['request_accept'])) {
        $request_accountID = mysqli_real_escape_string($conn, $_POST['request_accountID']);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $generated_password = substr(str_shuffle($characters), 0, 8);
        $password = password_hash($generated_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("SELECT accounts_email, CONCAT(accounts_fname, ' ', accounts_lname) FROM accounts WHERE accounts_id = ?;");
        $stmt->bind_param("i", $request_accountID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($request_email, $request_name); 
        $stmt->fetch();
        $stmt->close();
        $accept_date = date("Y-m-d G:i:s");
        $stmt = $conn->prepare("UPDATE accounts SET accounts_password = ? WHERE accounts_id = ?;");
        $stmt->bind_param("si", $password, $request_accountID);
        $stmt->execute();
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $accept_date, $logs_message, $logs_of);
        $logs_message = 'Accepted request to reset password of '.$request_name;
        $logs_of = 1;
        $stmt->execute();
        $stmt->close();
        $stmt = $conn->prepare("DELETE FROM request WHERE req_username = ?;");
        $stmt->bind_param("i", $request_accountID);
        $stmt->execute();
        $stmt->close();
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

    if(isset($_POST['delete_project'])) {
        $project_name = $_POST['project_name'];
        mysqli_query($conn, "DELETE FROM projects WHERE projects_name = '$project_name';");
        header("location: http://127.0.0.1/NGCB/Admin/projects.php");
    }

    if(isset($_POST['request_reject'])) {
        $request_accountID = mysqli_real_escape_string($conn, $_POST['request_accountID']);
        $stmt = $conn->prepare("SELECT CONCAT(accounts_fname, ' ', accounts_lname) FROM accounts WHERE accounts_id = ?;");
        $stmt->bind_param("i", $request_accountID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($request_name);
        $stmt->fetch();
        $reject_date = date("Y-m-d G:i:s");        
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $reject_date, $logs_message, $logs_of);
        $logs_message = 'Rejected request to reset password of '.$request_name;
        $logs_of = 1;
        $stmt->execute();
        $stmt->close();
        $stmt = $conn->prepare("DELETE FROM request WHERE req_username = ?;");
        $stmt->bind_param("i", $request_accountID);
        $stmt->execute();
        $stmt->close();
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
        $sql = "SELECT unit.unit_name FROM materials INNER JOIN unit ON materials.mat_unit = unit.unit_id WHERE mat_id = '$name'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_all($result);
        echo json_encode($row);
    }

?>

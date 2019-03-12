<?php
    include "db_connection.php";
  
    
    if (isset($_POST['login'])) {
        session_start();
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']); 
        $sql = "SELECT accounts_username FROM accounts WHERE accounts_username = '$username'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $hash_password = $row[0];
        echo $hash_password;
        if(
            true
//            password_verify($password, $hash_password)
        ) {
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
            header("Location: http://127.0.0.1/NGCB/Materials%20Engineer/loginpage.php");
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
        $projects_name = mysqli_real_escape_string($conn, $_POST['project_name']);
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

    if(isset($_POST['view_category'])) {
        $categories_id = mysqli_real_escape_string($conn, $_POST['categories_id']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/itemcategories.php?categories_id=$categories_id");
    }

    if(isset($_POST['view_hauled'])) {
        $hauling_no = mysqli_real_escape_string($conn, $_POST['hauling_no']);
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/open%20hauling.php?hauling_no=$hauling_no");
    }

    if (isset($_POST['create_hauling'])) {
        $hauling_no = mysqli_real_escape_string($conn, $_POST['hauling_no']);
        $hauling_date = mysqli_real_escape_string($conn, $_POST['hauling_date']);
		$hauling_deliverTo = mysqli_real_escape_string($conn, $_POST['hauling_deliverTo']);
        $hauling_hauledFrom = mysqli_real_escape_string($conn, $_POST['hauling_hauledFrom']);
        $hauling_quantity = mysqli_real_escape_string($conn, $_POST['hauling_quantity']);
        $hauling_unit = mysqli_real_escape_string($conn, $_POST['hauling_unit']);
        $hauling_matname = mysqli_real_escape_string($conn, $_POST['hauling_matname']);
        $hauling_hauledBy = mysqli_real_escape_string($conn, $_POST['hauling_hauledBy']);
        $hauling_warehouseman = mysqli_real_escape_string($conn, $_POST['hauling_warehouseman']);
        $hauling_approvedBy = mysqli_real_escape_string($conn, $_POST['hauling_approvedBy']);
        $hauling_truckDetailsType = mysqli_real_escape_string($conn, $_POST['hauling_truckDetailsType']);
        $hauling_truckDetailsPlateNo = mysqli_real_escape_string($conn, $_POST['hauling_truckDetailsPlateNo']);
        $hauling_truckDetailsPo = mysqli_real_escape_string($conn, $_POST['hauling_truckDetailsPo']);
        $hauling_truckDetailsHaulerDr = mysqli_real_escape_string($conn, $_POST['hauling_truckDetailsHaulerDr']);
        
        $sql = "SELECT hauling_no from hauling where hauling_no = '$hauling_no';";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        if($count != 1) {
            $sql = "INSERT INTO hauling (hauling_no, hauling_date, hauling_deliverTo, hauling_hauledFrom, hauling_quantity, hauling_unit, hauling_matname, hauling_hauledBy, hauling_warehouseman, hauling_approvedBy, hauling_truckDetailsType, hauling_truckDetailsPlateNo, hauling_truckDetailsPo, hauling_truckDetailsHaulerDr)
                    VALUES ($hauling_no, $hauling_date, $hauling_deliverTo, $hauling_hauledFrom, $hauling_quantity, $hauling_unit, $hauling_matname, $hauling_hauledBy, $hauling_warehouseman, $hauling_approvedBy, $hauling_truckDetailsType, $hauling_truckDetailsPlateNo, $hauling_truckDetailsPo, $hauling_truckDetailsHaulerDr)";
            mysqli_query($conn, $sql);
            header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/hauled%20items.php");
            exit();
        }
    }

    if(isset($_POST['create_category'])) {
        $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
        $sql = "SELECT categories_name FROM categories WHERE categories_name = '$category_name'; ";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count != 1) {
            $sql = "INSERT INTO categories (categories_name) VALUES ('$category_name');";
            mysqli_query($conn, $sql);
            header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/category.php");
            exit();
        }
    }
?>

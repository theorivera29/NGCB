<?php
    include "db_connection.php";
  
    
    if (isset($_POST['login'])) {
        session_start();
        $username = $_POST['username'];
        $password = $_POST['password']; 
        $sql = "SELECT accounts_password FROM accounts WHERE accounts_username = '$username'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $hash_password = $row[0];
        echo $hash_password;
        if(password_verify($password, $hash_password)) {
            $_SESSION['username'] = $username; 
            $_SESSION['loggedin'] = true;
            // header("location: http://127.0.0.1/22619/Materials%20Engineer/dashboard.php");
            header("location: http://127.0.0.1/22619/Materials%20Engineer/dashboard.php");
            exit;
        }else {
            $_SESSION['login_error'] = true;
            header("location: http://127.0.0.1/22619/Materials%20Engineer/loginpage.php");
            exit;
        } 
    }

    if (isset($_POST['logout'])) {
        session_start();
        session_unset();
        session_destroy();
        header('Location: http://127.0.0.1/Materials%20Engineer/loginpage.php');
        exit;
    }  

    if (isset($_POST['create_account'])) {
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $account_type = "Materials Engineer";
        $account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
        $sql = "SELECT accounts_username from accounts where accounts_username = '$username' ";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        if($count != 1) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO accounts (accounts_fname, accounts_lname, accounts_email, accounts_username, accounts_password, accounts_type)
                    VALUES ('$firstname', '$lastname', '$email', '$username', '$password', '$account_type')";
            mysqli_query($conn,$sql);
            header("Location: http://127.0.0.1/22619/Materials%20Engineer/loginpage.php");
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
            if (mysqli_query($conn,$sql)) {
                echo "Success";
            } else {
                echo $conn->error;
            }
            // header("location: http://127.0.0.1/Materials%20Engineer/dashboard.php");
            // exit;
        }
    }
    
    if (isset($_POST['close_project'])) {
        $projects_name = "NGCB Expansion Site";
        $sql = "SELECT projects_id FROM projects WHERE projects_name = '$projects_name'";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_row($result);
        $projects_id = $row[0];
        if($count == 1) {
            $sql = "UPDATE projects SET projects_status = 'closed' WHERE projects_id = $projects_id;";
            if (mysqli_query($conn,$sql)) {
                echo "Success";
            } else {
                echo $conn->error;
            }
        }    
    }

    if (isset($_POST['reopen_project'])) {
        $projects_name = "NGCB Expansion Site";
        $sql = "SELECT projects_id FROM projects WHERE projects_name = '$projects_name'";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_row($result);
        $projects_id = $row[0];
        if($count == 1) {
            $sql = "UPDATE projects SET projects_status = 're-opened' WHERE projects_id = $projects_id;";
        }
    }

    if(isset($_POST['create_project'])) {
        $categories_name = mysqli_real_escape_string($conn, $_POST['categories_name']);
        $sql = "SELECT categories_name FROM categories WHERE categories_name = '$categories_name'; ";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count != 1) {
            $sql = "INSERT INTO categories (categories_name) VALUES ('$categories_name');";
        }
    }

    
?>
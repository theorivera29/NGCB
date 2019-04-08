<?php
    include "db_connection.php";

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

    if (isset($_POST['logout'])) {
        session_start();
        session_unset();
        session_destroy();
        header('Location: http://127.0.0.1/NGCB/Materials%20Engineer/loginpage.php');
        exit;
    }
?>

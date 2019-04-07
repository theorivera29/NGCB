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
            header("location: http://127.0.0.1/NGCB/View%20Only/dashboard.php");
            exit;
        }else {
            $_SESSION['login_error'] = true;
            header("location: http://127.0.0.1/NGCB/View%20Only/loginpage.php");
            exit;
        } 
    }

    if (isset($_POST['logout'])) {
        session_start();
        session_unset();
        session_destroy();
        header('Location: http://127.0.0.1/NGCB/View%20Only/loginpage.php');
        exit;
    }  

    if(isset($_POST['view_inventory'])) {
        $projects_name = mysqli_real_escape_string($conn, $_POST['projects_name']);
        header("location: http://127.0.0.1/NGCB/View%20Only/viewinventory.php?projects_name=$projects_name");
    }

    if(isset($_POST['view_category'])) {
        $categories_id = mysqli_real_escape_string($conn, $_POST['categories_id']);
        header("location: http://127.0.0.1/NGCB/View%20Only/itemcategories.php?categories_id=$categories_id");
    }
    ?>
<?php
    $host = '127.0.0.1';
	$user = 'root';
	$pass = '';
	$db = 'ngcb';
	$conn = mysqli_connect($host, $user, $pass, $db) or die('Cannot connect to db');
	date_default_timezone_set('Asia/Manila');
?>
<?php

	/*
	Recommended way for versions of PHP >= 5.4.0

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	*/
	
    if (session_id() == '') {
       session_start();
    }

	require("library/config.php");

	$user_check=$_SESSION['email'];

	$userid = $_SESSION['userid'];

	$ses_sql=mysql_query("SELECT username FROM users WHERE username='$user_check'");
	 
	$row=mysql_fetch_array($ses_sql);
	 
	$login_session=$row['username'];
	 
	if(!isset($login_session))
	{
		header("Location: login.php");
	} else {
		if (isset($_GET['admintempid']) && $_GET['admintempid'] != '')
		header("Location: index.php?admintempid=".);
	}
?>
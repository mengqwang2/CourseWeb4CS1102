<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');
	require_once('lib/student_inc.php');
	session_start();
	$isad=$_SESSION['isad'];
	session_destroy();
	if($isad)
		Header("Location:admin.php");
	else
		Header("Location:index.php");
	//status_logout($username);
	/*
	showHeader();

	showTitle("CS1102 Introduction to Computer Studies");

	$user=new Student();

	$buttons = array("Student"=>"index.php",

					"Administrator"=>"admin.php");

	showMenu($buttons,'0');

	$user->showLogin();

	showFooter();
	*/
?>
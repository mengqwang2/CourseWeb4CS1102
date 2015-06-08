<?php
	require_once('lib/opt_inc.php');
	require_once('lib/admin_inc.php');	session_start();	/*echo "under maintainance...";*/	if(isset($_SESSION['valid_user'])){		if($_SESSION['isad']==1)			Header("Location:admin_main.php");		else			Header("Location:student_main.php");	}
	showHeader();
	showTitle("CS1102 Introduction to Computer Studies");
	$user=new Admin();
	$buttons = array("Student"=>"index.php",
					"Instructor"=>"admin.php");
	showMenu($buttons,'0');
	$user->showLogin();
	showFooter();	
?>
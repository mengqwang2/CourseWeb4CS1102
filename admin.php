<?php
	require_once('lib/opt_inc.php');
	require_once('lib/admin_inc.php');
	showHeader();
	showTitle("CS1102 Introduction to Computer Studies");
	$user=new Admin();
	$buttons = array("Student"=>"index.php",
					"Instructor"=>"admin.php");
	showMenu($buttons,'0');
	$user->showLogin();
	showFooter();
?>
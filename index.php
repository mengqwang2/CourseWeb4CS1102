<?php
	require_once('lib/opt_inc.php');
	require_once('lib/student_inc.php');
	showHeader();
	$user=new Student();
	$buttons = array("Student"=>"index.php",
					"Instructor"=>"admin.php");
	showMenu($buttons,'0');
	

	$user->showLogin();
	showFooter();
?>
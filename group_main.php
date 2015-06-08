<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');
	require_once('lib/student_inc.php');
	session_start();
	$id=$_SESSION['std'];
	showHeader();
	showTitle('CS1102 Introduction to Computer Studies');
	check_valid_user();
	//get the bookmarks this user has saved
	$buttons = array("Grouping"=>"group_main.php",
					"Topics"=>"s_topics.php",
					"Schedule"=>"schedule.php",
					"Logout"=>"logout.php");
	showMenu($buttons,'0');
	$s->showGroup($id);
	showFooter();

?>
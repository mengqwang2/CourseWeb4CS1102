<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');
	require_once('lib/student_inc.php');
	session_start();
	$id=$_SESSION['std'];	$_SESSION['gid']=$id;
	$s=new Student();
	
	showHeader();
	showTitle('CS1102 Introduction to Computer Studies');
	check_valid_user();
	//get the bookmarks this user has saved
	
	$buttons = array("Grouping"=>"group_main.php",
					"Topics"=>"s_topics.php",
					"Schedule"=>"schedule.php",										"Account"=>"account.php",
					"Logout"=>"logout.php");
	showMenu($buttons,'0');
	$s->quitGroup($id,$s->groupNum($id));	// jump 	$url = "group_main.php";	echo "<script type='text/javascript'>";	echo "window.location.href='$url'";	echo "</script>";	// jump 
	$s->showGroup($id);
	showFooter();

?>
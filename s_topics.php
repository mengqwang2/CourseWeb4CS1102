<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');
	require_once('lib/student_inc.php');
	require_once('lib/topic_inc.php');
	session_start();
	$id=$_SESSION['std'];	$_SESSION['gid']=$id;
	$s=new Student();
	$numT=$s->numTopic();
	showHeader();
	showTitle('CS1102 Introduction to Computer Studies');
	check_valid_user();
	//get the bookmarks this user has saved
	$buttons = array("Grouping"=>"group_main.php",
					"Topics"=>"s_topics.php",
					"Schedule"=>"schedule.php",					"Lab"=>"lab.php",					"Account"=>"account.php",
					"Logout"=>"logout.php");
	showMenu($buttons,'0');
	$s->showTopic($id,$numT);
	//echo "<p>To Be Announced Later</p>";
	showFooter();

?>

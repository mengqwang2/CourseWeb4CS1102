<?php

	require_once('lib/user_auth_fns.php');

	require_once('lib/opt_inc.php');

	require_once('lib/admin_inc.php');

	session_start();

	$id=$_SESSION['admin'];

	$tut=$_SESSION['tut'];

	$topicChosen=$_POST['topic'];

	$a=new Admin();
	/*
	showHeader();

	showTitle('CS1102 Introduction to Computer Studies');

	check_valid_user();
	$buttons = array("Schedule"=>"admin_main.php",

					"Logout"=>"logout.php");

	showMenu($buttons,'0');*/
	$a->setID($username);	//$a->assignTopic($tut,$topicChosen);
	$s=new Student();
	$a->asgSch($s->numGroup($tut), $tut);
	// jump to sch_result.php
	$url = "sch_result.php";
	echo "<script type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
	// jump to sch_result.php
	$s->showSchedule($s->numGroup($tut),$tut);
	
	$a->singleAssign($tut);
	echo "_________________________________________<br/>";
	$a->topicAssign($tut);
	$_SESSION['tut']=$tut;

	showFooter();
?>
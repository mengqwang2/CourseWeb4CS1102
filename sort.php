<?php

	require_once('lib/user_auth_fns.php');

	require_once('lib/opt_inc.php');

	require_once('lib/admin_inc.php');
	require_once('lib/student_inc.php');
	session_start();

	$id=$_SESSION['admin'];
	$_SESSION['adid']= $id;
	$_SESSION['gid']= $id;
	if($_POST['tutno'])

	{

	$tut=$_POST['tutno'];

	$_SESSION['tut']=$tut;

	}

	else

		$tut=$_SESSION['tut'];

	$a=new Admin();

	showHeader();

	showTitle('CS1102 Introduction to Computer Studies');

	check_valid_user();

		//get the bookmarks this user has saved
	
	$buttons = array("Schedule"=>"admin_main.php",
	
					 "Score"=>"score_main.php",

					"Logout"=>"logout.php");
	
	showMenu($buttons,'0');

	$a->setID($username);
	
	$s=new Student();
	$s->showSchedule_topic($s->numGroup($tut),$tut);

	$a->singleAssign($tut);
	echo "_________________________________________<br/>";
	$a->topicAssign($tut);


	showFooter();

?>
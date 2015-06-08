<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');
	require_once('lib/admin_inc.php');
	$id=$_SESSION['admin'];
	$tut=$_POST['tut'];
	$sid=$_POST['random'];
	$_SESSION['tut']=$tut;
	$a=new Admin();
	showHeader();
	showTitle('CS1102 Introduction to Computer Studies');
	
	//get the bookmarks this user has saved
	$buttons = array("Schedule"=>"admin_main.php",
					"Logout"=>"logout.php");
	showMenu($buttons,'0');
	
	$a->s_assign_result($sid,$tut);
	$a->setID($username);
	{
		$a->showAssign($a->numTut());
		$a->assignSchedule($tut);
		$a->assgin_grade_table($tut);
		$a->showSchedule($a->numGroup($tut),$tut);
	}
	else
	{*/
		$a->singleAssign($tut);
	//}
	showFooter();

?>
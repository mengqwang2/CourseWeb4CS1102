<?php

	require_once('lib/user_auth_fns.php');

	require_once('lib/opt_inc.php');

	require_once('lib/student_inc.php');

	$id=$_SESSION['std'];
	$_SESSION['gid']=$id;
	$s=new Student();
	if($_POST['sub']=='sub')
	{
	if(!$_POST['opass']||!$_POST['npass']||!$_POST['cpass'])
	{
		echo "<script type=\"text/javascript\">"; 
		echo "alert('Invalid Operation!')";
		echo "</script>";
	}
	else
	{
		if($_POST['npass']!=$_POST['cpass'])
		{
			echo "<script type=\"text/javascript\">"; 
			echo "alert('Invalid Operation!')";
			echo "</script>";
		}
		else
		{
			$s->changePass($id,$_POST['opass'],$_POST['npass']);
		}
	}
	}
	
	showHeader();

	showTitle('CS1102 Introduction to Computer Studies');

	check_valid_user();

	//get the bookmarks this user has saved
/*
	$buttons = array("Grouping"=>"group_main.php",
					"Topics"=>"s_topics.php",
					"Schedule"=>"schedule.php",
					"Lab"=>"lab.php",
					"Account"=>"account.php",
					"Logout"=>"logout.php");
*/
	$buttons = array("Lab"=>"lab.php",
					"Account"=>"account.php",
					"Logout"=>"logout.php");
	showMenu($buttons,'0');

	$s->accountInfo($id);
	//echo "Under Maintenance <br/>";
	showFooter();



?>
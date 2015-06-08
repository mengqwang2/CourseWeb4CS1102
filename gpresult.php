<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');
	require_once('lib/student_inc.php');
	session_start();
	$id=$_SESSION['std'];
	$s=new Student();
	$groupNum=$s->groupNum($id);
	$tutNum=$s->tutSection($id);
	$numMember=$s->numMember($groupNum,$tutNum);
	if($numMember==0)
	{
		$userAdd1=$_POST['sid0'];
		$userAdd2=$_POST['sid1'];
		$userAdd3=$_POST['sid2'];
	}
	else if($numMember==2)
	{
		$userAdd1=$_POST['sid0'];
	}

	showHeader();
	showTitle('CS1102 Introduction to Computer Studies');
	check_valid_user();
	$buttons = array("Grouping"=>"group_main.php",
					"Topics"=>"s_topics.php",
					"Schedule"=>"schedule.php",
					"Logout"=>"logout.php");
	showMenu($buttons,'0');
	if($userAdd1||$userAdd2||$userAdd3||$userAdd4)
	{
		if($userAdd1)
		{
			try
			{
					if($s->addMember($userAdd1,$id))
					{
			}
			catch(Exception $e)
			{
				echo $e->getMessage()."<br/>";
			}
		}
		if($userAdd2)
		{
			try
			{
					//$r+=$s->addMember($userAdd2,$id);
			}
			catch(Exception $e)
			{
				echo $e->getMessage()."<br/>";
			}
		}
		if($userAdd3)
		{
			try
			{
					//$r+=$s->addMember($userAdd3,$id);
			}
			catch(Exception $e)
			{
				echo $e->getMessage()."<br/>";
			}
		}
	}
	$s->showGroup($id);
	showFooter();

?>
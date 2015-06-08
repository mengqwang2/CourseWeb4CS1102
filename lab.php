<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');
	require_once('lib/student_inc.php');
	require_once('lib/helper_inc.php');
	session_start();
	$id=$_SESSION['std'];
	$_SESSION['gid']=$id;
	
	$s=new Student();
	$h=new Helper();
	$tut=$s->tutSection($id);
	$_SESSION['tut']=$tut;
	if($_POST['weekno'])
	{
		$tut=$_SESSION['tut'];
		$weekno=$_POST['weekno'];
		$_SESSION['weekno']=$weekno;
		
	}
	else if(!isset($_SESSION['weekno']))
	{
		$weekno=1;
	}
	else
	{
		$weekno=$_SESSION['weekno'];
	}
	
	if($_POST['hScore']&&$_POST['code'])
	{
		$tut=$_SESSION['tut'];
		$score=$_POST['hScore'];
		if($h->codeMatch($_POST['code'])==true)
		//if((int)$_POST['code']==(int)$id+$weekno)
		{
	
			$h->indiScore($tut,$weekno,$score,$id,$_POST['code']);
			if($_POST['sScore'])
			{
				$score=$_POST['sScore'];
				$s->indiScore($tut,$weekno,$score,$id,$_POST['code']);
			}
			echo "<script type=\"text/javascript\">"; 
			echo "alert('Mark Successfully!')";
			echo "</script>";
		}
		else
		{
			echo "<script type=\"text/javascript\">"; 
			echo "alert('Invalid Operation!')";
			echo "</script>";
		}
		
	}
	else if($_POST['hScore'])
	{
			echo "<script type=\"text/javascript\">"; 
			echo "alert('Please enter Marking Code')";
			echo "</script>";
	}
	/*
	if($_POST['sScore'])
	{	
		$tut=$_SESSION['tut'];
		$score=$_POST['sScore'];
		$s->indiScore($tut,$weekno,$score,$id);
	}
	*/
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
	$h->showLabByWeek($weekno,0);

	$h->stdMark($weekno,$tut,$id);
	$h->helperMark($weekno,$tut,$id);
		
	echo "_____________________________________________";
	echo "<p>Progress Report: </p>";
	echo "<p><form action='lab.php' method='post'>";
	echo "<input type='hidden' name='showAllWeeks' value='showAllWeeks' />";
	echo "<input type='submit' value='Show' />";
	echo "</form></p>";
	if($_POST['showAllWeeks'])
		$s->showAllWeeks($tut,$id);
	showFooter();

?>
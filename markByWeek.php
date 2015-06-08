<?php

	require_once('lib/user_auth_fns.php');

	require_once('lib/opt_inc.php');

	require_once('lib/admin_inc.php');
	require_once('lib/student_inc.php');
	require_once('lib/helper_inc.php');
	session_start();
	$h=new Helper();
	$a=new Admin();
	$id=$_SESSION['admin'];
	$_SESSION['admin']= $id;
	$isSubmitted=false;
	if($_POST['std'])
	{
		$std=$_POST['std'];
		$_SESSION['std']=$std;
	}
	if($_POST['tutno'])
	{
		$tut=$_POST['tutno'];
		$_SESSION['tut']=$tut;
	}
	
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
	
	if($_POST['score'])
	{
		$tut=$_SESSION['tut'];
		$scoreArr=$_POST['score'];
		$h->processScore($tut,$weekno,$scoreArr,'cs1102cs');
		echo "<script type=\"text/javascript\">"; 
		echo "alert('Mark updated Okay!')";
		echo "</script>";
		
	}
	if($_POST['sid'])
	{
		$sid=$_POST['sid'];
		$isSubmitted=true;
	}
	$tut=$_SESSION['tut'];
	showHeader();

	showTitle('CS1102 Introduction to Computer Studies');
	
	check_valid_user();

	
	if($id=="super")
	{
		
		$buttons = array("Lab"=>"helper_main.php",
					"Schedule"=>"admin_main.php",
					"Score"=>"score_main.php",
					"Admin"=>"super_admin.php",
					"Logout"=>"logout.php");
		/*
		$buttons = array("Lab"=>"helper_main.php",
					"Admin"=>"super_admin.php",
					"Logout"=>"logout.php");
		*/
		
	}
	else
	{
		
		$buttons = array("Lab"=>"helper_main.php",
					"Schedule"=>"admin_main.php",
					"Score"=>"score_main.php",
					"Logout"=>"logout.php");
		/*
		$buttons = array("Lab"=>"helper_main.php",
					"Logout"=>"logout.php");
		*/
	}
	
	showMenu($buttons,'0');
	
	$a->setID($username);
	$h->showLabByWeek($weekno,1);
	
	
	$h->studentTable($tut,$showScore=1,$weekno,0,0,$sid);
	echo "_____________________________________________";
	$h->showTotal(1);
	if(!$_POST['std']&&(!$isSubmitted))
		$h->studentTable($tut,$showScore=1,$weekno,1,0,$sid);
	else if((($std=='single')||(!$_POST['std'])||($_SESSION['std']=='single'))&&(!$isSubmitted))
		$h->studentTable($tut,$showScore=1,$weekno,1,0,$sid);
	else if((($std=='single')||(!$_POST['std'])||($_SESSION['std']=='single'))&&($isSubmitted))
		$h->studentTable($tut,$showScore=1,$weekno,1,1,$sid);
	else
		$h->studentTable($tut,$showScore=0,$weekno,0,1,$sid);
	showFooter();



?>
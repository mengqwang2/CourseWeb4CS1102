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
	
	$sortOnSID='0';
	if(isset($_SESSION['session_sortOnSID'])){
		$sortOnSID=$_SESSION['session_sortOnSID'];
	}
	if(isset($_POST['sortOnSID'])){
		$sortOnSID=$_POST['sortOnSID'];
	}	
	
	$_SESSION['session_sortOnSID']=$sortOnSID;
	
	$sortOnNo='1';
	if(isset($_SESSION['session_sortOnNo'])){
		$sortOnNo= $_SESSION['session_sortOnNo'];	
	}
	if(isset($_POST['sortOnNo'])){
		$sortOnNo=$_POST['sortOnNo'];

	}	
	
	$_SESSION['session_sortOnNo']=$sortOnNo;
		
	$a=new Admin();
	$comp_count=$a->getGradingCount();
	showHeader1($comp_count);

	showTitle('CS1102 Introduction to Computer Studies');

	check_valid_user();

	//get the bookmarks this user has saved
	
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
	$a->setID($id);
	
	$s=new Student();
	$numGroup= $s->numGroup($tut);
	$s->showSchedule($s->numGroup($tut),$tut,1,$sortOnSID,$sortOnNo);
	echo "<br/>";
	echo "_________________________________________<br/>";
	$a->studentTable($tut, 1);

	echo "<br/>";
	echo "_________________________________________<br/>";
	// drop down menu for group selection
	echo "<br/>";
	echo "<form action='score.php' method='post'>";
	echo "<p><b>Group No:</b><select name='selectedgid'></p>";
	$i=1;
	while($i <= $numGroup){
		echo "<option value='".$i."'>".$i."</option>";
		$i++;
	}	
	echo "</select>";
	echo "<input type='submit' value='Go' />";
	echo "</form>";
	
	if($gid=$_POST['selectedgid']){
		$_SESSION['toScoreGid']= $gid;
		echo "<div id='score_area'>";
		echo "<form action='submit_score.php' method='post'>";
		$a-> groupScore($tut, $gid);
		$a-> indiScore($tut, $gid);
		echo "<input type='submit' value='Submit' />";
		echo "</form>";
		echo "</div>";
	}
	showFooter();
	


?>
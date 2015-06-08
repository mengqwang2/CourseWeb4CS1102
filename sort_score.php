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
	$numGroup= $s->numGroup($tut);
	$s->showSchedule_topic($numGroup,$tut,1);
	echo "<br/>";
	echo "_________________________________________<br/>";
	$a->studentTable($tut, 1);

	echo "<br/>";
	echo "_________________________________________<br/>";
	// drop down menu for group selection
	echo "<br/>";
	echo "<form action='score.php' method='post'>";
	echo "<span><b>Group Section: </b><select name='selectedgid'></span>";
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
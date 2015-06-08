<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');
	require_once('lib/admin_inc.php');	require_once('lib/student_inc.php');	session_start();
	$id=$_SESSION['admin'];	$_SESSION['adid']= $id;	$_SESSION['gid']= $id;
	$tut=$_POST['tut'];
	$sid=$_POST['random'];
	$_SESSION['tut']=$tut;
	$a=new Admin();
	showHeader();
	showTitle('CS1102 Introduction to Computer Studies');
	
	//get the bookmarks this user has saved	/*	if(loggedin($id)!=1){		echo "<p>You didn't log in. Log in again please</p>";		echo "<a href='logout.php'>Log in</a>";			}	else{	*/	check_valid_user();
	$buttons = array("Schedule"=>"admin_main.php",
					"Logout"=>"logout.php");
	showMenu($buttons,'0');
	
	$a->s_assign_result($sid,$tut);
	$a->setID($username);	$s=new Student();	$s->showSchedule($s->numGroup($tut),$tut);	echo "_________________________________________<br/>";	/*	if($a->checkGrouping($tut)==0&&$a->checkTopicChosen($tut)==0)
	{
		$a->showAssign($a->numTut());
		$a->assignSchedule($tut);
		$a->assgin_grade_table($tut);
		$a->showSchedule($a->numGroup($tut),$tut);
	}
	else
	{*/
		$a->singleAssign($tut);		$a->topicAssign($tut);
	//}
	showFooter();

?>
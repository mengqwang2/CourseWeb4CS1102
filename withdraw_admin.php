<?php

	require_once('lib/user_auth_fns.php');

	require_once('lib/opt_inc.php');

	require_once('lib/admin_inc.php');
	require_once('lib/student_inc.php');
	session_start();

	$id=$_SESSION['admin'];
	$_SESSION['adid']= $id;
	$_SESSION['gid']= $id;
	$tut=$_SESSION['tut'];

	$a=new Admin();
	$s=new Student();
	showHeader();

	showTitle('CS1102 Introduction to Computer Studies');

	check_valid_user();

		//get the bookmarks this user has saved
	
	$buttons = array("Schedule"=>"admin_main.php",
	
					 "Score"=>"score_main.php",

					"Logout"=>"logout.php");
	
	showMenu($buttons,'0');
	
	$sid = $_POST['toWithdraw'];
	$url ="sch_result.php";
	$conn=db_connect();
	$query="select COUNT(sid) from STUDENT where SID='$sid'";
	$exe=mssql_query($query);
	$result=mssql_fetch_array($exe);
	
	if($result[0]==0){
		echo "<script type=\"text/javascript\">window.alert(\"Invalid Student ID.\")</script>";
		jumpURL($url);
	}
	$stut= $s->tutSection($sid);
	
	if($stut!= $tut){
		echo "<script type=\"text/javascript\">window.alert(\"Student: ".$sid." doesn't belong to this tutorial session.\")</script>";
		jumpURL($url);
	}
	$gid= $s->groupNum($sid);
	if($gid==0){
		echo "<script type=\"text/javascript\">window.alert(\"Student: ".$sid." doesn't belong any group.\")</script>";
		jumpURL($url);
	}
	//$s->quitGroup($sid,$gid);
	$s->releaseTopic($sid);
	$s->assignGroup($sid,0,$s->tutSection($sid));
	$s->clearPresenDate($sid);
	$query="select distinct(GROUPID) from STUDENT_GROUP where GROUPID!='0' and '$tut'=tut ORDER BY GROUPID;";//SID!='$sid'";
	$exe=mssql_query($query);
	$i=1;
	
	while($re=mssql_fetch_array($exe)){
		$groupid= $re[0];
		$update="update STUDENT_GROUP set GROUPID='$i' where '$groupid'=GROUPID and TUT='$tut'";
		$x=mssql_query($update);
		$i++;
	}
	
	echo "<script type=\"text/javascript\">window.alert(\"Student: ".$sid." successfully withdrawed from group ".$gid.".\")</script>";
	jumpURL($url);
?>
<?php

	require_once('lib/user_auth_fns.php');

	require_once('lib/opt_inc.php');

	require_once('lib/admin_inc.php');
	require_once('lib/student_inc.php');
	session_start();
	
	$s = new Student();
	$a = new Admin();
	
	$tut=$_SESSION['tut'];
	$gid= $_SESSION['toScoreGid'];
	$comp_count=$_POST['comp_count'];
	
	$score=array();
	/*
	for($i=1;$i<=comp_count;$i++)
	{
		$s_name='score'.$i;
		$score[$i-1]=$_POST[$s_name];
	}
	*/
	$score[0]=$_POST['score1'];
	$score[1]=$_POST['score2'];
	$score[2]=$_POST['score3'];
	$score[3]=$_POST['score4'];
	$score[4]=$_POST['score5'];
	
	$comment= $_POST['comment'];
	$score_group= $_POST['score_group'];
	if($score_group==0){
		echo "<script type=\"text/javascript\">window.alert(\"This group has a zero score.\")</script>";			
	}
	
	$conn=db_connect();
	$comment=str_replace("\'", "singleQuote", $comment);
	$comment=str_replace("\'", "doubleQuote", $comment);
	//echo "<script type=\"text/javascript\">window.alert(\"".$comment.".\")</script>";
	//$update="update GROUP_SCORE set FINAL=".$score_group.",CONT=".$score_con.", ORG=".$score_org.",LANG=".$score_lang.",QA=".$score_qa.",TEAM=".$score_team.",COMMENT='$comment' where TUT='$tut' and GROUPID='$gid'";
	$update="update GROUP_SCORE set COMMENT='$comment',FINAL=".$score_group." where TUT='$tut' and GROUPID='$gid'";
	mssql_query($update);
	$update="update GROUP_SCORE set ITEM1=".$score[0].",ITEM2=".$score[1].",ITEM3=".$score[2].",ITEM4=".$score[3].",ITEM5=".$score[4]." where TUT='$tut' and GROUPID='$gid'";
	mssql_query($update);
	/*
	for($i=1;$i<=comp_count;$i++)
	{
		$update=$update.",ITEM'".$i."'=".$score[$i-1];
	}
	$update=$update." where TUT='$tut' and GROUPID='$gid'";
	mssql_query($update);
	*/
	$query="select SID from STUDENT_GROUP where TUT='$tut' and GROUPID='$gid'";
	$exe=mssql_query($query);
	$i=0;
	
	while($result=mssql_fetch_array($exe)){
		$sid = $result[0];
		$s= "indiScore".$i;
		$s1="contri".$i;
		$s2="bonus".$i;
		$indiScore= $_POST[$s];
		$contri=$_POST[$s1];
		$bonus=$_POST[$s2];
		
		if($indiScore==0){
			echo "<script type=\"text/javascript\">window.alert(\"Student ".$sid." has a zero score.\")</script>";			
		}
		$indiScore=round($indiScore,2);
		$update1="update STUDENT_SCORE set FINAL=".$indiScore.", BONUS=".$bonus.", CONTRIBUTION=".$contri." where SID='$sid'";
		$exe1=mssql_query($update1);
		$i++;
	}
	
	// jump to score.php
	$url = "score.php";
	echo "<script type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
	// jump to score.php
	/*
		$buttons = array("Schedule"=>"admin_main.php",
	
					"Score"=>"score_main.php",

					"Logout"=>"logout.php");
	
	showMenu($buttons,'0');
	showFooter();
*/


?>
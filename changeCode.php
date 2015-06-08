<?php

	require_once('lib/user_auth_fns.php');

	require_once('lib/opt_inc.php');

	require_once('lib/student_inc.php');

	session_start();

	$id=$_SESSION['std'];
	
	$s=new Student();
	
	$oldcode=$_POST['oldcode'];
	$newcode=$_POST['newcode'];
	$newcode1=$_POST['newcode1'];

	
	if($newcode== $newcode1){
		$conn=db_connect();
		$select="select GROUP_CODE from STUDENT_PSWD where SID='$id';";
		$result= mssql_query($select);

		$row=mssql_fetch_array($result);
		
		if($row[0]==$oldcode){
			$modNum="update STUDENT_PSWD set GROUP_CODE='$newcode' where GROUP_CODE='$oldcode' and SID='$id';";
			$exe=mssql_query($modNum);
			if ($exe)
				echo "<script type=\"text/javascript\">window.alert(\"Grouping code successfully modified.\")</script>";
				//echo "<p id='errInfo'>Grouping code successfully modified".$sid."</p>";

			else
				echo "<script type=\"text/javascript\">window.alert(\"Modification failed.\")</script>";
				//echo "<p id='errInfo'>Execution failed</p>";
		}
		else 
			echo "<script type=\"text/javascript\">window.alert(\"Wrong grouping code.\")</script>";
			//echo "<p id='errInfo'>Wrong grouping code</p>";
	}
	else
		echo "<script type=\"text/javascript\">window.alert(\"Modification failed.\")</script>";
		//echo"<p id='errInfo'>new code confimation failed.</p>";
	// jump 
	$url = "account.php";
	echo "<script type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
	// jump 
	showHeader();

	showTitle('CS1102 Introduction to Computer Studies');

	check_valid_user();

	$buttons = array("Grouping"=>"group_main.php",

					"Topics"=>"s_topics.php",

					"Schedule"=>"schedule.php",
					
					"Account"=>"account.php",

					"Logout"=>"index.php");

	showMenu($buttons,'0');
	
	$s->accountInfo($id);

	showFooter();
?>
<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');
	require_once('lib/student_inc.php');
	session_start();
	$id=$_SESSION['std'];	$_SESSION['gid']=$id;	
	$s=new Student();	
	$groupNum=$s->groupNum($id);	
	$tutNum=$s->tutSection($id);	
	$numMember=$s->numMember($groupNum,$tutNum);	// only 0 and 2?		function check_grouping_code($sid, $code){				$select= "select GROUP_CODE from student_PSWD where SID='$sid';";		$conn=db_connect();		$result=mssql_query($select);		if (!$result)		{			throw new Exception("Could not execute query");		}		else		{			if ($row=mssql_fetch_array($result))			{				if($row[0]==$code)					return true;				else{					echo '<script type="text/javascript">';					echo 'alert("Student '.$sid.': grouping code is not correct.")';					echo '</script>';  				}					//echo "<script type=\"text/javascript\">window.alert(\"Student .\")</script>";					//throw new Exception("<p id='errInfo'>Grouping code and Student id $sid can't match.</p>");			}			else				echo "<script type=\"text/javascript\">window.alert(\"Invalid Student ID.\")</script>";				//throw new Exception("<p id='errInfo'>Invalid Student ID</p>");		}			}		
	if($numMember==0)
	{
		$userAdd1=$_POST['sid0'];
		$userAdd2=$_POST['sid1'];
		$userAdd3=$_POST['sid2'];		$userAdd4=$_POST['sid3'];		$userAdd4=$_POST['sid4'];				$code1= $_POST['code0'];		$code2= $_POST['code1'];		$code3= $_POST['code2'];		$code4= $_POST['code3'];		$code5= $_POST['code4'];
	}
	else if($numMember==2)
	{
		$userAdd1=$_POST['sid0'];		$userAdd2=$_POST['sid1'];		$userAdd3=$_POST['sid2'];				$code1= $_POST['code0'];		$code2= $_POST['code1'];		$code3= $_POST['code2'];
	}	else if($numMember==3){		$userAdd1=$_POST['sid0'];		$userAdd2=$_POST['sid1'];				$code1= $_POST['code0'];		$code2= $_POST['code1'];	}	else if($numMember==4){		$userAdd1=$_POST['sid0'];		$userAdd3=$_POST['sid2'];				$code1= $_POST['code0'];	}

	showHeader();
	showTitle('CS1102 Introduction to Computer Studies');
	check_valid_user();
	$buttons = array("Grouping"=>"group_main.php",
					"Topics"=>"s_topics.php",
					"Schedule"=>"schedule.php",					"Lab"=>"lab.php",					"Account"=>"account.php",
					"Logout"=>"logout.php");
	showMenu($buttons,'0');	$r=0;
	if($userAdd1||$userAdd2||$userAdd3||$userAdd4)
	{
		if($userAdd1)
		{
			try
			{
					if($s->addMember($userAdd1,$id))						$r = 1;					else
					{						if($r ==1)							$r = 3;					}		
			}
			catch(Exception $e)
			{
				echo $e->getMessage()."<br/>";
			}
		}
		if($userAdd2)
		{
			try
			{				if(check_grouping_code($userAdd2, $code2))
					//$r+=$s->addMember($userAdd2,$id);					if($s->addMember($userAdd2,$id))						$r = 1;					else{						if($r ==1)							$r = 3;					}							
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
					//$r+=$s->addMember($userAdd3,$id);					if($s->addMember($userAdd3,$id))						$r = 1;					else{						if($r ==1)							$r = 3;					}							
			}
			catch(Exception $e)
			{
				echo $e->getMessage()."<br/>";
			}
		}		if($userAdd4)		{			try			{					//$r+=$s->addMember($userAdd4,$id);					if($s->addMember($userAdd4,$id))						$r = 1;					else{						if($r ==1)							$r = 3;					}										}			catch(Exception $e)			{				echo $e->getMessage()."<br/>";			}		}
	}	if($r==0)		echo "<script type=\"text/javascript\">window.alert(\"Operation failed.\")</script>";	else if($r==1)		echo "<script type=\"text/javascript\">window.alert(\"Successfully add new member(s).\")</script>";	else		echo "<script type=\"text/javascript\">window.alert(\"Some students can't be added.\")</script>";	// jump 	$url = "group_main.php";	echo "<script type='text/javascript'>";	echo "window.location.href='$url'";	echo "</script>";	// jump 
	$s->showGroup($id);
	showFooter();	

?>
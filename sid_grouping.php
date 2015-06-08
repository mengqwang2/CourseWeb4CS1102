<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');	require_once('lib/student_inc.php');	require_once('lib/admin_inc.php');
	session_start();
	$id=$_SESSION['admin'];
	$tut=$_POST['tut'];
	$maxNum=$_POST['max'];
	$_SESSION['tut']=$tut;	$a= new Admin();	//Header("Location:sch_result.php");	/*
	if($_POST['random'])
	{
		$sid=$_POST['random'];
		$a->s_assign_result($sid,$tut);
	}*/
	if($_POST['sid'])
	{		$g;		$isfirst=1;
		$fGroup=$_POST['sid'];
		$s=new Student();		$r;		$oversize=0;		$sids="";
		for($i=0;$i<count($fGroup);$i++)
		{			if($fGroup[$i]=="")				continue;			if($fGroup[$i]!="" && $isfirst==1){										$g = $fGroup[$i];					$sids=$sids.$s->getStudentName($g);					$isfirst=0;					$gnum=$s->groupNum($g);					if($numMember=$s->numMember($gnum,$tut)==0){						$numMember=1;						$newG=$s->getNewGroupNum($g,$tut);						if($s->assignGroup($g,$newG,$tut))							$r=1;					}					$count=$maxNum-$numMember;					continue;			}				
			try
			{				if($count<=0){					$oversize=1;					break;				}				$count--;
				//$s->addMember($fGroup[$i],$fGroup[0]);				//$s->addMember($fGroup[$i],$g);				if($s->addMember($fGroup[$i],$g)){					$r = 1;					$sids=$sids."   ".$s->getStudentName($fGroup[$i]);				}				else{					if($r ==1)						$r = 2;				}					
			}
			catch(Exception $e)
			{
				echo $e->getMessage()."<br/>";
			}			
		}		if($oversize==1)			echo "<script type=\"text/javascript\">window.alert(\"Can't have more than five people in a group. Some students can not be added.\")</script>";		else{			if($r==0)				echo "<script type=\"text/javascript\">window.alert(\"Operation failed.\")</script>";			else if($r==1){				echo "<script type=\"text/javascript\">window.alert(\"Successfully added.\")</script>";				//echo "<script type=\"text/javascript\">window.alert(\"Successfully added. E-mails are sent to students to notify this modifiction $sids.\")</script>";								$gnum= $s->groupNum($g);				$isfirst=1;				for($i=0;$i<count($fGroup);$i++){					if($fGroup[$i]=="")						continue;					$a->mail_grouping($fGroup[$i], $gnum, $sids);				}			}			else				echo "<script type=\"text/javascript\">window.alert(\"Some students can't be added.\")</script>";		}			

	}	$url = "sch_result.php";	echo "<script type='text/javascript'>";	echo "window.location.href='$url'";	echo "</script>";	

?>
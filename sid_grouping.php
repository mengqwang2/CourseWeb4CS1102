<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');
	session_start();
	$id=$_SESSION['admin'];
	$tut=$_POST['tut'];
	$maxNum=$_POST['max'];
	$_SESSION['tut']=$tut;
	if($_POST['random'])
	{
		$sid=$_POST['random'];
		$a->s_assign_result($sid,$tut);
	}*/
	if($_POST['sid'])
	{
		$fGroup=$_POST['sid'];
		$s=new Student();
		for($i=0;$i<count($fGroup);$i++)
		{
			try
			{
				//$s->addMember($fGroup[$i],$fGroup[0]);
			}
			catch(Exception $e)
			{
				echo $e->getMessage()."<br/>";
			}
		}

	}

?>
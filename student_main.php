<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');
	require_once('lib/student_inc.php');
	session_start();	/*
	$username=$_POST['sid'];	if($username=="")		$username = $_SESSION['gid'];	$_SESSION['gid']=$username;
	$password=$_POST['pswd'];	
	$log_status=loggedin($username);	*/	$username=$_POST['sid'];		$password=$_POST['pswd'];	if(!isset($_SESSION['valid_user'])){	
		if($username && $password )
		{
			
			try
			{
				login($username,$password);
				$_SESSION['valid_user']=$username;
			}
			catch(Exception $e)
			{
				showHeader();
				showTitle("Problem: ");
				echo $e->getMessage()."<br/>";
				echo "You could not be logged in. You must log in to view this page. ";
				do_html_url('Login','index.php');
				showFooter();
				exit;
			}
		}	}	else{		if($username!=''){			echo "<script type=\"text/javascript\">window.alert(\"You've already logged in. Log out first to change to another account.\")</script>";		}		$username=$_SESSION['valid_user'];	}
	$_SESSION['std']=$username;
	header("Location: lab.php");
	showHeader();
	showTitle('CS1102 Introduction to Computer Studies');
	check_valid_user();
	//get the bookmarks this user has saved
		/*$buttons = array("Grouping"=>"group_main.php",
					"Topics"=>"s_topics.php",
					"Schedule"=>"schedule.php",
					"Lab"=>"lab.php",
					"Account"=>"account.php",
					"Logout"=>"logout.php");
*/
	$buttons = array("Lab"=>"lab.php",
					"Account"=>"account.php",
					"Logout"=>"logout.php");
	showMenu($buttons,'0');
	$s=new Student();
	
	
	$s->setID($username);
	$s->showGroup($username);
	showFooter();

?>
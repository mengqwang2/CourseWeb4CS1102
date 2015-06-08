<?php
	require_once('lib/user_auth_fns.php');
	require_once('lib/opt_inc.php');
	require_once('lib/admin_inc.php');
	session_start();	$a=new Admin();	
	if($_POST['user']&&$_POST['pass'])
	{		$username=$_POST['user'];		$password=$_POST['pass'];
		if(!isset($_SESSION['valid_user'])){

		
		//$log_status=loggedin($username);
		
		if($username && $password )
		//if($log_status<=0)
		{
			try
			{
				login_admin($username,$password);
				$_SESSION['valid_user']=$username;
			}
			catch(Exception $e)
			{
				
				showHeader();
				showTitle("Problem: ");
				echo $e->getMessage()."<br/>";
				echo "You could not be logged in. You must log in to view this page. ";
				do_html_url('Login','admin.php');
				
				//do_html_url('Login','index.php');
				showFooter();
				exit;
			}
			header("Location: helper_main.php");
		}
	}
	else{
		if($username!=''){
			echo "<script type=\"text/javascript\">window.alert(\"You've already logged in. Log out first to change to another account.\")</script>";
		}
		$username=$_SESSION['valid_user'];
	}
	}
	/*else if($_POST['min']&&$_POST['max'])
	{
		$username=$_SESSION['admin'];
		$conn= db_connect();
		$min=$_POST['min'];
		$max=$_POST['max'];
		$query="TRUNCATE TABLE STD_PER_GROUP";
		$exe=mssql_query($query);
		$query="INSERT INTO STD_PER_GROUP VALUES('$min','$max')";
		$exe=mssql_query($query);
	}*/
	else
		$username=$_SESSION['admin'];
		
	
	showHeader();
	showTitle('CS1102 Introduction to Computer Studies');
	check_valid_user();
	//get the bookmarks this user has saved
	if($username=="super")
	{
		$buttons = array("Lab"=>"helper_main.php",
					"Schedule"=>"admin_main.php",
					"Score"=>"score_main.php",
					"Admin"=>"super_admin.php",
					"Logout"=>"logout.php");
		
		/*$buttons = array("Lab"=>"helper_main.php",
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
	$_SESSION['admin']=$username;
	$a->setID($username);
		echo "<p><b>Assign Schedules</b></p>"; 
	$a->showAssign($a->numTut(), $username, 1);
	showFooter();

?>
<?
	require_once('lib/user_auth_fns.php');

	require_once('lib/opt_inc.php');

	require_once('lib/admin_inc.php');

	session_start();
	$a=new Admin();	
	
	showHeader();

	showTitle('CS1102 Introduction to Computer Studies');

	check_valid_user();
	$username=$_SESSION['valid_user'];
	
	if($username=="super")
	{
		$buttons = array("Lab"=>"helper_main.php",
					"Schedule"=>"admin_main.php",
					"Score"=>"score_main.php",
					"Admin"=>"super_admin.php",
					"Logout"=>"logout.php");
		/*
		$buttons = array("Lab"=>"helper_main.php",
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
	echo "<p><b>Select Session:</b><p/>";
	$a->showAssign($a->numTut(), $username, 0);

	showFooter();




?>
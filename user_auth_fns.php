<?php
	require_once('db_connect.php');
	
	function login($username,$password)
	{
		$select="select PASSWORD from STUDENT_PSWD where SID='$username';";
		$conn=db_connect();
		$result=mssql_query($select);
		if (!$result)
		{
			throw new Exception("Could not execute query");
		}
		else
		{
			if ($row=mssql_fetch_array($result))
			{
				//if(strtolower($row[0])==strtolower($password))
					return true;
				else
					throw new Exception("Invalid Name");
			}
			else
				throw new Exception("Invalid Student ID");
		}
	}
	
	function login_admin($username,$password)
	{
		$select="select Password from ADMIN where Admin_ID='$username'";
		$conn=db_connect();
		$result=mssql_query($select);
		if (!$result)
			throw new Exception("Could not execute query");
		}
		else
		{
			if ($row=mssql_fetch_array($result))
			{
				if($row[0]==$password){
					return true;
				else
					throw new Exception("Invalid Password");
			}
			else
				throw new Exception("Invalid Admin ID");
		}
	}
	
	function login_helper($username,$password)
	{
		$select="select Password from HELPER where Helper_ID='$username'";
		$conn=db_connect();
		$result=mssql_query($select);
		if (!$result)
		{
			throw new Exception("Could not execute query");
		}
		else
		{
			if ($row=mssql_fetch_array($result))
			{
				if($row[0]==$password)
					return true;
				else
					throw new Exception("Invalid Password");
			}
			else
				throw new Exception("Invalid Helper ID");
		}
	}
	function get_name($id){
	function check_valid_user()
	{
		if (isset($_SESSION['valid_user']))
		{
			#echo "<span id='loginInfo'>Logged in as ".$_SESSION['valid_user'].'</span></br>';
		else
		{
			showHeader();
			showTitle('Problem: ');
			echo "You didn't logged in.<br/>";
			do_html_url('Login','index.php');
			showFooter();
			exit;
		}
	}
?>
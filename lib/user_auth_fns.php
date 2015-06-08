<?php
	require_once('db_connect.php');	session_start();
	
	function login($username,$password)
	{		//find password in db
		$select="select PASSWORD from STUDENT_PSWD where SID='$username';";
		$conn=db_connect();
		$result=mssql_query($select);		if (!$result)
		{
			throw new Exception("Could not execute query");
		}
		else
		{
			if ($row=mssql_fetch_array($result))
			{				//if(strtolower($row[0])==strtolower($password))				if($row[0]==$password){									
					return true;				}
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
		if (!$result)				{
			throw new Exception("Could not execute query");
		}
		else
		{			
			if (($row=mssql_fetch_array($result)) && preg_match('/^[a-z]+$/', $username))
			{
				if($row[0]==$password){					
					return true;				}
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
	function get_name($id){		$conn=db_connect();		$select="select NAME from STUDENT where SID='$id';";		$result=mssql_query($select);		if (!$result)			return "";		else{			if ($row=mssql_fetch_array($result))			{				return $row[0];			}			else{				$select="select NAME from ADMIN where ADMIN_ID='$id';";				$result=mssql_query($select);				if (!$result)					return "";				else{					if ($row=mssql_fetch_array($result))					{						return $row[0];					}					else{						return "";					}				}			}		}	}
	function check_valid_user($ishowto=0)
	{
		if (isset($_SESSION['valid_user']))
		{			$name = get_name($_SESSION['valid_user']);
			#echo "<span id='loginInfo'>Logged in as ".$_SESSION['valid_user'].'</span></br>';			echo "<span id='loginInfo'>Hello! $name. Your Account ID is ".$_SESSION['valid_user'].'</span></br>';						$username=$_SESSION['valid_user'];			$conn=db_connect();			$select="select name from ADMIN where ADMIN_ID='$username'";			$result=mssql_query($select);			$result=mssql_query($select);			if ($row=mssql_fetch_array($result))				$_SESSION['isad']=1;			else				$_SESSION['isad']=0;		}		else if($ishowto){			;		}
		else
		{
			showHeader();
			showTitle('Problem: ');
			echo "You didn't log in.<br/>";
			do_html_url('Login','index.php');
			showFooter();
			exit;
		}
	}
?>
<?php
	require_once('db_connect.php');
		function loggedin($username){		$select="select login from LOG_STATUS where ID='$username';";		$conn=db_connect();		$result=mssql_query($select);		if (!$result)		{			return -1;		}		else		{			if ($row=mssql_fetch_array($result))			{				return $row[0];			}			else				return -1;		}			}		function status_login($username){		$conn= db_connect();		$query="update LOG_STATUS set login='1' where ID='$username';";		mssql_query($query);	}	function status_logout($username){		$conn= db_connect();		$query="update LOG_STATUS set login='0' where ID='$username';";		mssql_query($query);	}
	function login($username,$password)
	{		//find password in db
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
				//if(strtolower($row[0])==strtolower($password))				if($row[0]==$password){					status_login($username);				
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
			if ($row=mssql_fetch_array($result))
			{
				if($row[0]==$password){					status_login($username);
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
	function check_valid_user()
	{
		if (isset($_SESSION['valid_user']))
		{			$name = get_name($_SESSION['valid_user']);
			#echo "<span id='loginInfo'>Logged in as ".$_SESSION['valid_user'].'</span></br>';			echo "<span id='loginInfo'>Hello! $name. Your Account ID is ".$_SESSION['valid_user'].'</span></br>';		}
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
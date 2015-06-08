<?
	require_once('lib/user_auth_fns.php');

	require_once('lib/opt_inc.php');
	require_once('lib/topic_inc.php');
	require_once('lib/admin_inc.php');

	session_start();
	$a=new Admin();	
	
	if($_POST['min']&&$_POST['max'])
	{
		$conn= db_connect();
		$min=$_POST['min'];
		$max=$_POST['max'];
		$query="TRUNCATE TABLE STD_PER_GROUP";
		$exe=mssql_query($query);
		$query="INSERT INTO STD_PER_GROUP VALUES('$min','$max')";
		$exe=mssql_query($query);
		echo "<script type=\"text/javascript\">window.alert(\"Successfully set size!\")</script>";
	}
	else if($_POST['year']&&$_POST['month']&&$_POST['day']&&$_POST['hour']&&$_POST['minute']&&$_POST['second'])
	{
		
		$conn= db_connect();
		$year=$_POST['year'];
		$month=$_POST['month'];
		$day=$_POST['day'];
		$hour=$_POST['hour'];
		$minute=$_POST['minute'];
		$second=$_POST['second'];
		$query="TRUNCATE TABLE DEADLINE";
		$exe=mssql_query($query);
		$query="INSERT INTO DEADLINE VALUES('$year-$month-$day/$hour:$minute:$second')";
		$exe=mssql_query($query);
		echo "<script type=\"text/javascript\">window.alert(\"Successfully set deadline!\")</script>";
	}
	/*
	else if($_POST['finalize'])
	{
		//set group_score table in database
		$conn=db_connect();
		$query="TRUNCATE TABLE GROUP_SCORE";
		mssql_query($query);
		
		$query="select DISTINCT(TUT) from TUT_INFO";
		$exe=mssql_query($query);
		while ($result=mssql_fetch_array($exe))
		{
			$query="select MAX(GROUPID) from STUDENT_GROUP where TUT='$result[0]'";
			$max=mssql_query($query);
			$maxG=mssql_fetch_array($max);
			for($i=1;$i<=$maxG[0];$i++)
			{
				$query="insert into GROUP_SCORE values('$result[0]','$i',0,0,0,0,0,0,'')";
				mssql_query($query);
			}
		}

	}
	
	else if($_POST['content']&&$_POST['org']&&$_POST['lang']&&$_POST['qa']&&$_POST['team'])
	{
		$conn=db_connect();
		$query="TRUNCATE TABLE PERCENT_DISTRIBUTION";
		mssql_query($query);
		$query="INSERT INTO PERCENT_DISTRIBUTION values('".$_POST['content']."','".$_POST['org']."','".$_POST['lang']."','".$_POST['qa']."','".$_POST['team']."')";
		mssql_query($query);
	
	}
	*/
	
	else if($_POST['cName']&&$_POST['percent'])
	{
		$conn=db_connect();
		$query="TRUNCATE TABLE GRADING_COMPONENT";
		mssql_query($query);
		$name=$_POST['cName'];
		$percent=$_POST['percent'];
		$queryCreate="CREATE TABLE GROUP_SCORE(TUT varchar(50),GROUPID varchar(50)";
		for ($i=0;$i<8;$i++)
		{
			if($name[$i]!=''&&$percent[$i]!='')
			{
				$query="INSERT INTO GRADING_COMPONENT values('$name[$i]','".$percent[$i]."')";
				mssql_query($query);
				$queryCreate=$queryCreate.",".$name[$i]." int";
			}
		}
		
		$query="DROP TABLE GROUP_SCORE";
		mssql_query($query);
		$queryCreate=$queryCreate.")";
		mssql_query($queryCreate);
		
		
	
	}
	else if($_POST['tid'])
	{
		$t=new Topic();
		$tid=$_POST['tid'];
		if($tid!=0)
		{
			$conn=db_connect();
			$query="DELETE FROM TOPIC where TopicID='$tid'";
			mssql_query($query);
		}
		$t->rebuildTopicTable();
	
	}
	
	else if($_POST['newTopic'])
	{
		$t=new Topic();
		$numT=$t->numofTopic();
		$numT++;
		$newName=$_POST['newTopic'];
		$conn=db_connect();
		if(numT<=9)
			$query="INSERT INTO TOPIC values('0$numT','$newName')";
		else
			$query="INSERT INTO TOPIC values('$numT','$newName')";
		mssql_query($query);
	
	}
	
	showHeader();

	showTitle('CS1102 Introduction to Computer Studies');

	check_valid_user();
	$username=$_SESSION['valid_user'];
	
	if($username=="super")
	{
		$buttons = array("Schedule"=>"admin_main.php",
					"Score"=>"score_main.php",
					"Lab"=>"helper_main.php",
					"Admin"=>"super_admin.php",
					"Logout"=>"logout.php");
	}
	else
	{
		$buttons = array("Schedule"=>"admin_main.php",
					"Score"=>"score_main.php",
					"Lab"=>"helper_main.php",
					"Logout"=>"logout.php");
	}


	showMenu($buttons,'0');

	
	$_SESSION['admin']=$username;

	$a->setID($username);
	echo "<p>Set Group Range</p>";
	$a->setGroupRange($username);
	echo "<p>Set Deadline</p>";
	$a->setDeadline($username);
	echo "<p>Set Percent Distribution</p>";
	$a->setPercentDis($username);
	echo "<p>Set Presentation Topic</p>";
	echo "<p>Current Topic</p>";
	$a->setTopic($username);
	echo "<br/>";
	showFooter();




?>
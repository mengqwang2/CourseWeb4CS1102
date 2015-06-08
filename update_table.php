<?
	require_once('lib/user_auth_fns.php');

	require_once('lib/opt_inc.php');

	require_once('lib/admin_inc.php');
	require_once('lib/student_inc.php');
	
	$conn=db_connect();
	$query="select TUT from TUT_INFO";
	$exe=mssql_query($query);
	while($result = mssql_fetch_array($exe)){
		$tut = $result[0];
		for($i=1; $i<=20; $i++){
			$insert="insert into GROUP_SCORE values('$tut','$i','-1','-1','-1','-1','-1','-1','No Comment')";
			$x = mssql_query($insert);
		}
	}
	/**/
	$conn=db_connect();
	$query="select SID from STUDENT";
	$exe=mssql_query($query);
	while($r= mssql_fetch_array($exe)){
		$sid= $r[0];
		echo "$sid <br/>";
		$insert="insert into STUDENT_SCORE values('$sid','-1','-1','-1')";
		$x = mssql_query($insert);
	}
?>
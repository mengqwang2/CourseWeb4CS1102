<?php
	
	require_once('lib/db_connect.php');
	$conn=db_connect();
	
	$x = 80; 
	$y = 'jean';
	$z = 12.2;
	
	$query="insert into tutor1.xx values(10, 'wang', 85.5)";
	$result=mssql_query($query);
	echo $query."<br/>";
	
	$query="insert into tutor1.xx values (".$x.", '".$y."', ".$z.")"; 
	$result=mssql_query($query);
	echo $query."<br/>";
	
	$query="insert into tutor1.xx values (NULL, '".$y."', NULL)"; 
	$result=mssql_query($query);	
	echo $query."<br/>";
	
	echo "<script>alert('done')</script>";
?>
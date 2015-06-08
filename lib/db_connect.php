<?php
	function db_connect()
	{
		$db = mssql_connect("cs1102.cs.cityu.edu.hk", "cs1102", "cs1102cs");
		if (!$db)
			throw new Exception("db connection failed");
		$db_selected = mssql_select_db("cs1102db");
		if (!db_selected)
			throw new Exception("database not found");
		return $db_selected;
	}

?>
<?php
	require_once('lib/db_connect.php');
	
	class Topic
	{
		public function getName($topicID)
		{
			if($topicID!=0)
			{
			$conn=db_connect();
			//get topic name
			$gName="select TopicName from TOPIC where '$topicID'=TopicID";
			$result=mssql_query($gName);
			$name=mssql_fetch_array($result);
			return $name[0];
			}

		}
		
		public function numofTopic()
		{
			$conn=db_connect();
			$query="select TopicID from TOPIC";
			$result=mssql_query($query);
			return mssql_num_rows($result);
		}	
	
		public function getID()
		{
			return $this->topicID;
		}
		
		public function chosenStatus($tut,$topicID)
		{
			$conn=db_connect();
			//decide if the topic is chosen or not
			$checkChosen="select GROUPID from STUDENT_GROUP where '$topicID'=TOPICID and '$tut'=TUT";
			$result=mssql_query($checkChosen);
			if($row=mssql_fetch_array($result))
				return true;
			else
				return false;
		}
		
		public function setID($a)
		{
			$this->topicID=$a;
		}
		
		public function rebuildTopicTable()
		{
			$conn=db_connect();
			$query="SELECT TopicName from TOPIC";
			$exe=mssql_query($query);
			$resultNew=array();
			while ($result=mssql_fetch_array($exe))
			{
				if($result[0]!='')
					array_push($resultNew,$result[0]);
			}
			$tNum=$this->numofTopic();
			
			$query="TRUNCATE TABLE TOPIC";
			mssql_query($query);
			
			for ($i=1;$i<=$tNum;$i++)
			{
				$index=$i-1;
				if($i<=9)
					$query="INSERT INTO TOPIC VALUES ('0$i','$resultNew[$index]')";
				else
					$query="INSERT INTO TOPIC VALUES ('$i','$resultNew[$index]')";
				mssql_query($query);
			}
			
		
		}
		
		private $topicID;
	};
		
	
	
	
	
?>
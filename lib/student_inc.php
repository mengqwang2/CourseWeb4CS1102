<?php
	session_start();
	require_once('lib/user_inc.php');
	require_once('lib/topic_inc.php');
	require_once('lib/db_connect.php');
	require_once('lib/opt_inc.php');
	
	require_once('lib/user_auth_fns.php');
	class Student extends User
	{
		
		public function setID($a)
		{
			$this->id=$a;
		}
		
		public function getID()
		{
			return $this->id;
		}
		
		public function showLogin()
		{
			echo "<div id='login'><form name='slog' onsubmit='return checkname(document.slog.sid.value)' action='student_main.php' method='post'>";
			echo "Student ID<br/>";
			echo "<input type='text' name='sid'/>";
			echo "<br/>";
			echo "Password<br/><input type='password' name='pswd'/>";
			echo "<br/>";
			echo "<input type='submit' value='Login'/>";
			echo "<input type='button' value='Reset' onclick='javascript:window.location=\"index.php\"'/></form></div>";
		}		
		
		
		public function groupNum($sid)
		{
			$conn=db_connect();
			//find his group number
			$query="select GROUPID from STUDENT_GROUP where '$sid'=SID";
			$result=mssql_query($query);
			$num=mssql_fetch_array($result);
			return $num[0];
		}
		
		public function tutSection($sid)
		{
			$conn=db_connect();
			//find tut section
			$tutSection="select TUT from STUDENT_GROUP where '$sid'=SID";
			$tutSec=mssql_query($tutSection);
			$strTut=mssql_fetch_array($tutSec);
			return $strTut[0];
		}
		
		public function numMember($groupNum,$tutNum)
		{
			$conn=db_connect();
			$query="select SID from STUDENT_GROUP where GROUPID='$groupNum' and TUT='$tutNum' and GROUPID!=0";
			$result=mssql_query($query);
			$num=mssql_num_rows($result);
			return $num;
		}
			
		
		public function showAddBox($numOfMember,$tut,$groupNum,$sid)
		{
			$conn=db_connect();
			$query="select MAX_STD from STD_PER_GROUP";
			$exe=mssql_query($query);
			$result1=mssql_fetch_array($exe);
			
			echo "<form action='gpresult.php' method='post'>";
			$query="select SID from STUDENT_GROUP where '$tut'=TUT AND '$groupNum'=GROUPID and GROUPID!='0' and SID!='$sid'";
			$exe=mssql_query($query);
			$nameCount=0;
			$boxCount=0;
			$count=0;
			
			$first=0;
			$sname = get_name($sid);
			echo "<p>";
			echo $sid."&nbsp;&nbsp;&nbsp; $sname</p>";
			$showButton=false;
			while($count<$result1[0]-1)
			{
				if($nameCount<$numOfMember-1)
				{
					$result=mssql_fetch_array($exe);
					$name = get_name($result[0]);
					echo "<p>";
					echo $result[0]."&nbsp;&nbsp;&nbsp; $name</p>";
					$nameCount++;
				}
				else
				{
					$showButton=true;
					if($first==0){
						echo "_____________________________________________";
						echo "<p>Please insert your group members student id and group code.</p>";
					}
					$first=1;
					echo "<p>Student ID:<input type='text' name='sid".$boxCount."' /></p>";
					$boxCount++;
				}
				
				$count++;
			}
			if ($showButton)
				echo "</br><input type='submit' value='Submit'/>";
			echo "</form>";

			if($numOfMember!=0)
			{
				//echo "<a id='wtd' href='javascript:var r=confirm(\"Do you want to quit?\");if(r==true) window.location=\"wtdresult.php\";'>Withdrawn from current group</a>";
				echo "<p>withdraw form current group: <br/><p>";
				echo "<form name='input' action='wtdresult.php' method='get'><input type='submit' value='withdraw'></form> ";
			}
		}

		public function showGroup($sid)
		{
			$numGroup=$this->groupNum($sid);
			$tut=$this->tutSection($sid);
			$conn=db_connect();
			$query="select MAX_STD from STD_PER_GROUP";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			if($this->numMember($numGroup,$tut)==$result[0])
				echo "<p id='sysInfo'>Your group now has ".$result[0]." people.</p>";
			else if($numGroup==0)
				echo "<p id='sysInfo'>You haven't formed any group yet.</p>";
			else
				echo "<p id='sysInfo'>Your group has ".$this->numMember($numGroup,$tut)." members now.</p>";
			
			$this->showAddBox($this->numMember($numGroup,$tut),$tut,$numGroup,$sid);
		}
		
		public function addMember($userAdd,$sid)
		{
			$tut=$this->tutSection($sid);
			$num;
			$gnum;
			$tut1=$this->tutSection($userAdd);
			$s=1;
			if($tut==$tut1)
			{
				if($userAdd!= $sid){
					$conn=db_connect();
					if($this->groupNum($userAdd)==0)
					{
						
						if(($gnum=$this->groupNum($sid))!=0){
							
								return ($this->assignGroup($userAdd,$this->groupNum($sid),$tut))&& 1;
						}
						else
						{
							$newG=$this->getNewGroupNum($sid,$tut);
							$s = $s && ($this->assignGroup($userAdd,$newG,$tut));
							
							return $s && ($this->assignGroup($sid,$newG,$tut));
						}
						
					}
					else
						
					{
						echo '<script type="text/javascript">';
						echo 'alert("Student '.$userAdd.': cannot add a student who is already in a group.")';
						echo '</script>';  
					}
						//throw new Exception("<p id='errInfo'>".$userAdd." has already enrolled in a group.</p>");
				}
				else
					echo "<script type=\"text/javascript\">window.alert(\"Can not add yourself.\")</script>";
				//throw new Exception("<p id='errInfo'>".$userAdd." Request denied. You cannot add yourself.</p>");

			}
			else
			//echo "<script type=\"text/javascript\">window.alert(\"Can not add a student from another tutorial.\")</script>";
			{
				echo '<script type="text/javascript">';
				echo 'alert("Student '.$userAdd.': cannot add a student from a different lab section.")';
				echo '</script>';  
			}//throw new Exception("<p id='errInfo'>".$userAdd." Request denied. You cannot add members from different tutorial.</p>");
			
		}
		
		public function getNewGroupNum($sid,$tut) 
		{
			//find maximum group num in database in same tutorial
			$conn=db_connect();
			$maxNum="select max(GROUPID) from STUDENT_GROUP where TUT='$tut'";
			$re=mssql_query($maxNum);
			$result=mssql_fetch_array($re);
			return $result[0]+1;
		}
		
		public function assignGroup($sid,$num,$tut)
		{
			//modify the group num in database
			$conn=db_connect();
			$query = "select count(sid) from student_group where groupid='$num' and TUT='$tut'";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			if( $result[0]!=0){
				$query = "select topicid from student_group where groupid='$num' and TUT='$tut'";
				$exe=mssql_query($query);
				$result=mssql_fetch_array($exe);
				$tid = $result[0];
		
				$modNum="update STUDENT_GROUP set TOPICID='$tid' where SID='$sid' and TUT='$tut'";
				$exe=mssql_query($modNum);
				
				$query = "select count(presen_date) from student_group where groupid='$num' and TUT='$tut'";
				$exe=mssql_query($query);
				$result=mssql_fetch_array($exe);
				if( $result[0]!=0){
					$query = "select presen_date from student_group where groupid='$num' and TUT='$tut'";
					$exe=mssql_query($query);
					$result=mssql_fetch_array($exe);
					$pdate = $result[0];
					
					$modNum="update STUDENT_GROUP set PRESEN_DATE='$pdate' where SID='$sid' and TUT='$tut'";
					$exe=mssql_query($modNum);
				}
			}
			
			$modNum="update STUDENT_GROUP set GROUPID='$num' where SID='$sid' and TUT='$tut'";
			$exe=mssql_query($modNum);
			
			if ($exe)
				return 1;
				
			else
				return 0;
				
		}
		
		public function quitGroup($sid,$groupNum)
		{
			//if there remains only one group member, set the groupid=0
			$conn=db_connect();
						//modify the group num to 0
			$tut = $this->tutSection($sid);
			
			$this->assignGroup($sid,'0',$this->tutSection($sid));
			$this->clearPresenDate($sid);
			//modify the topic num to 0 if the group does not exist

			$this->releaseTopic($sid);
			$query="select count(SID) from STUDENT_GROUP where '$groupNum'=GROUPID and '$tut'=tut;";//and SID!='$sid'";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			
			if($result[0]==1)
			{
				$query="select SID from STUDENT_GROUP where '$groupNum'=GROUPID and '$tut'=tut;";//SID!='$sid'";
				$exe=mssql_query($query);
				$re=mssql_fetch_array($exe);
				$this->assignGroup($re[0],0,$this->tutSection($sid));
				$this->releaseTopic($re[0]);
				$this->clearPresenDate($re[0]);
				// reassign grouop id
				$query="select distinct(GROUPID) from STUDENT_GROUP where GROUPID!='0' and '$tut'=tut ORDER BY GROUPID;";//SID!='$sid'";
				$exe=mssql_query($query);
				$i=1;
				
				while($re=mssql_fetch_array($exe)){
					$groupid= $re[0];
					$update="update STUDENT_GROUP set GROUPID='$i' where '$groupid'=GROUPID and TUT='$tut'";
					$x=mssql_query($update);
					$i++;
				}
			}
			
			
		}
		public function clearPresenDate($sid)
		{
			$conn=db_connect();
			$update="update STUDENT_GROUP set PRESEN_DATE=NULL where SID='$sid'";
			mssql_query($update);			
		}
		public function releaseTopic($sid)
		{
			$query="update STUDENT_GROUP set TOPICID='0' where '$sid'=SID";
			mssql_query($query);
		}
		
		
		public function showTopic($sid,$numT)
		{
			$this->topicStatus($sid,$numT);
		}
		
		public function topicStatus($sid,$numT)
		{
			$conn=db_connect();
			$query="select MIN_STD from STD_PER_GROUP";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			$numGroup=$this->groupNum($sid);

			$tut=$this->tutSection($sid);
			$canChoose=1;
			if($numGroup==0)
			{
				echo "<script type=\"text/javascript\">window.alert(\"Form a group first please.\")</script>";
				$canChoose=0;
				//echo "<p id='errInfo'>Please form a group first.</p>";
			}
			
			else if($this->numMember($numGroup,$tut) < $result[0]){
				echo "<script type=\"text/javascript\">window.alert(\"Your group should have at least ".$result[0]." members to choose a topic.\")</script>";
				$canChoose=0;
				//echo "<p id='errInfo'>Please get more than three members.</p>";
			}
			/*
			else
			{
			*/
				if($this->getTopicId($sid)!=0)
				{
					$tid=$this->getTopicId($sid);
					$t=new Topic();
					$t->setID($tid);
					//echo "<script type=\"text/javascript\">window.alert(\"Your group has already chosen a topic.\")</script>";
					echo "<h5>Current topic: ".$tid." ".$t->getName($tid)."</h5>";
					//echo "<p id='errInfo'>Your group has already chosen Topic ".$this->getTopicId($sid)."</p>";
				}
				$this->showTopicTable($sid,$numT,$canChoose);
			//}
		}
		
		public function getStudentName($sid)
		{

			$conn=db_connect();
			$query="select Name from STUDENT where SID='$sid'";
			$exe=mssql_query($query);
			$name=mssql_fetch_array($exe);
			return $name[0];			
		}
		
		public function getTopicId($sid)
		{
			//get topic id
			$getId="select TOPICID from STUDENT_GROUP where SID='$sid'";
			$conn=db_connect();
			$result=mssql_query($getId);
			$id=mssql_fetch_array($result);
			return $id[0];
		}
		
		public function setTopicId($a,$groupNum,$tut,$sid)
		{
			$conn=db_connect();
			$query="select count(PRESEN_DATE) from STUDENT_GROUP where GROUPID!='0' and TUT='$tut'";
			$exe=mssql_query($query);
			$result=$result=mssql_fetch_array($exe);
			if($result[0]>0){
				echo "<script type=\"text/javascript\">window.alert(\"Topic can not be changed after the schedule is assigned.\")</script>";
				return;
			}
			$nTopic=new Topic();
			if(!$nTopic->chosenStatus($this->tutSection($sid),$a))
			{
				$setId="update STUDENT_GROUP set TOPICID='$a' where GROUPID='$groupNum' and TUT='$tut'";
				$conn=db_connect();
				mssql_query($setId);
				$setId="update STUDENT_GROUP set PRESEN_DATE=NULL where GROUPID='$groupNum' and TUT='$tut'";
				$conn=db_connect();
				mssql_query($setId);
			}
			else
				echo "<script type=\"text/javascript\">window.alert(\"This topic has just been chosen by another group. Please choose another topic please.\")</script>";
				//echo "<p id='errInfo'>This topic has just been chosen by another group. Please choose another topic which is available now.</p>";
		}
		
		public function numTopic()
		{
			$conn=db_connect();
			$query="select TopicID from TOPIC";
			$result=mssql_query($query);
			return mssql_num_rows($result);
		}	
		
		public function showTopicTable($sid,$numT,$canChoose=1)
		{	
			$t=new Topic();
			echo "<form action='modiTopic.php' method='post'>";
			$conn=db_connect();
			$query="select TopicID from TOPIC";
			$exe=mssql_query($query);
			$i=1;
			echo "<table ><tr><td>Topic ID</td><td>Topic Name</td><td></td></tr>";
			while($result=mssql_fetch_array($exe))

			{

				//if(!$t->chosenStatus($tut,$result[0]))

				//{
					echo "<tr><td>".$result[0]."</td><td>".$t->getName($result[0])."</td><td>";
					$t->setID($result[0]);
					if($canChoose){
						if(!$t->chosenStatus($this->tutSection($sid),$t->getID()) && $i<10)
							echo "<input type='radio' name='topic' value='0".$i."'/>";
						if(!$t->chosenStatus($this->tutSection($sid),$t->getID()) && $i>9)
							echo "<input type='radio' name='topic' value='".$i."'/>";
					}
					else{
						if(!$t->chosenStatus($this->tutSection($sid),$t->getID()) && $i<10)
							echo "<input type='radio' name='topic' value='0".$i."' disabled='disabled'/>";
						if(!$t->chosenStatus($this->tutSection($sid),$t->getID()) && $i>9)
							echo "<input type='radio' name='topic' value='".$i."' disabled='disabled'/>";					
					}
					echo "</td></tr>";
				//}
				$i++;
			}
			echo "</table>";
		
			if($canChoose)
				echo "<input type='submit' value='submit' /></form>";
			else
				echo "<input type='submit' value='submit' disabled='disabled'/></form>";
		}
		
		//run right after deadline
		
		public function numGroup($tut)
		{
			$conn=db_connect();
			$query="select distinct(GROUPID) from STUDENT_GROUP where '$tut'=TUT and groupid!='0'";
			$exe=mssql_query($query);
			return mssql_num_rows($exe);
		}

		public function getTopic($tut,$i)
		{
			$conn=db_connect();
			$query="select TOPICID from STUDENT_GROUP where TUT='$tut' and GROUPID='$i'";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			return $result[0];
		}
		
		public function getPresenDate($tut,$groupNum)
		{
			$conn=db_connect();
			$query="select PRESEN_DATE from STUDENT_GROUP where '$tut'=TUT and GROUPID='$groupNum'";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			return $result[0];
		}
		
		public function getStDate($tut)
		{
			$conn=db_connect();
			$query="select PRESEN_DATE from TUT_PRESEN where $tut=TUT";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			return $result[0];
		}
		
		public function getEndDate($tut)
		{
			$conn=db_connect();
			$query="select PRESEN_DATE from TUT_PRESEN where $tut=TUT";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			$query="select DATEADD(week,1,'{$result[0]}') AS NewDate";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			return $result[0];
		}
		
		public function getTopicName($tut,$i)
		{
			$tid=$this->getTopic($tut,$i);
			$t=new Topic();
			$name=$t->getName($tid);
			return $name;
		}
		public function showSchedule_student($numG,$tut)
		{
			
			$t= new Topic();
			echo "<p><b>Totorial Session: ".$tut."</b></p>";
			$sort= $_SESSION['sort'];
			//echo "$sort";
			echo "<table><tr><td>Group No.</td><td>Group Member</td><td>Topic ID</td><td>Topic Name</td><td>Presentation Date</td></tr>";
			
			$conn=db_connect();
			$query0="select TopicID from TOPIC";
			$exe0=mssql_query($query0);
			
			while($result0=mssql_fetch_array($exe0))
			//for($i=1;$i<=$numG;$i++)
			{
				
				$tid= $result0[0];
				$t->setID($tid);
				if(!$t->chosenStatus($tut,$t->getID()))
					continue;
				
				
				$conn=db_connect();
				$query="select distinct(GROUPID) from STUDENT_GROUP where TOPICID='$tid' and TUT='$tut'";
				$exe=mssql_query($query);
				$row=mssql_num_rows($exe);
				
				$result=mssql_fetch_array($exe);
				
				$i = $result[0];
				
				
				echo "<tr><td>".$i."</td>";

				

				$query="select SID from STUDENT_GROUP where GROUPID='$i' and TUT='$tut'";

				$exe=mssql_query($query);

				echo "<td>";
				$blueCounter=0;
				while($result=mssql_fetch_array($exe))

				{
					$studentid=$result[0];
					$query1="select NAME from STUDENT where SID='$studentid'";
					$exe1=mssql_query($query1);
					$result1=mssql_fetch_array($exe1);
					if($blueCounter%2)
						echo "<span id='blue'>";
					else
						echo "<span>";
					echo "$result1[0]</span> ";
					$blueCounter++;
				}

				echo "</td>";
				$topic=$this->getTopic($tut,$i);
				$topicName=$this->getTopicName($tut,$i);
				if($topic!="0")
					echo "<td>".$topic."</td>";
				else
					echo "<td>Not Selected</td>";
					
				if($topicName!="")
				echo "<td>".$topicName."</td>";
				else
					echo "<td>Not Selected</td>";
				
				$pdate=$this->getPresenDate($tut,$i);
				if($pdate!="")
					echo "<td>$pdate</td>";
				else
					echo "<td>Not Assigned</td>";
				
				//echo "<td>".$this->getPresenDate($tut,$i)."</td>";
				echo "</tr>";

			}

			echo "</table>";

		}		
		public function showSchedule($numG,$tut,$showScore=0,$sortOnSID='0',$sortOnNo='1')
		{
		
			echo "<p><b>Tutorial Session: ".$tut."</b></p>";
			$sort= $_SESSION['sort'];
			//echo "$sort";

			if($showScore){
				$url_group_sort="score.php";
				$url_topic_sort="sort_score.php";
			}
			else{
				$url_group_sort="sch_result.php";
				$url_topic_sort="sort.php";
			}
			echo "<table><tr><td>";
			// sort on No.
			if($showScore){
					echo "<form action='score.php' method='post'><input type='hidden' name='sortOnNo' value='1'/><input type='submit' value='Group No.'/></form>";
			}
			else{
					echo "<form action='sch_result.php' method='post'><input type='hidden' name='sortOnNo' value='1'/><input type='submit' value='Group No.'/></form>";
			}
			echo "</td><td>";
			// sort on SID/NAME
			if($showScore){
				if($sortOnSID=='1')
					echo "<form action='score.php' method='post'><input type='hidden' name='sortOnSID' value='0'/><input type='submit' value='Click to Display Name'/></form>";
				else
					echo "<form action='score.php' method='post'><input type='hidden' name='sortOnSID' value='1'/><input type='submit' value='Click to Display ID'/></form>";
				}
			else{
				if($sortOnSID=='1')
					echo "<form action='sch_result.php' method='post'><input type='hidden' name='sortOnSID' value='0'/><input type='submit' value='Click to Display Name'/></form>";
				else
					echo "<form action='sch_result.php' method='post'><input type='hidden' name='sortOnSID' value='1'/><input type='submit' value='Click to Display ID'/></form>";
			}
			echo "</td><td>";
			// sort on topic
			if($showScore){
					echo "<form action='score.php' method='post'><input type='hidden' name='sortOnNo' value='0'/><input type='submit' value='Topic ID'/></form>";			
			}
			else{
					echo "<form action='sch_result.php' method='post'><input type='hidden' name='sortOnNo' value='0'/><input type='submit' value='Topic ID'/></form>";			
			}
			echo "</td><td>Topic Name</td><td>Presentation Date</td>";
			if($showScore)
				echo "<td>Group Score</td>";
			echo "</tr>";
			
			if($sortOnNo=='1'){
				for($i=1;$i<=$numG;$i++)
				{
					echo "<tr><td>".$i."</td>";
					$conn=db_connect();
					$query="select SID from STUDENT_GROUP where GROUPID='$i' and TUT='$tut'";
					$exe=mssql_query($query);
					echo "<td>";
					$blueCounter=0;
					while($result=mssql_fetch_array($exe))
					{
						if($sortOnSID=='1'){
							if($blueCounter%2)
								echo "<span id='blue'>";
							else
								echo "<span>";
							echo "$result[0]</span> ";
						}
						else{
							$query1="select NAME from STUDENT where SID='$result[0]'";
							$exe1=mssql_query($query1);
							$result1=mssql_fetch_array($exe1);
							if($blueCounter%2)
								echo "<span id='blue'>";
							else
								echo "<span>";
							echo "$result1[0]</span> ";
						}
						$blueCounter++;
					}
					
					echo "</td>";
					$topic=$this->getTopic($tut,$i);
					$topicName=$this->getTopicName($tut,$i);
					if($topic!="0")
						echo "<td>".$topic."</td>";
					else
						echo "<td>Not Selected</td>";
						
					if($topicName!="")
					echo "<td>".$topicName."</td>";
					else
						echo "<td>Not Selected</td>";
					/**/
					$pdate=$this->getPresenDate($tut,$i);
					if($pdate!="")
						echo "<td>$pdate</td>";
					else
						echo "<td>Not Assigned</td>";
					if($showScore){
						$conn=db_connect();
						$query1="select final from GROUP_SCORE where GROUPID='$i' and TUT='$tut'";
						$exe1=mssql_query($query1);
						$result1=mssql_fetch_array($exe1);
						if($result1[0]!='-1')
							echo "<td>".$result1[0]."</td>";
						else
							echo "<td>Not Marked</td>";
					}
					
					
					//echo "<td>".$this->getPresenDate($tut,$i)."</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			else{
				$t= new Topic();
				$query="select distinct(GROUPID) from STUDENT_GROUP where GROUPID!='0' and TUT='$tut' and TOPICID is NULL  ORDER BY GROUPID";
				$exe=mssql_query($query);
				while($result=mssql_fetch_array($exe)){
					$gid = $result[0];
					
					echo "<tr><td>".$gid."</td>";	
					$query="select SID from STUDENT_GROUP where GROUPID='$gid' and TUT='$tut'";
					$exe=mssql_query($query);
					echo "<td>";
					$blueCounter=0;
					while($result=mssql_fetch_array($exe))
					{
						if($sortOnSID=='1'){
							if($blueCounter%2)
								echo "<span id='blue'>";
							else
								echo "<span>";
							echo "$result[0]</span> ";
						}
						else{
							$query1="select NAME from STUDENT where SID='$result[0]'";
							$exe1=mssql_query($query1);
							$result1=mssql_fetch_array($exe1);
							if($blueCounter%2)
								echo "<span id='blue'>";
							else
								echo "<span>";
							echo "$result1[0]</span> ";
						}
						$blueCounter++;
					}
					echo "</td>";
					echo "<td>Not Selected</td>";
					echo "<td>Not Selected</td>";
					$pdate=$this->getPresenDate($tut,$gid);
					if($pdate!="")
						echo "<td>$pdate</td>";
					else
						echo "<td>Not Assigned</td>";
					
					echo "</tr>";
				}
				
				$query0="select TopicID from TOPIC";
				//$query0="select TopicID from TOPIC";
				$exe0=mssql_query($query0);
				
				while($result0=mssql_fetch_array($exe0))
				//for($i=1;$i<=$numG;$i++)
				{
					
					$tid= $result0[0];
					$t->setID($tid);
					if(!$t->chosenStatus($tut,$t->getID()))
						continue;
					
					
					$conn=db_connect();
					$query="select distinct(GROUPID) from STUDENT_GROUP where TOPICID='$tid' and TUT='$tut'";
					$exe=mssql_query($query);
					//$row=mssql_num_rows($exe);
					
					$result=mssql_fetch_array($exe);
					
					$i = $result[0];
					
					
					echo "<tr><td>".$i."</td>";

					

					$query="select SID from STUDENT_GROUP where GROUPID='$i' and TUT='$tut'";

					$exe=mssql_query($query);

					echo "<td>";
					$blueCounter=0;
					while($result=mssql_fetch_array($exe))

					{

						if($sortOnSID=='1'){
							if($blueCounter%2)
								echo "<span id='blue'>";
							else
								echo "<span>";
							echo "$result[0]</span> ";
						}
						else{
							$query1="select NAME from STUDENT where SID='$result[0]'";
							$exe1=mssql_query($query1);
							$result1=mssql_fetch_array($exe1);
							if($blueCounter%2)
								echo "<span id='blue'>";
							else
								echo "<span>";
							echo "$result1[0]</span> ";
						}
						$blueCounter++;

					}

					echo "</td>";
					$topic=$this->getTopic($tut,$i);
					$topicName=$this->getTopicName($tut,$i);
					if($topic!="0")
						echo "<td>".$topic."</td>";
					else
						echo "<td>Not Selected</td>";
						
					if($topicName!="")
					echo "<td>".$topicName."</td>";
					else
						echo "<td>Not Selected</td>";
					
					$pdate=$this->getPresenDate($tut,$i);
					if($pdate!="")
						echo "<td>$pdate</td>";
					else
						echo "<td>Not Assigned</td>";
					if($showScore){
						$conn=db_connect();
						$query1="select FINAL from GROUP_SCORE where GROUPID='$i' and TUT='$tut'";
						$exe1=mssql_query($query1);
						$result1=mssql_fetch_array($exe1);
						if($result1[0]!='-1')
							echo "<td>".$result1[0]."</td>";
						else
							echo "<td>Not Marked</td>";
					}
					//echo "<td>".$this->getPresenDate($tut,$i)."</td>";
					echo "</tr>";

				}
				
				echo "</table>";
			}
		}


		public function submitStatus($sid,$week)
		{
			$conn=db_connect();
			$query="update SUBMIT_STATUS set STATUS='1' where SID=$sid and $week=WEEK";
			mssql_query($query);
		}
		
		public function checkSubmit($sid,$week)
		{
			$conn=db_connect();
			$query="select STATUS from SUBMIT_STATUS where SID=$sid and $week=WEEK";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			return $result[0];
		}
		
		function stdMark($weekno,$tut,$sid)
		{
			//echo $weekno." ".$tut." ".$sid; 
			echo "<p>Mark (From Student):</p>";
			echo "<table><tr><td>";
			echo "<form action='lab.php' method='post'>";
			$conn=db_connect();
			$query="select Self_score from LAB_SCORE where SID='$sid' AND Week=$weekno";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			echo "<p>Mark:</p>";
					if($result[0]==1)
					{
						echo "<input type='radio' name='sScore' value='1' checked='checked' />1";
						echo "<input type='radio' name='sScore' value='2' />2";
						echo "<input type='radio' name='sScore' value='3' />3";
						echo "<input type='radio' name='sScore' value='4' />4";
						echo "<input type='radio' name='sScore' value='5' />5";
					}
					else if($result[0]==2)
					{
						echo "<input type='radio' name='sScore' value='1'/>1";
						echo "<input type='radio' name='sScore' value='2' checked='checked' />2";
						echo "<input type='radio' name='sScore' value='3' />3";
						echo "<input type='radio' name='sScore' value='4' />4";
						echo "<input type='radio' name='sScore' value='5' />5";
					}
					else if($result[0]==3)
					{
						echo "<input type='radio' name='sScore' value='1'/>1";
						echo "<input type='radio' name='sScore' value='2'/>2";
						echo "<input type='radio' name='sScore' value='3' checked='checked' />3";
						echo "<input type='radio' name='sScore' value='4' />4";
						echo "<input type='radio' name='sScore' value='5' />5";
					}
					else if($result[0]==4)
					{
						echo "<input type='radio' name='sScore' value='1'/>1";
						echo "<input type='radio' name='sScore' value='2'/>2";
						echo "<input type='radio' name='sScore' value='3'/>3";
						echo "<input type='radio' name='sScore' value='4' checked='checked' />4";
						echo "<input type='radio' name='sScore' value='5' />5";
					}
					else if($result[0]==5)
					{
						echo "<input type='radio' name='sScore' value='1'/>1";
						echo "<input type='radio' name='sScore' value='2'/>2";
						echo "<input type='radio' name='sScore' value='3'/>3";
						echo "<input type='radio' name='sScore' value='4'/>4";
						echo "<input type='radio' name='sScore' value='5' checked='checked' />5";
					}
					else
					{
						echo "<input type='radio' name='sScore' value='1'/>1";
						echo "<input type='radio' name='sScore' value='2'/>2";
						echo "<input type='radio' name='sScore' value='3'/>3";
						echo "<input type='radio' name='sScore' value='4'/>4";
						echo "<input type='radio' name='sScore' value='5'/>5";
					}
			echo "<br/>";
			echo "<input type='submit' value='Mark' />";
			echo "</form>";
			echo "</td></tr></table>";
		}
		
		function showAllWeeks($tut,$sid)
		{
			echo "<p><table><tr><td>Week</td><td>Self Score</td><td>Total Score</td><td>Total Completion</td></tr>";
			$i=0;
			$s1=false;
			while($i<13)
			{
				$s1=false;
				echo "<tr><td>".($i+1);
				echo "</td>";
				$weekno=$i+1;
				$query1="select Self_score from LAB_SCORE where SID=$sid and Week=$weekno";
				$exe1=mssql_query($query1);
				if($result1=mssql_fetch_array($exe1))
				{
					echo "<td>".$result1[0];
					echo "</td>";
				}
				else
					echo "<td></td>";
				$query2="select Helper_score from LAB_SCORE where SID=$sid and Week=$weekno";
				$exe2=mssql_query($query2);
				if($result2=mssql_fetch_array($exe2))
				{
					echo "<td>".$result2[0];
					echo "</td>";
					if($result2[0]>0)
						$s1=true;
				}
				else
					echo "<td></td>";
				if($s1)
					echo "<td>1</td>";
				else
					echo "<td>0</td>";
				echo "</tr>";
				$i++;
			}
			echo "</table>";
		}
		
		function indiScore($tut,$weekno,$score,$sid,$code)
		{
			$conn=db_connect();
			$searchQuery="SELECT SID FROM LAB_SCORE WHERE Tut_ID='$tut' AND Week=$weekno AND SID=$sid";
			$exe=mssql_query($searchQuery);
			$result=mssql_fetch_array($exe);
			if((int)$result[0]>0)
				$query="UPDATE LAB_SCORE SET Self_score=".$score.",Lab_code='$code' WHERE SID='$sid' AND Tut_ID='$tut' AND Week=$weekno";
			else
				$query="INSERT INTO LAB_SCORE VALUES('$sid','$tut',0,".$score.",NULL,".$weekno.",'$code')";
			mssql_query($query);
			
		}
		
		function accountInfo($sid)
		{
			$conn=db_connect();
			$query="select Name,Lec,Tut from STUDENT where SID='$sid'";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			echo "<p>Stdeunt ID: ".$sid."<br/>";
			echo "Name: ".$result[0]."<br/>";
			echo "Lecture Section: ".$result[1]."<br/>";
			echo "Tutorial Section: ".$result[2]."<br/></p>";
			echo "<form action='account.php' method='post'>";
			echo "<p>Old Password: <input type='password' name='opass' /><br/>";
			echo "New Password: <input type='password' name='npass' /><br/>";
			echo "Confirmed New Password: <input type='password' name='cpass' /><br/></p>";
			echo "<input type='hidden' name='sub' value='sub'/>";
			echo "<input type='submit' value='Confirm'/><br/>";
			echo "</form>";
		
		}
		
		function changePass($sid,$oldpass,$newpass)
		{
			
			$conn=db_connect();
			$query="select PASSWORD from STUDENT_PSWD where SID='$sid'";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			if($result[0]!=$oldpass)
			{
				echo "<script type=\"text/javascript\">"; 
				echo "alert('Invalid Operation!')";
				echo "</script>";
			}
			else
			{
				$query1="update STUDENT_PSWD set PASSWORD='$newpass' where SID='$sid'";
				$exe1=mssql_query($query1);
				echo "<script type=\"text/javascript\">"; 
				echo "alert('New Password has been set!')";
				echo "</script>";
			}
		}
	}

?>
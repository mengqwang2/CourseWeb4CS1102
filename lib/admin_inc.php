<?php	require_once('lib/user_inc.php');	
require_once('lib/topic_inc.php');	
require_once('lib/student_inc.php');	class Admin extends User	
{		public function setID($a)		{			
$this->id=$a;		}				public 
function showLogin()		{			echo "<div id='login'><form name='alog' 
onsubmit='return checkname(document.alog.user.value);'action='admin_main.php' method='post'>";			
echo "Instructor ID<br/>";			echo "<input type='text' name='user'/>";			
echo "<br/>";			echo "Password<br/><input type='password' name='pass'/>";			
echo "<br/>";			echo "<input type='submit' value='Login'/>";			echo "<input 
type='button' value='Reset' onclick='javascript:checklogin();window.location=\"admin.php\"'/></form></div>";		
}					public function numTut()		{			
$conn=db_connect();			$query="select distinct(TUT) from TUT_INFO";			
$result=mssql_query($query);			return mssql_num_rows($result);		}				
public function setGroupRange($adminid)		{			if($adminid=='super')			
{				echo "<form action='super_admin.php' method='post'>";				
echo "Min size<input type='text' name='min' />";				echo "Max size<input 
type='text' name='max'/><br/>";				echo "<input type='submit' value='set' />";				
echo "</form>";			}				}				public 
function setDeadline($adminid)		{			if($adminid=='super')			{								
echo "<form action='super_admin.php' method='post'>";				echo "Year(YYYY)<input 
type='text' name='year' /><br/>";				echo "Month(MM)<input type='text' name='month' 
/><br/>";				echo "Day(DD)<input type='text' name='day' /><br/>";				
echo "Hours(HH)<input type='text' name='hour' /><br/>";				echo 
"Minutes(MM)<input type='text' name='minute' /><br/>";				echo "Seconds(SS)<input 
type='text' name='second' /><br/>";				echo "<input type='submit' value='set' />";				
echo "</form>";			}				}				public 
function setPercentDis($adminid)		{			if($adminid=='super')			
{								echo "<form action='super_admin.php' 
method='post' onsubmit='checkPercent(this)'>";				echo "<table border='1'><tr>";				
echo "<td>Name</td>";				echo "<td>Percent</td>";				echo 
"</tr>";				echo "<tr><td><input type='text' name='cName[]' /></td><td><input 
type='text' name='percent[]' /></td></tr>";				echo "<tr><td><input type='text' name='cName[]' /></td><td><input type='text' name='percent[]' /></td></tr>";				echo "<tr><td><input type='text' name='cName[]' /></td><td><input type='text' name='percent[]' /></td></tr>";				echo "<tr><td><input type='text' name='cName[]' /></td><td><input type='text' name='percent[]' /></td></tr>";				echo "<tr><td><input type='text' name='cName[]' /></td><td><input type='text' name='percent[]' /></td></tr>";				echo "<tr><td><input type='text' name='cName[]' /></td><td><input type='text' name='percent[]' /></td></tr>";				echo "<tr><td><input type='text' name='cName[]' /></td><td><input type='text' name='percent[]' /></td></tr>";				echo "<tr><td><input type='text' name='cName[]' /></td><td><input type='text' name='percent[]' /></td></tr>";				echo "</table>";				echo "<input type='submit' value='Submit' /><br/>";				echo "</form>";				/*				$conn=db_connect();				$query="select CONT,ORG, LANG, QA, TEAM from PERCENT_DISTRIBUTION ";				$exe=mssql_query($query);				$result= mssql_fetch_array($exe);				$upper_cont=$result[0];				$upper_org=$result[1];				$upper_lang=$result[2];				$upper_qa=$result[3];				$upper_team=$result[4];				$totalPercent=$result[0]+$result[1]+$result[2]+$result[3]+$result[4];				echo "<form action='super_admin.php' method='post' onsubmit='checkPercent(this)'>";				echo "Content<input type='text' name='content' id='content' value='".$result[0]."' onchange='PercentDis()'/><br/>";				echo "Organization<input type='text' name='org' id='org' value='".$result[1]."'onchange='PercentDis()'/><br/>";				echo "Language and Voice<input type='text' name='lang' id='lang' value='".$result[2]."'onchange='PercentDis()'/><br/>";				echo "Q & A Performance<input type='text' name='qa' id='qa' value='".$result[3]."'onchange='PercentDis()'/><br/>";				echo "Teamwork<input type='text' name='team' id='team' value='".$result[4]."'onchange='PercentDis()'/><br/>";				echo "Current total<input type='text' name='totalPercent' id='totalPercent' value='".$totalPercent."'/><br/>";				echo "<input type='submit' value='set'/>";				echo "</form>";*/							}				}				public function setTopic($adminid)		{			$conn=db_connect();			$query="select TopicID from TOPIC";			$exe=mssql_query($query);			$t=new Topic();			echo "<form action='super_admin.php' method='post'>";			echo "<select name='tid'>";			echo "<option value='0' selected='selected'>Topics</option>";			while($result=mssql_fetch_array($exe))			{				echo "<option value='".$result[0]."'>".$t->getName($result[0])."</option>";			}			echo "</select>";			echo "<input type='submit' value='delete'/><br/></form>";			echo "<form action='super_admin.php' method='post'>";			echo "<input type='text' name='newTopic' />";			echo "<input type='submit' value='Add New Topic'/><br/>";			echo "</form>";		}		public function showAssign($numTut, $adminid, $isSch)		{						$conn= db_connect();			$query="select Name from ADMIN where Admin_id='$adminid';";			$exe=mssql_query($query);			$result=mssql_fetch_array($exe);			$name = $result[0];			if($isSch)				echo "<form action='sch_result.php' method='post'>";			else				echo "<form action='score.php' method='post'>";			echo "<p>Tutorial Section:<select name='tutno'></p>";			$query="select TUT, Location, Time, Staff from TUT_INFO where STAFF LIKE '%$name%'";			$exe=mssql_query($query);			while($result=mssql_fetch_array($exe))			{				echo "<option value='".$result[0]."'>";				echo $result[0]."  ".$result[1]."  ".$result[2]."  ".$result[3];				echo "</option>";			}			if($adminid=='super')			{                				$query="select TUT, Location, Time, Staff from TUT_INFO where TUT IS NOT NULL;";				$exe=mssql_query($query);				while($result=mssql_fetch_array($exe)){					echo "<option value='".$result[0]."'>";					echo $result[0]."  ".$result[1]."  ".$result[2]."  ".$result[3];					echo "</option>";				}				echo "Determine number of students in a group";			}			echo "</select>";			echo "<input type='submit' value='Go' />";				echo "</form>";			}		public function checkGrouping($tut)		{			$conn=db_connect();			$query="select SID from STUDENT_GROUP where GROUPID='0' and TUT='$tut'";			$exe=mssql_query($query);			$result=mssql_num_rows($exe);			return $result;		}				public function checkTopicChosen($tut)		{			$conn=db_connect();			$query="select distinct(GROUPID) from STUDENT_GROUP where TOPICID='0' and GROUPID!='0' and TUT='$tut'";			$exe=mssql_query($query);			$result=mssql_num_rows($exe);			return $result;		}				public function assignSchedule($tut)		{			$conn=db_connect();			//find max TopicID			$query="select MAX(TOPICID) from STUDENT_GROUP where TUT='$tut'";			$exe=mssql_query($query);			$result=mssql_fetch_array($exe);			$maxTopic=$result[0];						//find total number of groups			$query="select MAX(GROUPID) from STUDENT_GROUP where TUT='$tut'";			$exe=mssql_query($query);			$result=mssql_fetch_array($exe);			$numGroup=$result[0];			$i=1;			$gNo=1;						while($i<=$maxTopic)			{							$conn=db_connect();				$query="select GROUPID from STUDENT_GROUP where TOPICID='$i' and TUT='$tut'";				$exe=mssql_query($query);				if($result=mssql_fetch_array($exe))				{					//update groupID					$query="update STUDENT_GROUP set GROUPID='$gNo' where TUT='$tut' and TOPICID='$i'";					mssql_query($query);					//update presentation date					if($gNo<=6)					{						$query="select PRESEN_DATE from TUT_PRESEN where TUT='$tut'";						$exe=mssql_query($query);						$result=mssql_fetch_array($exe);						$interval=20*($gNo-1);						$query="select DATEADD(minute,$interval,'{$result[0]}') AS NewDate";					}					else					{						$query="select PRESEN_DATE from TUT_PRESEN where TUT='$tut'";						$exe=mssql_query($query);						$result=mssql_fetch_array($exe);						$interval=20*($gNo-7)+7*24*60;						$query="select DATEADD(minute,$interval,'{$result[0]}') AS NewDate";					}					$exe=mssql_query($query);					$result=mssql_fetch_array($exe);					$query="update STUDENT_GROUP set PRESEN_DATE='{$result[0]}' where TUT='$tut' and TOPICID='$i'";					mssql_query($query);										$i++;					$gNo++;				}				else					$i++;			}				//change assign status			$query="update ASSIGN_STATUS set STATUS=1 where TUT='$tut'";			mssql_query($query);					}				public function singleAssign($tut)		{				//find total num of groups				$conn=db_connect();				$query="select MAX_STD from STD_PER_GROUP";				$exe=mssql_query($query);				$result=mssql_fetch_array($exe);				$maxNum=$result[0];								$query="select MIN_STD from STD_PER_GROUP";				$exe=mssql_query($query);				$result=mssql_fetch_array($exe);				$minNum=$result[0];				$query="select distinct(GROUPID) from STUDENT_GROUP where '$tut'=TUT and GROUPID!='0'";				$exe=mssql_query($query);				$result=mssql_num_rows($exe);				$total=$result;								//find  num of groups which members can be added				$count=0;				$query="select distinct(GROUPID) from STUDENT_GROUP where '$tut'=TUT and GROUPID!='0'";				$exe=mssql_query($query);				while($result=mssql_fetch_array($exe))				{										if($this->numMember($result[0],$tut)<$minNum)						$count++;				}				$ava=$count;								echo "<form action='asg_sch.php' method='post'><input type='submit' value='Assign Schedule' /></form>";				echo "_________________________________________<br/>";				echo "<p>There are ".$total." groups in the system. ".$ava." groups only have less than three members now.</p>";								$this->studentTable($tut);				echo "<p>Help students form a group (In case to add a student to an existing group, put the ID of one current member of the existing group in <b>the first row</b>.) </p>";				echo "<form action='sid_grouping.php' method='post'>";								for($i=0;$i<$maxNum;$i++)				{					echo "<p>Student ID:<input type='text' name='sid[]' /></p>";				}				echo "<input type='hidden' value='$maxNum' name='max'/>";				echo "<input type='submit' value='Form/Join a Group' /><input type='hidden' name='tut' value='".$tut."' /></form>";						}				public function studentTable($tut, $showScore=0){			echo "<p>Students Information (no group -> <b>black</b>, has a group -> <span id='grey'><b>grey</b></span>): <p>";			echo "<table><tr><td id='studentTableNo'>No</td><td>Student No</td><td>Name</td>";			if($showScore)				echo "<td>Score</td>";			echo "<td id='studentTableNo'>No</td><td>Student No</td><td>Name</td>";			if($showScore)				echo "<td>Score</td>";							echo "<td id='studentTableNo'>No</td><td>Student No</td><td>Name</td>";			if($showScore)				echo "<td>Score</td>";							echo "</tr>";			$i=1;			$query="select SID,GROUPID from STUDENT_GROUP where '$tut'=TUT";//";						$exe=mssql_query($query);			echo "<tr>";			while($result=mssql_fetch_array($exe))			{					$query1="select NAME from STUDENT where SID='$result[0]'";				$exe1=mssql_query($query1);				$result1=mssql_fetch_array($exe1);				if(($i-1)%3==0)					echo "</tr><tr>";				if($showScore){					$query2="select FINAL from STUDENT_SCORE where SID='$result[0]'";					$exe2=mssql_query($query2);					$result2=mssql_fetch_array($exe2);					$indiScore= round($result2[0],3);				}				if($result[1]!=0){					echo "<td id='greybg'> ".$i." </td><td id='grey'>  ".$result[0]."  </td><td id='grey'>  ".$result1[0]."  </td>";//<input type='checkbox' name='random[]' value='".$result[0]."' /></td></tr>";					if($showScore){						if($indiScore!='-1')							echo "<td id= 'grey'>$indiScore</td>";						else							echo "<td id= 'grey'>Not Marked.</td>";					}				}				else{					echo "<td id='studentTableNo'> ".$i." </td><td>  ".$result[0]."  </td><td>  ".$result1[0]."  </td>";//<input type='checkbox' name='random[]' value='".$result[0]."' /></td></tr>";									if($showScore){						if($indiScore!='-1')							echo "<td>$indiScore</td>";						else							echo "<td>Not Marked.</td>";					}				}				$i++;			}			echo "</tr>";//<input type='hidden' name='tut' value='".$tut."' /><input type='submit' value='Randomly Assign' /></form>";			echo "</table>";		}		public function asgSch($numG, $tut){			$conn=db_connect();			$query="select DEADLINE from DEADLINE";			$exe=mssql_query($query);			$result=mssql_fetch_array($exe);			$deadline= $result[0];			//echo "$deadline";			$datetime=date ("Y-m-d/H:i:s");			$overdue=0;						$query="select GROUPID from STUDENT_GROUP where '$tut'=TUT and GROUPID='0'";			$exe=mssql_query($query);			$result=mssql_num_rows($exe);			//if(date("Y-m-d/H:i:s",strtotime($datetime))> date("Y-m-d/H:i:s",strtotime($deadline)))						if($datetime > $deadline){				$overdue=1;			}			if($overdue==0){				//echo "<script type=\"text/javascript\">window.alert(\"$datetime\")</script>";				echo "<script type=\"text/javascript\">window.alert(\"Please assign schedule after $deadline.\")</script>";				return;			}			/*			if($result>0 && $overdue==0){				echo "<script type=\"text/javascript\">window.alert(\"Make sure every student has a group first please.\")</script>";				return;			}*/			$query="select GROUPID from STUDENT_GROUP where '$tut'=TUT and topicid='0' and GROUPID!='0'";			$exe=mssql_query($query);			$result=mssql_num_rows($exe);			if($result>0){				echo "<script type=\"text/javascript\">window.alert(\"Make sure every group has a topic first please.\")</script>";				return;			}			// assigning...			$query="select distinct(topicid) from STUDENT_GROUP where '$tut'=TUT and GROUPID!='0' ORDER BY topicid;";			$exe=mssql_query($query);			$i=0;			$w = 12;			while($result=mssql_fetch_array($exe))			{				if($i>4)					$w = 13;				$p=1+$i%5;				$modi= "update STUDENT_GROUP set PRESEN_DATE='week ".$w." presentation ".$p."' where '$tut'= TUT and '$result[0]'= topicid;";				mssql_query($modi);				$i++;			}						//set up GROUP_SCORE table			//delete current record			$query="delete from GROUP_SCORE where '$tut'=TUT";			mssql_query($query);			$query="select MAX(GROUPID) from STUDENT_GROUP where TUT='$tut'";			$max=mssql_query($query);			$maxG=mssql_fetch_array($max);			for($i=1;$i<=$maxG[0];$i++)			{				$query="insert into GROUP_SCORE values('$tut','$i',0,0,0,0,0,0,0,0,0,'')";				mssql_query($query);			}		}				public function s_assign_result($sid,$tut)		{			$conn=db_connect();			$i=0;			$query="select distinct(GROUPID) from STUDENT_GROUP where '$tut'=TUT and GROUPID!='0'";			$ex=mssql_query($query);			while($re=mssql_fetch_array($ex))			{				if($i<count($sid))				{				$topic=$this->getTopic($tut,$re[0]);				if($this->numMember($re[0],$tut)==2)				{					$query="update STUDENT_GROUP set GROUPID=$re[0] where SID=$sid[$i]";					mssql_query($query);					$query="update STUDENT_GROUP set TOPICID=$topic where SID=$sid[$i]";					mssql_query($query);					$i++;				}				}			}		}			public function topicAssign($tut)		{				$query="select distinct(GROUPID) from STUDENT_GROUP where TOPICID='0' and TUT='$tut' and groupid!='0'";			$exe=mssql_query($query);			$result=mssql_num_rows($exe);			$nTopicG=$result;			echo "<p>There are ".$nTopicG." groups which haven't chosen any topic.<br/>";			echo "Help one group choose a topic.</p>";			$t=new Topic();			echo "<form action='t_ass_result.php' method='post'>";			$conn=db_connect();			$query="select TopicID from TOPIC";			$exe=mssql_query($query);			$i=1;						echo "<p>Group ID: <input type='text' name='groupID' /></p>";			echo "<table><tr><td>Topic ID</td><td>Topic Name</td><td></td></tr>";			while($result=mssql_fetch_array($exe))			{				//if(!$t->chosenStatus($tut,$result[0]))				//{					echo "<tr><td>".$result[0]."</td><td>".$t->getName($result[0])."</td><td>";					$t->setID($result[0]);					if(!$t->chosenStatus($tut,$t->getID()) && $i<'10')						echo "<input type='radio' name='topic' value='0".$i."'/>";					if(!$t->chosenStatus($tut,$t->getID()) && $i>='10')						echo "<input type='radio' name='topic' value='".$i."'/>";					echo "</td></tr>";				//}				$i++;			}			echo "</table>";			echo "<input type='submit' value='Submit' /></form>";		}				public function assignTopic($topicChosen,$groupID, $tut)		{			$conn=db_connect();			$i=0;			$query="select GROUPID from STUDENT_GROUP where '$groupID'=groupid and TUT='$tut'" ;			//echo "$topicChosen,$groupID, $tut";			$exe=mssql_query($query);			$result=mssql_num_rows($exe);			if(!$result)				echo "<script type=\"text/javascript\">window.alert(\"Invalid group id.\")</script>";			else{				$query="update STUDENT_GROUP set TOPICID='$topicChosen' where GROUPID='$groupID' and TUT='$tut'";				mssql_query($query);				echo "<script type=\"text/javascript\">window.alert(\"Successfully assigned.\")</script>";			}		}										public function numMember($gid,$tut)		{			$conn=db_connect();			$query="select SID from STUDENT_GROUP where '$gid'=GROUPID and '$tut'=TUT";			$exe=mssql_query($query);			$result=mssql_num_rows($exe);			return $result;		}				public function assgin_grade_table($tut)		{			$query="select MAX(GROUPID) from STUDENT_GROUP where TUT='$tut'";			$exe=mssql_query($query);			$result=mssql_fetch_array($exe);			$numGroup=$result[0];						$conn=db_connect();			for($i=1;$i<=$numGroup;$i++)			{				for($j=1;$j<=5;$j++)				{					$query="insert into GROUP_GRADING_C values('{$i}','{$j}','0','{$tut}')";					$exe=mssql_query($query);				}			}						for($i=1;$i<=$numGroup;$i++)			{				for($j=1;$j<=5;$j++)				{					$query="insert into GROUP_GRADING_D values('{$i}','{$j}','0','{$tut}')";					$exe=mssql_query($query);				}			}						for($i=1;$i<=$numGroup;$i++)			{				for($j=1;$j<=5;$j++)				{					$query="insert into GROUP_GRADING_U values('{$i}','{$j}','0','{$tut}')";					$exe=mssql_query($query);				}			}		}										public function getPresenDate($tut,$groupNum)		{			$conn=db_connect();			$query="select PRESEN_DATE from STUDENT_GROUP where '$tut'=TUT and GROUPID='$groupNum'";			$exe=mssql_query($query);			$result=mssql_fetch_array($exe);			return $result[0];		}				public function numGroup($tut)		{			$conn=db_connect();			$query="select distinct(GROUPID) from STUDENT_GROUP where '$tut'=TUT";			$exe=mssql_query($query);			return mssql_num_rows($exe);		}				public function getTopic($tut,$i)		{			$conn=db_connect();			$query="select TOPICID from STUDENT_GROUP where TUT='$tut' and GROUPID='$i'";			$exe=mssql_query($query);			$result=mssql_fetch_array($exe);			return $result[0];		}				public function getTopicName($tut,$i)		{			if($i!=0)			{			$tid=$this->getTopic($tut,$i);			$t=new Topic();			$name=$t->getName($tid);			return $name;			}			else				return;		}				public function showSchedule($numG,$tut)		{			echo "<p>T0".$tut."</p>";			echo "<table align='center'><tr><td>Group No.</td><td>Group Member</td><td>Topic ID</td><td>Topic Name</td><td>Presentation Date</td></tr>";			for($i=1;$i<=$numG;$i++)			{				echo "<tr><td>".$i."</td>";				$conn=db_connect();				$query="select SID from STUDENT_GROUP where GROUPID='$i' and TUT='$tut'";				$exe=mssql_query($query);				echo "<td>";				while($result=mssql_fetch_array($exe))				{					echo $result[0]." ";				}				echo "</td>";				echo "<td>".$this->getTopic($tut,$i)."</td>";				echo "<td>".$this->getTopicName($tut,$i)."</td>";				echo "<td>".$this->getPresenDate($tut,$i)."</td>";				echo "</tr>";			}			echo "</table>";					}				public function groupScore($tut, $gid){						$topicid= $this->getTopic($tut, $gid);			$topicname= $this->getTopicName($tut,$gid);			$conn=db_connect();			echo "<br/>";			// group scoring...			echo "<table><tr><td>Group No.</td><td>TopicID</td><td>TopicName</td></tr>";			echo "<tr>";			echo "<td>".$gid."</td>"; echo "<td>".$topicid."</td>"; echo "<td>".$topicname."</td>";			echo "</tr>";			echo "</table>";			echo "<p><b> Group Score </b></p>";			echo "<table id='gscore'><tr>";			$query="SELECT Name from GRADING_COMPONENT";			$exe=mssql_query($query);			while($result=mssql_fetch_array($exe))			{				echo "<td>".$result[0]."</td>";			}			echo "</tr>";						$query="SELECT Percentage FROM GRADING_COMPONENT";			$exe=mssql_query($query);			$upper=array();			$comp_count=0;			while($result=mssql_fetch_array($exe))			{				$upper[$comp_count]=$result[0];				$comp_count++;			}						$query="select ITEM1,ITEM2,ITEM3,ITEM4,ITEM5,ITEM6,ITEM7,ITEM8,FINAL,COMMENT from GROUP_SCORE where TUT='$tut' and GROUPID='$gid'";			$exe=mssql_query($query);			$result= mssql_fetch_array($exe);			$item=array();			for($i=0;$i<8;$i++)			{				$item[$i]=0;			}									$final=0.00;						if($result[0]!='-1')				$item[0] = $result[0];			if($result[1]!='-1')				$item[1] = $result[1];			if($result[2]!='-1')				$item[2] = $result[2];			if($result[3]!='-1')				$item[3] = $result[3];			if($result[4]!='-1')				$item[4] = $result[4];			if($result[5]!='-1')				$item[5] = $result[5];			if($result[6]!='-1')				$item[6] = $result[6];			if($result[7]!='-1')				$item[7] = $result[7];			if($result[8]!='-1')				$final = $result[8];						$comment = $result[9];									for($i=1;$i<=$comp_count;$i++)			{				echo "<td><select id='score".$i."' name='score".$i."' onchange='GroupScore()'";				$j=-1;				while($j<=$upper[$i-1])				{					echo "<option value='".$j."' ";					if($j==$item[$i-1])						echo "selected='selected'";					echo ">".$j."</option>";					$j++;				}				echo "</select></td>";			}			echo "<td><input type='text'  id='score_group' size='3' name='score_group' value='".$final."' readonly='readonly'/></td>";					echo "</tr>";			echo "</table>";			echo "<p>Comment:</p>";			//echo "<input type='text' size='50' id='comment' name='comment' value='".$comment."'/>";			$comment=str_replace("doubleQuote", '"', $comment);			$comment=str_replace("singleQuote", "'", $comment);			$comment=str_replace("\\", "", $comment);			echo "<textarea rows='3' cols='60' id='comment' name='comment' >".$comment."</textarea>";			echo "<input type='hidden' name='comp_count' value='$comp_count' />";		}				public function getGradingCount()		{			$conn=db_connect();			$query="SELECT * FROM GRADING_COMPONENT";			$exe=mssql_query($query);			$comp_count=0;			while($result=mssql_fetch_array($exe))			{				$comp_count++;			}			return $comp_count;				}				public function indiScore($tut, $gid){					echo "</table>";			echo "<p><b> Individual Score </b></p>";			echo "<table id='gscore'><tr><td>Student ID</td><td style='width:140px'>Student Name</td><td>Work<br/>Contribution(%)</td><td>Bonus</td><td>Final Score</td></tr>";			// student id obtaining...			$conn=db_connect();			$query="select SID from STUDENT_GROUP where TUT='$tut' and GROUPID='$gid'";			$exe=mssql_query($query);			$count=0;			while($result=mssql_fetch_array($exe)){				$sid= $result[0];				$query1="select Name from STUDENT where SID='$sid'";				$exe1=mssql_query($query1);				$result1=mssql_fetch_array($exe1);				$sname= $result1[0];				echo "<tr><td>".$sid."</td>"; echo "<td>".$sname."</td>";								$query1="select CONTRIBUTION, BONUS, FINAL from STUDENT_SCORE where SID='$sid'";				$exe1=mssql_query($query1);				$result1=mssql_fetch_array($exe1);				$contri=$bonus="0";				$final="0.00";				if($result1[0]!="-1")					$contri=$result1[0];				if($result1[1]!="-1")					$bonus=$result1[1];				if($result1[2]!="-1")					$final=round($result1[2],2);								echo "<td><select  id='contri".$count."' name='contri".$count."' onchange='cal_indi($count)'>";				$i=0;				while($i<=100){					echo "<option value='".$i."' ";					if($i==$contri)						echo "selected='selected'";					echo ">".$i."</option>";					$i++;				}				echo "</select></td>";								echo "<td><select id='bonus".$count."' name='bonus".$count."' onchange='cal_indi($count)'>";				$i=0;				while($i<=100){					echo "<option value='".$i."' ";					if($i==$bonus)						echo "selected='selected'";					echo ">".$i."</option>";					$i++;				}				echo "</select></td>";				echo "<td><input type='text'  id='indiScore".$count."' size='3' name='indiScore".$count."' value='".$final."' readonly='readonly'/></td>";				echo "</tr>";				$count++;			}														echo "</table>";				}				public function assignDate($tut)		{			$conn=db_connect();			//select year			$query="select PRESEN_DATE from TUT_PRESEN where TUT='$tut'";			$exe=mssql_query($query);			$result=mssql_fetch_array($exe);			echo $result[0];		}				public function showPeerTut($numTut)		{			echo "<form action='a_peer_result.php' method='post'>";			echo "Tutorial Section:<select name='tutno'>";			for($i=1;$i<=$numTut;$i++)			{				echo "<option value='".$i."'>".$i."</option>";			}			echo "</select>";			echo "<input type='submit' value='Choose' />";		}				public function getStDate($tut)		{			$conn=db_connect();			$query="select PRESEN_DATE from TUT_PRESEN where '$tut'=TUT";			$exe=mssql_query($query);			$result=mssql_fetch_array($exe);			return $result[0];		}				public function getEndDate($tut)		{			$conn=db_connect();			$query="select PRESEN_DATE from TUT_PRESEN where '$tut'=TUT";			$exe=mssql_query($query);			$result=mssql_fetch_array($exe);			$interval=7*24*60;			$query="select DATEADD(minute,$interval,'{$result[0]}') AS NewDate";			$exe=mssql_query($query);			$result=mssql_fetch_array($exe);			return $result[0];		}														public function withdraw_admin(){			echo "<p>Withdraw a student from a current group</p>";			echo "<form action='withdraw_admin.php' method='post'>";			echo "<p>Student ID:<input type='text' name='toWithdraw' /></p>";			echo "<input type='submit' value='Withdraw' />";			echo "</form>";		}				public function mail_grouping($sid, $gid, $nameList){			$to = "lxian2shell@gmail.com";			$subject = "Test mail";			$message = "hi! student $sid. Your group has been modified by your instructor. Your current group ID: $gid Your current group members: $nameList";			$from = "someonelse@example.com";			$headers = "From: $from";			mail($to,$subject,$message,$headers);		}	}��?>

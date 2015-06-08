<?php

	require_once('lib/user_inc.php');
	require_once('lib/topic_inc.php');
	require_once('lib/student_inc.php');
	require_once('lib/admin_inc.php');

	class Helper extends User

	{
		public function setID($a)

		{

			$this->id=$a;

		}

		

		public function showLogin()

		{
			echo "<div id='login'><form name='hlog' onsubmit='return checkname(document.alog.user.value);'action='helper_main.php' method='post'>";

			echo "Helper ID<br/>";

			echo "<input type='text' name='user'/>";



			echo "<br/>";

			echo "Password<br/><input type='password' name='pass'/>";

			echo "<br/>";

			echo "<input type='submit' value='Login'/>";

			echo "<input type='button' value='Reset' onclick='javascript:checklogin();window.location=\"helper.php\"'/></form></div>";

		}	
		
		public function numTut()

		{

			$conn=db_connect();

			$query="select distinct(TUT) from TUT_INFO";

			$result=mssql_query($query);

			return mssql_num_rows($result);

		}
		
		public function showMarkTable($numTut,$isMark,$adminid)

		{			
			$conn= db_connect();
			$query="select Name from ADMIN where Admin_id='$adminid';";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			$name = $result[0];
			
			if($isMark)
				echo "<form action='markByWeek.php' method='post'>";
			else
				echo "<form action='score.php' method='post'>";

			echo "<p>Tutorial Section:<select name='tutno'></p>";


			$query="select TUT, Location, Time, Staff from TUT_INFO where STAFF LIKE '%$name%'";
			$exe=mssql_query($query);
			while($result=mssql_fetch_array($exe))
			{
				echo "<option value='".$result[0]."'>";
				echo $result[0]."  ".$result[1]."  ".$result[2]."  ".$result[3];
				echo "</option>";
			}
			if($adminid=='super')
			{
                
				$query="select TUT, Location, Time, Staff from TUT_INFO where TUT IS NOT NULL;";
				$exe=mssql_query($query);
				while($result=mssql_fetch_array($exe)){
					echo "<option value='".$result[0]."'>";
					echo $result[0]."  ".$result[1]."  ".$result[2]."  ".$result[3];
					echo "</option>";
				}
			}
			echo "</select>";
			echo "<input type='submit' value='Go' />";	
			echo "</form>";

		
		}
		
		public function showLabByWeek($weekno,$isHelper)
		{
					
			if($isHelper)
				echo "<form action='markByWeek.php' method='post'>";
			else
				echo "<form action='lab.php' method='post'>";
			echo "<p>Week:<select name='weekno'></p>";

			$i=1;
			while($i<=13)
			{
				echo "<option value='".$i."'";
				if($weekno==$i)
					echo "selected='selected'";
				echo ">";
				echo "Week ".$i;
				echo "</option>";
				$i++;
			}
			/*echo "<option value='14'";
			if($weekno==14)
				echo "selected='selected'";
			echo ">";
			echo "All weeks";
			echo "</option>";*/
			echo "</select><br/>";
			echo "<input type='submit' value='Go' />";	
			echo "</form>";
			
		}
		
		function showTotal($isHelper)
		{
			if($isHelper)
			{
				echo "<p>Progress Report:</p>";
				echo "<form action='markByWeek.php' method='post'>";
				echo "<p><input type='radio' name='std' value='single' checked='checked'/>Single Student</p>";
				echo "<p><input type='radio' name='std' value='all' />All Students</p>";
				echo "<input type='submit' value='Go' />";	
				echo "</form>";
			}
		}
		
		
		public function studentTable($tut,$showScore,$weekno,$showSingle,$isSubmitted,$sid)
		{
			if($showSingle==0)
			{
			echo "<p>Students Information<p>";
			echo "<form action='markByWeek.php' method='post'>";
			if($showScore)
			{
				echo "<table><tr><td id='studentTableNo'>No</td><td>Student No</td><td>Name</td>";
				echo "<td>Score</td>";
				echo "<td id='studentTableNo'>No</td><td>Student No</td><td>Name</td>";
				echo "<td>Score</td>";
				echo "</tr>";
			}
			else
			{
				echo "<table><tr><td>Student No</td><td>Name</td>";
				$i=1;
				while($i<14)
				{
					echo "<td>WK".$i."</td>";
					$i++;
				}
				echo "<td>Total Score</td><td>Total Completion</td></tr>";
			}
			if($showScore)
			{
			$i=1;
			$query="select SID from STUDENT_GROUP where '$tut'=TUT";
			$exe=mssql_query($query);
			echo "<tr>";
			$j=0;
			while($result=mssql_fetch_array($exe))
			{	
				$query1="select NAME from STUDENT where SID='$result[0]'";
				$exe1=mssql_query($query1);
				$result1=mssql_fetch_array($exe1);
				if(($i-1)%2==0)
					echo "</tr><tr>";
				echo "<td id='studentTableNo'> ".$i." </td><td>  ".$result[0]."  </td><td>  ".$result1[0]."  </td>";
				if($showScore)
				{
					$query2="select Helper_score from LAB_SCORE where SID='$result[0]' AND Week=$weekno";
					$exe2=mssql_query($query2);
					$result2=mssql_fetch_array($exe2);
					//$indiScore= $result2[0];
				}
				else
				{
					$query2="select SUM(Helper_score) from LAB_SCORE where SID='$result[0]'";
					$exe2=mssql_query($query2);
					$result2=mssql_fetch_array($exe2);
				}
				//<input type='checkbox' name='random[]' value='".$result[0]."' /></td></tr>";				
				if($showScore)
				{
					if($result2[0]==1)
					{
						echo "<td><input type='radio' name='score[$j]' value='1' checked='checked' />1";
						echo "<input type='radio' name='score[$j]' value='2' />2";
						echo "<input type='radio' name='score[$j]' value='3' />3";
						echo "<input type='radio' name='score[$j]' value='4' />4";
						echo "<input type='radio' name='score[$j]' value='5' />5</td>";
					}
					else if($result2[0]==2)
					{
						echo "<td><input type='radio' name='score[$j]' value='1'/>1";
						echo "<input type='radio' name='score[$j]' value='2' checked='checked' />2";
						echo "<input type='radio' name='score[$j]' value='3' />3";
						echo "<input type='radio' name='score[$j]' value='4' />4";
						echo "<input type='radio' name='score[$j]' value='5' />5</td>";
					}
					else if($result2[0]==3)
					{
						echo "<td><input type='radio' name='score[$j]' value='1'/>1";
						echo "<input type='radio' name='score[$j]' value='2'/>2";
						echo "<input type='radio' name='score[$j]' value='3' checked='checked' />3";
						echo "<input type='radio' name='score[$j]' value='4' />4";
						echo "<input type='radio' name='score[$j]' value='5' />5</td>";
					}
					else if($result2[0]==4)
					{
						echo "<td><input type='radio' name='score[$j]' value='1'/>1";
						echo "<input type='radio' name='score[$j]' value='2'/>2";
						echo "<input type='radio' name='score[$j]' value='3'/>3";
						echo "<input type='radio' name='score[$j]' value='4' checked='checked' />4";
						echo "<input type='radio' name='score[$j]' value='5' />5</td>";
					}
					else if($result2[0]==5)
					{
						echo "<td><input type='radio' name='score[$j]' value='1'/>1";
						echo "<input type='radio' name='score[$j]' value='2'/>2";
						echo "<input type='radio' name='score[$j]' value='3'/>3";
						echo "<input type='radio' name='score[$j]' value='4'/>4";
						echo "<input type='radio' name='score[$j]' value='5' checked='checked' />5</td>";
					}
					else
					{
						echo "<td><input type='radio' name='score[$j]' value='1'/>1";
						echo "<input type='radio' name='score[$j]' value='2'/>2";
						echo "<input type='radio' name='score[$j]' value='3'/>3";
						echo "<input type='radio' name='score[$j]' value='4'/>4";
						echo "<input type='radio' name='score[$j]' value='5'/>5</td>";
					}
					
					$j++;
				}
				else
				{
					echo "<td>$result2[0]</td>";
					//echo "<td></td>";
				}
				if(!$showScore)
				{
					$s1=false;
					$query3="select Helper_score from LAB_SCORE where SID='$result[0]'";
					$exe3=mssql_query($query3);
					while($result3=mssql_fetch_array($exe3))
					{
						if($result3[0]>0)
							$s1=true;
					}
					if($s1)
						echo "<td>1</td>";
					else
						echo "<td>0</td>";
				}
				
				$i++;

			}
			echo "</tr>";
			}
			else
			{
				$query="select SID from STUDENT where Tut='$tut'";
				$exe=mssql_query($query);
				while ($result=mssql_fetch_array($exe))
				{
					$sid=$result[0];
					$query1="select Name from STUDENT where Tut='$tut' and SID='$result[0]'";
					$exe1=mssql_query($query1);
					$result1=mssql_fetch_array($exe1);
					echo "<tr><td>".$sid."</td><td>".$result1[0]."</td>";
		
					$i=1;
					$count=0;
					while($i<14)
					{
						$query2="select Helper_score from LAB_SCORE where SID='$sid' and Week=$i";
						$exe2=mssql_query($query2);
						$result2=mssql_fetch_array($exe2);
						
						echo "<td>".$result2[0]."</td>";
						if($result2[0]>0)
						{
							$count++;
						}	
						$i++;
					}
					$query3="select SUM(Helper_score) from LAB_SCORE where SID='$sid'";
					$exe3=mssql_query($query3);
					$result3=mssql_fetch_array($exe3);
					echo "<td>".$result3[0]."</td><td>".$count."</td></tr>";
				}
			}
			
			echo "</table>";
			if($showScore)
				echo "<input type='submit' value='Mark' /></form>";
			}
			else if($isSubmitted==0)
			{
				echo "<form action='markByWeek.php' method='post'>";
				echo "<p>Please enter Student ID: </p>";
				echo "<input type='text' name='sid' />";
				echo "<input type='submit' value='Submit'/>";
				echo "</form>";
			}
			else
			{
				echo "<form action='markByWeek.php' method='post'>";
				echo "<table><tr><td>Student No</td><td>Name</td>";
				$i=1;
				while($i<14)
				{
					echo "<td>WK".$i."</td>";
					$i++;
				}
				echo "<td>Total Score</td><td>Total Completion</td></tr>";
				$query1="select NAME from STUDENT where SID='$sid'";
				$exe1=mssql_query($query1);
				$result1=mssql_fetch_array($exe1);
				
				echo "<tr><td>".$sid."</td><td>".$result1[0]."</td>";
		
				$i=1;
				$count=0;
				while($i<14)
				{
						$query2="select Helper_score from LAB_SCORE where SID='$sid' and Week=$i";
						$exe2=mssql_query($query2);
						$result2=mssql_fetch_array($exe2);
						
						echo "<td>".$result2[0]."</td>";
						if($result2[0]>0)
						{
							$count++;
						}	
						$i++;
				}
				$query3="select SUM(Helper_score) from LAB_SCORE where SID='$sid'";
				$exe3=mssql_query($query3);
				$result3=mssql_fetch_array($exe3);
				echo "<td>".$result3[0]."</td><td>".$count."</td></tr>";
				echo "</table>";
				echo "</form>";
			}
		}
		
		function processScore($tut,$weekno,$scoreArr,$code)
		{
			$conn=db_connect();
			$query="select SID from STUDENT_GROUP where '$tut'=TUT";
			$exe=mssql_query($query);
			
			$i=0;
			while($result=mssql_fetch_array($exe))
			{
				//echo $scoreArr[$i];
				$int_score=(int)$scoreArr[$i];
				$searchQuery="SELECT SID FROM LAB_SCORE WHERE Tut_ID='$tut' AND Week=$weekno AND SID=$result[0]";
				$exe1=mssql_query($searchQuery);
				$result1=mssql_fetch_array($exe1);
				if((int)$result1[0]>0)
					$query="UPDATE LAB_SCORE SET Helper_score=".$int_score.", Lab_code='$code' WHERE SID='$result[0]' AND Tut_ID='$tut' AND Week=$weekno";
				else
					$query="INSERT INTO LAB_SCORE VALUES('$result[0]','$tut',0,".$int_score.",NULL,".$weekno.",'$code')";
				mssql_query($query);
				$i++;
			}
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
			//echo "<input type='submit' value='Mark' />";
			//echo "</form>";
			echo "</td></tr></table>";
		}
		
		function helperMark($weekno,$tut,$sid)
		{
			//echo $weekno." ".$tut." ".$sid; 
			echo "<p>Mark (From Teaching Assistant):</p>";
			echo "<table><tr><td>";
			//echo "<form action='lab.php' method='post'>";
			$conn=db_connect();
			$query="select Helper_score from LAB_SCORE where SID='$sid' AND Week=$weekno";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			echo "<p>Mark:</p>";
					if($result[0]==1)
					{
						echo "<input type='radio' name='hScore' value='1' checked='checked' />1";
						echo "<input type='radio' name='hScore' value='2' />2";
						echo "<input type='radio' name='hScore' value='3' />3";
						echo "<input type='radio' name='hScore' value='4' />4";
						echo "<input type='radio' name='hScore' value='5' />5";
					}
					else if($result[0]==2)
					{
						echo "<input type='radio' name='hScore' value='1'/>1";
						echo "<input type='radio' name='hScore' value='2' checked='checked' />2";
						echo "<input type='radio' name='hScore' value='3' />3";
						echo "<input type='radio' name='hScore' value='4' />4";
						echo "<input type='radio' name='hScore' value='5' />5";
					}
					else if($result[0]==3)
					{
						echo "<input type='radio' name='hScore' value='1'/>1";
						echo "<input type='radio' name='hScore' value='2'/>2";
						echo "<input type='radio' name='hScore' value='3' checked='checked' />3";
						echo "<input type='radio' name='hScore' value='4' />4";
						echo "<input type='radio' name='hScore' value='5' />5";
					}
					else if($result[0]==4)
					{
						echo "<input type='radio' name='hScore' value='1'/>1";
						echo "<input type='radio' name='hScore' value='2'/>2";
						echo "<input type='radio' name='hScore' value='3'/>3";
						echo "<input type='radio' name='hScore' value='4' checked='checked' />4";
						echo "<input type='radio' name='hScore' value='5' />5";
					}
					else if($result[0]==5)
					{
						echo "<input type='radio' name='hScore' value='1'/>1";
						echo "<input type='radio' name='hScore' value='2'/>2";
						echo "<input type='radio' name='hScore' value='3'/>3";
						echo "<input type='radio' name='hScore' value='4'/>4";
						echo "<input type='radio' name='hScore' value='5' checked='checked' />5";
					}
					else
					{
						echo "<input type='radio' name='hScore' value='1'/>1";
						echo "<input type='radio' name='hScore' value='2'/>2";
						echo "<input type='radio' name='hScore' value='3'/>3";
						echo "<input type='radio' name='hScore' value='4'/>4";
						echo "<input type='radio' name='hScore' value='5'/>5";
					}
			//echo "<input type='text' name='hScore' value='".$result[0]."' />";
			echo "<br/>";
			echo "<p>Marking Code:</p>";
			echo "<input type='password' name='code' value=''/>";
			echo "<br/>";
			echo "<input type='submit' value='Mark' />";
			echo "</form>";
			echo "</td></tr></table>";
		}
		
		function indiScore($tut,$weekno,$score,$sid,$code)
		{
			$conn=db_connect();
			$searchQuery="SELECT SID FROM LAB_SCORE WHERE Tut_ID='$tut' AND Week=$weekno AND SID=$sid";
			$exe=mssql_query($searchQuery);
			$result=mssql_fetch_array($exe);
			if((int)$result[0]>0)
				$query="UPDATE LAB_SCORE SET Helper_score=".$score." ,Lab_code='$code' WHERE SID='$sid' AND Tut_ID='$tut' AND Week=$weekno";
			else
				$query="INSERT INTO LAB_SCORE VALUES('$sid','$tut',0,".$score.",NULL,".$weekno.",'$code')";
			mssql_query($query);
			
		}
		
		function codeMatch($code)
		{
			$conn=db_connect();
			$query="SELECT Lab_ID FROM LAB_CODE WHERE Lab_Code='$code'";
			$exe=mssql_query($query);
			$result=mssql_fetch_array($exe);
			if($result!=null)
				return true;
			else
				return false;
		
		}
	}
	
?>
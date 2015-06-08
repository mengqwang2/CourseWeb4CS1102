<?php

	require_once('lib/opt_inc.php');

	require_once('lib/student_inc.php');
	session_start();
	showHeader();
	showTitle("CS1102 Introduction to Computer Studies");
	check_valid_user(1);
	if(isset($_SESSION['valid_user'])){
		if($_SESSION['isad']==1){
			
			$buttons = array("Lab"=>"helper_main.php",
					"Schedule"=>"admin_main.php",
					"Score"=>"score_main.php",
					"Logout"=>"logout.php");

			showMenu($buttons,'0');
			
		}
		else{
				/*$buttons = array("Grouping"=>"group_main.php",
					"Topics"=>"s_topics.php",
					"Schedule"=>"schedule.php",
					"Lab"=>"lab.php",
					"Account"=>"account.php",
					"Logout"=>"logout.php");
*/
	$buttons = array("Lab"=>"lab.php",
					"Account"=>"account.php",
					"Logout"=>"logout.php");

			showMenu($buttons,'0');
		}
	}
	else{
		$buttons = array("Student"=>"index.php",

					"Instructor"=>"admin.php");

		showMenu($buttons,'0');
	}
	echo "<div id='howto'>";
	echo "<h4> How to use this system... (FAQ)</h4>";

	echo "<p id='question'><b>1. What is my login ID and password?</b></p>";
	echo "<p>The login ID is your student ID, and the default password is also your student ID. You are suggested to reset 
your password upon the first login.</p>";

	echo "<p id='question'><b>2. How can I form a group?</b></p>";
	echo "<p>Once you have logged in, click the \"Grouping\" link on the top menu bar. Then enter the student ID and grouping 
code of the student you want to add into your group. Note that the grouping only needs to be done <b>ONCE</b> by <b>ONE</b> member. 
</p>";
	
	echo "<p id='question'><b>3. What's a grouping code?</b></p>";
	echo "<p>The grouping code is used for security purpose. Someone else must provide your grouping code when adding you as 
his/her group member. The <b>default</b> grouping code is your student ID. You are suggest to reset your grouping code upon the 
first login.</p>";
	
	echo "<p id='question'><b>4. When I add a group member, why does it report the student has already joined in a group?</b></p>";
	echo "<p>If a student has already joined a group, he/she cannot be added again into another group.</p>";
	
	echo "<p id='question'><b>5. Why someone cannot add me into his/her group?</b></p>";
	echo "<p>Check if you have already been added into a group. If so, you can withdraw from your current group by clicking 
the \"Withdraw\" button in the \"Group\" page. </p>";
	
	echo "<p id='question'><b>6. Can I join an existing group?</b></p>";
	echo "<p>Yes, you can. But you cannot do it by adding a member of that group via your account. Instead, you should ask 
any student in that group to add you.</p>";
	
	echo "<p id='question'><b>7. Can I quit my current group and form a new one??</b></p>";
	echo "<p>Yes, you can. Go to the \"Group\" page to click the \"Withdraw\" button. <b>BUT</b> think twice before you do that. 
After withdrawing, you are <b>no</b> longer in any group. If one group only has two members left, the topic selected by that group will 
be <b>released out and become available</b>. </p>";
	
	echo "<p id='question'><b>8. How can my group choose a topic?</b></p>";
	echo "<p>You can go to the \"Topics\" page, and select any available topic from the table. Note that the topic-selection 
only needs to be done <b>ONCE</b> by <b>ONE</b> member.</p>";

	echo "<p id='question'><b>9. Can my group change to another topic?</b></p>";
	echo "<p>Yes, you can. <b>Any</b> member of your group can go to the \"Topic\" page, and choose an <b>available</b> topic 
from the topic table. Note that after presentation schedule has been assigned, the topic-choice will be <b>FINAL and 
unchangable.</b></p>";

	echo "<p id='question'><b>10. Why I cannot choose a topic?</b></p>";
	echo "<p>Check if your group has less than three members.</p>";

	echo "<p id='question'><b>11. Why does the presentation date show \"Not Assigned\" in the \"Schedule\" page?</b></p>";
	echo "<p>Because the lab-instructor hasn't assigned it yet. We shall wait until all the groups and topics have been 
confirmed. Note that the topics are in a fixed order. Topics with smaller IDs will be presented earlier.</p>";

	echo "<p id='question'><b>12. Where can I modify my password and my grouping code?</b></p>";
	echo "<p>Click the \"Account\" link on the top menu bar.</p>";

	echo "<p id='question'><b>13. I and my group members cannot log in using the same computer. Why?</b></p>";
	echo "<p>Because of the cookie setting, you need to log out first or open another browser window for yoru group member to 
log in.</p>";

	
	echo "</div>";
	showFooter();

?>

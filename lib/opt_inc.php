<?php
	session_start();
	
	function showHeader()
	{
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
				<? session_start() ?>
				<html xmlns='http://www.w3.org/1999/xhtml'>
				<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<title>CS1102</title>
					<script  runat= 'server'>
						function checkname(name){
							if(name==''){
								alert('Please insert a user name.');
								return false;
							}
							return true;
						}
						function reload(){
							window.location.reload();
						}
						function groupSort(){
							\"<?$"."_SESSION['sort']=1;?>\"
						}
						function topicSort(){
							\"<?$"."_SESSION['sort']=0;?>\"
						}
						function cal_indi(i){
							if(document.getElementById('contri'+i)==null)
								return;
							var contri_list=document.getElementById('contri'+i);
							var bonus_list=document.getElementById('bonus'+i);
							
							var contri= parseInt(contri_list.options[contri_list.selectedIndex].text);
							var bonus= parseInt(bonus_list.options[bonus_list.selectedIndex].text);
							
							
							var tot=bonus+ contri*document.getElementById('score_group').value/100;
							if(tot > 100)
								alert('the final scores for students exceeded 100');
							document.getElementById('indiScore'+i).value = tot.toFixed(2);
						}						
					</script>
				</head>";
		echo "<link rel='stylesheet' href='css/main.css' type='text/css' media='screen'/>";
		echo "<body ><div id='mainContent'>";
	}
	
	function showHeader1($comp_count)
	{
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
				<html xmlns='http://www.w3.org/1999/xhtml'>
				<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<title>CS1102</title>

		echo "var count=".$comp_count.";";
						
							
							
							var item_list=new Array();
							var item_value=new Array();
							for(var i=1;i<=count;i++)
							{
								var id='score'+i;
								item_list[i-1]=document.getElementById(id);
							}
							
							
							
							for(var i=1;i<=count;i++)
							{
								item_value[i-1]=parseInt(item_list[i-1].options[item_list[i-1].selectedIndex].text);
							}
							
			
							var tot=0;
							for(var i=0;i<count;i++)
							{
								tot+=item_value[i];
							}
							
							
						
						function checkPercent(theForm)
						{
							/*var total=0;
							
							
							if(total<100)
							{
								alert('Total percent is less than 100');
								return false;
							}
							else if(total>100)
							{
								alert('Total percent is more than 100');
								return false;
							}
							
							return true;*/
							
							
						
						}
				</head>";
		echo "<link rel='stylesheet' href='css/main.css' type='text/css' media='screen'/>";
		echo "<body ><div id='mainContent'>";
	}
	
	function showTitle($a)
	{
		echo "<p id='title'>".$a."</p>";
	}
		
	function showFooter()
	{
		echo "</div><footer>
	}
	
	function showMenu($buttons,$opt) {
		echo '<div id="nav'.$opt.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		while( list($name,$url) = each($buttons)) {
			$width = 100/count($buttons);
			$res = IsURLCurrentPage($url);
			//do_html_url($name,$url,!$res,$opt); // four parameters ?
		}
		echo "</div><div id='submit_field'>";
	}

	function do_html_url($name, $url, $active = true) {
		if ($active) 
		{
			echo '<a href = "'.$url.'">'.$name.'</a>';
		} 
		else 
		{
			echo '<a href = "#">'.$name.'</a>';
		}
	}

	function IsURLCurrentPage($url) {
		if (strpos($_SERVER['PHP_SELF'],$url)==false) {
			return false;
		} else {
			return true;
		}
	}
	
	

?>
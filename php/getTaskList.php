<?php
include('configDB.php');
$info_array=array();
$info_array2=array();

/* Get Super User flag from User table*/
$super_user=1;
	
$result=$task_database->getTaskList($_GET['task_id'], $_GET['task_ud'], $_GET['importance'],
			$_GET['urgency'], $_GET['status'], $_GET['type'], $_GET['requestedby'], $_GET['assignedto']);
		
if(!is_array($result))
{
	echo substr($result, 1, strlen($result)-1);
}
else
{
	$info_array=$result;
	
	$taskCount=0;
	$holdTaskID="";

	echo "<div id=\"taskListContent\">";

	$trClass="trGrey";

	if($super_user==1)
	{
		echo "<table class=\"tabTaskCompact\" width=\"100%\">";

		foreach ($info_array as $record)
		{
			if($holdTaskID!=$record['task_id'] || $holdTaskID=="")
			{
				if($holdTaskID!="")
				{
					if($taskEstimatedHours>$totTaskHours)
					{
						$pcntComplete=($totHours/$taskEstimatedHours)*100;
						echo "<span class=\"smallGrey\">".number_format($pcntComplete)."% complete</span>";
					}
					else
					{
						if($taskEstimatedHours!="")
						{	
							$underEst=$totHours-$taskEstimatedHours;
							echo "<span class=\"smallGrey\">Underestimated by ".number_format($underEst)." hours</span>";
						}
					}

					$taskEstimatedHours="";
					$totTaskHours=0;

					// Close out previous task
							echo "</div>";
						echo "</td>";
						$taskCount++;
					echo "</tr>";
				}

				// Open new task
				$holdTaskID=$record['task_id'];
				echo "<tr class=\"".$trClass."\">";
				
				echo "<td width=\"100%\">";
				
					echo "<div style=\"width:2.5%; float:left; text-align:right; padding-right:1em;\">";
						echo "<span class=\"smallGrey\">".$holdTaskID.".</span>";
					echo "</div>";

						echo "<div style=\"width:30%; float:left; padding-right:1em;\">";
							echo "<input type=\"text\" id=\"task_ud".$holdTaskID."\" name=\"task_ud".$holdTaskID."\" class=\"task_ud\" value=\"".$record['task_ud']."\" maxlength=\"32\" onkeyup=\"jTaskDirty(".$holdTaskID.")\"></input>";
							echo "<br />";
							echo "<span class=\"smallGrey\">Requested by ";
							
							echo "<input type=\"text\" id=\"requested_by".$holdTaskID."\" name=\"requested_by".$holdTaskID."\" size=\"9\" value=\"".$record['requested_by']."\" onkeyup=\"jTaskDirty(".$holdTaskID.")\"></input>";

							echo " on ".$record['date_created']."</span>";
							echo "<br /><p>";
							echo "<textarea type=\"text\" id=\"task_desc".$holdTaskID."\" name=\"task_desc".$holdTaskID."\" rows=\"2\" cols=\"70\" class=\"add_task_nm\" maxlength=\"256\"  onkeyup=\"jTaskDirty(".$holdTaskID.")\">".$record['task_desc']."</textarea></p>";

							echo "Estimated<br />";

							echo "<small>Start:</small><input type=\"text\" class=\"txtDate\" id=\"estimated_date_start".$holdTaskID."\" name=\"estimated_date_start".$holdTaskID."\"  value=\"".substr($record['estimated_date_start'],0,10)."\" onkeyup=\"jTaskDirty(".$holdTaskID.")\"></input>";

							echo "&nbsp;<small>End:</small><input type=\"text\" class=\"txtDate\" id=\"estimated_date_complete".$holdTaskID."\" name=\"estimated_date_complete".$holdTaskID."\" value=\"".substr($record['estimated_date_complete'],0,10)."\" onkeyup=\"jTaskDirty(".$holdTaskID.")\"></input>";

							echo "&nbsp;<small>Hours:</small><input type=\"text\" id=\"estimated_hours".$holdTaskID."\" class=\"txtHours\" name=\"estimated_hours".$holdTaskID."\"  value=\"".$record['estimated_hours']."\" onkeyup=\"jTaskDirty(".$holdTaskID.")\"></input>";
	/*
							echo "<br /><br />Actual<br />";

							echo "<small>Start:</small><input type=\"text\" id=\"date_started".$holdTaskID."\" name=\"date_started".$holdTaskID."\" class=\"txtDate\" value=\"".substr($record['date_started"),0,10)."\" onkeyup=\"jTaskDirty(".$holdTaskID.")\"></input>";

							echo "&nbsp;<small>End:</small><input type=\"text\" id=\"date_completed".$holdTaskID."\" name=\"date_completed".$holdTaskID."\" class=\"txtDate\" value=\"".substr($record['date_completed'],0,10)."\" onkeyup=\"jTaskDirty(".$holdTaskID.")\"></input>";
	*/
						echo "</div>";

						echo "<div style=\"width:10%; float:left; padding-right:1em;\">";
							echo "<p>Importance:";
							echo "<select class=\"sel\" id=\"task_importance_id".$holdTaskID."\" name=\"task_importance_id".$holdTaskID."\" onchange=\"jTaskDirty(".$holdTaskID.")\">";
								$importance_id=$record['task_importance_id'];
								include('importance_drop_down.php');
							echo "</select>";
							echo "</p><p>Urgency:";
							echo "<select class=\"sel\" id=\"task_urgency_id".$holdTaskID."\" name=\"task_urgency_id".$holdTaskID."\"  onchange=\"jTaskDirty(".$holdTaskID.")\">";
								$urgency_id=$record['task_urgency_id'];
								include('urgency_drop_down.php');
							echo "</select>";
							echo "<br />Target Date:";
							echo "</p><p><input type=\"text\" id=\"deadline_date".$holdTaskID."\" name=\"deadline_date".$holdTaskID."\" class=\"task_date\" value=\"".substr($record['deadline_date'],0,10)."\" onkeyup=\"jTaskDirty(".$holdTaskID.")\"></input></p>";
						echo "</div>";

						echo "<div style=\"width:10%; float:left; padding-right:1em;\">";
							echo "<p>Type:";
							echo "<select class=\"sel\" id=\"task_type_id".$holdTaskID."\" name=\"task_type_id".$holdTaskID."\" onchange=\"jTaskDirty(".$holdTaskID.")\">";
								$task_type_id=$record['task_type_id'];
								include('task_type_drop_down.php');
							echo "</select>";
							echo "</p><p>Status:";
							echo "<span class=\"old_status\" id=\"old_status".$holdTaskID."\" name=\"old_status".$holdTaskID."\" >".$record['task_status_id']."</span>";
							echo "<select class=\"sel\" id=\"task_status_id".$holdTaskID."\" name=\"task_status_id".$holdTaskID."\" onchange=\"jTaskDirty(".$holdTaskID.")\">";
								$task_status_id=$record['task_status_id'];
								include('status_drop_down.php');
							echo "</select>";
							echo "</p><p>Assign to:";
							echo "<select class=\"sel\" id=\"assign_to".$holdTaskID."\" name=\"assign_to".$holdTaskID."\" onchange=\"jTaskAssignDirty(".$holdTaskID.")\">";
								echo "<option value=\"0\" selected=\"selected\"></option>";
								$task_assignedto_id=0;
								include('assignedto_drop_down.php');
							echo "</select></p>";
						echo "</div>";

						echo "<div style=\"width:7.5%; float:left; padding-right:1em;\">";
							echo "<br /><a class=\"btnDis\" id=\"saveTask".$holdTaskID."\" name=\"saveTask".$holdTaskID."\" onclick=\"jLoading(); jSaveTask(".$holdTaskID."); jLoaded(); return false;\">Save</a>";
							echo "<br /><br /><br />";
							echo "<br /><br />";
							echo "<a class=\"btnDis\" id=\"addAssign".$holdTaskID."\" name=\"addAssign".$holdTaskID."\" onclick=\"jLoading(); jaddAssignTask(".$holdTaskID."); jLoaded(); return false;\">Assign</a>";
						echo "</div>";

					echo "<div style=\"width:30%; float:left;\">";

				if($trClass=="trGrey")
				{	$trClass="";	}
				else
				{	$trClass="trGrey";	}
			
			}

			if($super_user==1)
			{	
				echo "<div class=\"assigned\">";
					echo "<p><span class=\"smallBlack\">";
					if($record['assigned_to']!="")
					{
						echo "Assigned to <b>".$record['assigned_to']."</b>";
						if($record['date_assigned']!='')
						{	echo " on ".substr($record['date_assigned'],0,10);	}
						echo "</span>";
						echo "&nbsp;<a class=\"btnRemove\" onclick=\"jRmvAss(".$record['task_assign_id']."); return false;\">Remove</a></p>";
						echo "<p class='pHours'>";
						echo "<input type=\"text\" id=\"add_hours_date".$record['task_assign_id']."\" name=\"add_hours_date".$record['task_assign_id")."\" class=\"txtDate\" value=\"".date("m/d/Y']."\" onkeyup=\"jAddHoursDirty(".$record['task_assign_id'].")\"></input>&nbsp;";
						echo "<input type=\"text\" id=\"add_hours".$record['task_assign_id']."\" name=\"add_hours".$record['task_assign_id']."\" class=\"txtHours\" value=\"\" onkeyup=\"jAddHoursDirty(".$record['task_assign_id'].")\"></input>";
						echo "&nbsp;<a class=\"btnDis\" id=\"addHours".$record['task_assign_id']."\" name=\"addHours".$record['task_assign_id']."\" onclick=\"jLoading(); jaddHours(".$record['task_assign_id']."); jLoaded(); return false;\">Add</a></p>";
					
						$result2=$task_database->getTaskAssignHours($record['task_assign_id']);
						
						$totHours=0;
						echo "<div class=\"assHours\"><table class=\"tabSmall\">";
		//				echo "<tr><th>Hours</th><th></th></tr>";	
						
						if(!is_array($result))
						{
							$info_array2=result2;
							foreach ($info_array2 as $record2)
							{	
								echo "<tr>";
								echo "<td class=\"tdCenter\">".$record2['hours']."</td>";
								echo "<td class=\"tdCenter\">&nbsp;&nbsp;".substr($record2['date'],5,2)."/".substr($record2['date'],8,2)."/".substr($record2['date'],0,4)."</td>";
								echo "</tr>";	
							
								$totHours+=$record2['hours'];
							}
						}
						if($totHours>0)
						{	echo "<tr><td class=\"tdCenter\"><b>".$totHours."</b></td><td>&nbsp;&nbsp;hours total</td></tr>";	}
						echo "</table></div>";
					}
					else
					{
						echo "This task has not been assigned to anyone yet";
					}

				echo "</div>";
				
				if($record['estimated_hours']!="")
				{	$taskEstimatedHours+=$record['estimated_hours'];	}
				$totTaskHours+=$totHours;
			}
		}

		// Close out last task
					if($taskEstimatedHours>$totTaskHours)
					{
						$pcntComplete=($totHours/$taskEstimatedHours)*100;
						echo "<span class=\"smallGrey\">".number_format($pcntComplete)."% complete</span>";
					}
					else
					{
						if($taskEstimatedHours!="")
						{	
							$underEst=$totHours-$taskEstimatedHours;
							echo "<span class=\"smallGrey\">Underestimated by ".number_format($underEst)." hours</span>";
						}
					}

					$taskEstimatedHours="";
					$totTaskHours=0;

				echo "</div>";
			echo "</td>";
		echo "</tr>";

		echo "</table>";

		$taskCount++;
	}
	else
	{
		echo "<table class=\"tabTask\" width=\"100%\">";

		foreach ($info_array as $record)
		{
			if($holdTaskID!=$record['task_id'])
			{
				if($holdTaskID!="")
				{
					// Close out previous task
						$taskCount++;
						echo "</td>";
					echo "</tr>";
				}

				// Open new task
				$holdTaskID=$record['task_id'];
				echo "<tr class=\"".$trColor."\">";
				
					echo "<td width=\"25%\">";
						echo $record['task_ud'];
						echo "<br />";
						echo $record['task_desc'];
					echo "</td>";
					echo "<td width=\"5%\">";
						echo $record['task_importance_id'];
					echo "</td>";
					echo "<td width=\"5%\">";
						echo $record['task_urgency_id'];
					echo "</td>";
					echo "<td width=\"5%\">";
						echo $record['task_type_id'];
					echo "</td>";
					echo "<td width=\"5%\">";
						echo $record['task_status_id'];
					echo "</td>";
					echo "<td width=\"25%\">";
						echo "Requested by ";
						echo $record['requested_by'];
						echo " on ".substr($record['date_created'],0,10);
						if($record['assigned_to']!="")
						{
							echo "<br />Assigned to ".$record['assigned_to']." on ".substr($record['date_assigned'],0,10);
						}
			}
			else
			{	echo "<br />Assigned to ".$record['assigned_to']." on ".substr($record['date_assigned'],0,10);		}

			if($trClass=="trGrey")
			{	$trClass="";	}
			else
			{	$trClass="trGrey";	}

		}
		
			// Close out last task
				echo "</td>";
			echo "</tr>";

		echo "</table>";
		$taskCount++;

	}

	echo "</div>";

	echo "&nbsp;<span class=\"smallGrey\">".$taskCount." tasks";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;".$sqlquery."</span>";
}

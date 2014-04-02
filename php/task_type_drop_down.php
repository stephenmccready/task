<?php

$info_array=$task_database->getTaskType();

foreach ($info_array as $record)
{
	$selected="";
	if($task_type_id==$record[0])
	{	$selected=" selected=\"selected\" ";	}
	echo "<option value=\"".$record[0]."\" ".$selected.">".$record[1]."</option>";
}

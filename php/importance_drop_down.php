<?php

$info_array=$task_database->getImportance();

foreach ($info_array as $record)
{
	$selected="";
	if($importance_id==$record['importance_id'])
	{	$selected=" selected=\"selected\" ";	}
	echo "<option value=\"".$record['importance_id']."\" ".$selected.">".$record['importance_ud']."</option>";
}

<?php

$info_array=$task_database->getAssignedTo(1);

foreach ($info_array as $record)
{
	echo "<option value=\"".$record['assigned_to_id']."\" ".$selected.">".$record['user_nm']."</option>";
}

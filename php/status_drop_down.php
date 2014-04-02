<?php

$info_array=$task_database->getStatus();

foreach ($info_array as $record)
{
	echo "<option value=\"".$record[0]."\" ".$selected.">".$record[1]."</option>";
}

<?php

$info_array=$database->getRequestedBy(1);

echo "<option value=\"0\">Select...</option>";

foreach ($info_array as $record)
{
	$selected="";
	echo "<option value=\"".$record['requested_by_id']."\">".$record['user_nm']."</option>";
}

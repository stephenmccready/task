<?php
include('configDB.php');

$date_created=date('Y-m-d H:i:s');

$result=$task_database->insertTask(str_replace("'","''",urldecode($_GET['task_ud'])), 
								str_replace("'","''",urldecode($_GET['task_nm'])), 
								str_replace("'","''",urldecode($_GET['desc'])),
								$_GET['importance'],
								$_GET['urgency'],
								$_GET['status'],
								$_GET['dept'],
								$_GET['section'],
								$_GET['deadline'],
								$_GET['date_started'],
								$_GET['date_completed'],
								$_GET['requestedby'],
								$_GET['type'],
								$_GET['est_hours'],
								$_GET['est_date_start'],
								$_GET['est_date_complete'],
								$_GET['user1'], 
								$_GET['user2'], 
								$_GET['user3'], 
								$_GET['user4'], 
								$_GET['user5'],
								$date_created,
								$_GET['createdby'] );

if(substr($result, 0, 1)=="0")
{
	echo substr($result, 1, strlen($result)-1);
}
else
{
	echo $date_created . "\n New task created with task ID = " . $result;
}

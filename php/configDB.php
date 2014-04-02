<?php
date_default_timezone_set('America/New_York');

define("DB_SERVER", "host server name");
define("DB_USER", "user name");
define("DB_PASS", "password");
define("DB_NAME", "database name");

class MySQLDB
{
	var $connection; //The MySQL database connection

	//constructor
	function MySQLDB()
	{
		/* Make connection to database */
		$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
		mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
	}
	
	function getImportance()
	{
		$q = "Select * From tbl_importance Order By sort_order";

		$result = mysql_query($q, $this->connection);
		$info_array = array();
		while($dbarray=mysql_fetch_array($result))
		{	$info_array[] = $dbarray;	}
		
		return $info_array;
	}
	
	function getUrgency()
	{
		$q = "Select * From tbl_urgency Order By sort_order";

		$result = mysql_query($q, $this->connection);
		$info_array = array();
		while($dbarray=mysql_fetch_array($result))
		{	$info_array[] = $dbarray;	}
		return $info_array;
	}
	
	function getTaskType()
	{
		$q = "Select * From tbl_task_type Order By sort_order";

		$result = mysql_query($q, $this->connection);
		$info_array = array();
		while($dbarray=mysql_fetch_array($result))
		{	$info_array[] = $dbarray;	}
		return $info_array;
	}
	
	function getRequestedBy($active)
	{
		$q = "Select R.requested_by_id, U.user_id, U.user_nm"
		   . " From tbl_requested_by As R"
		   . " Join tbl_user As U"
		   . " On R.user_id = U.user_id"
		   . " Where R.active = " . $active
		   . " Order By U.user_nm";

		$result = mysql_query($q, $this->connection);
		$info_array = array();
		while($dbarray=mysql_fetch_array($result))
		{	$info_array[] = $dbarray;	}
		return $info_array;
	}
	
	function getStatus()
	{
		$q = "Select * From tbl_status Order By sort_order";

		$result = mysql_query($q, $this->connection);
		$info_array = array();
		while($dbarray=mysql_fetch_array($result))
		{	$info_array[] = $dbarray;	}
		return $info_array;
	}
	
	function getAssignedTo($active)
	{
		$q = "Select A.assigned_to_id, U.user_id, U.user_nm"
		   . " From tbl_assigned_to As A"
		   . " Join tbl_user As U On A.user_id = U.user_id"
		   . " Where A.active = " . $active
		   . " Order By U.user_nm";
		   
		$result = mysql_query($q, $this->connection);
		$info_array = array();
		while($dbarray=mysql_fetch_array($result))
		{	$info_array[] = $dbarray;	}
		return $info_array;
	}
	
	function insertTask($task_ud, $task_nm, $task_desc, $importance_id, $urgency_id, $status_id, $dept_id, $section_id, $deadline_date, 
						$date_started, $date_completed, $requested_by_id, $task_type_id, $est_hours, $est_date_start, $est_date_complete,
						$user_def01, $user_def02, $user_def03, $user_def04, $user_def05, $date_created, $created_by)
	{ 
		$q0 = "Select task_id, task_nm, date_created, created_by From tbl_task Where task_ud = '" . $task_ud . "'";
		$result = mysql_query($q0, $this->connection);
		$array = mysql_fetch_array($result);
		$task_id=$array["task_id"];

		if(!$array["task_id"]=="")
		{	return "0This task already exists. Created on " . $array["date_created"] . " by " . $array["created_by"] . "(task_id:" . $array["task_id"] . ")";	}
		else
		{
			$q = "INSERT INTO tbl_task(task_ud, task_nm, task_desc, importance_id, urgency_id, status_id, dept_id, section_id, deadline_date, 
										date_started, date_completed, requested_by_id, task_type_id, estimated_hours, estimated_date_start, 
										estimated_date_complete, user_def01, user_def02, user_def03, user_def04, user_def05, date_created, created_by, date_modified, modified_by) Values ('" 
										. $task_ud . "', '" . $task_nm . "', '" . $task_desc . "', " . $importance_id . ", " . $urgency_id . ", " 
										. $status_id . ", " . $dept_id . ", " . $section_id . ", '" . $deadline_date . "', '" . $date_started . "', '" 
										. $date_completed . "', " . $requested_by_id . ", " . $task_type_id . ", '" . $estimated_hours . "', '" 
										. $estimated_date_start . "', '" . $estimated_date_complete . "', '" . $user_def01 . "', '" . $user_def02 . "', '" 
										. $user_def03 . "', '" . $user_def04 . "', '" . $user_def05 . "', '" . $date_created . "', '" . $created_by . "', Null, Null);";

			$result = mysql_query($q, $this->connection); 

			if($result)
			{	
				$result = mysql_query($q0, $this->connection);
				$array = mysql_fetch_array($result);
				return $array["task_id"]." - 1.".$user_def01."\n2.".$user_def02."\n3.".$user_def03."\n4.".$user_def04."\n5.".$user_def05;
			}
			else 
			{	return "0DATABASE ERROR (it's not your fault):<br />Query:<br />" . $q;	}			
		}
	}
	
	function getSummary($requested_by, $title, $extitle)
	{
	
		$q = "Select T.task_id, T.task_ud, T.task_desc, USR.user_nm, T.estimated_hours, T.date_created,"
		   . " I.importance_ud, S.status_ud, TY.task_type_ud, U.urgency_ud, USR.user_nm As requested_by"
		   . " From tbl_task As T"
		   . " Join tbl_importance As I On I.importance_id=T.importance_id"
		   . " Join tbl_status As S On S.status_id=T.status_id"
		   . " Join tbl_task_type As TY On TY.task_type_id=T.task_type_id"
		   . " Join tbl_urgency As U On U.urgency_id=T.urgency_id"
		   . " Join tbl_requested_by As R On R.requested_by_id = T.requested_by_id"
		   . " Join tbl_user As USR On USR.user_id = R.user_id";

		$where=" Where ";

		if($requested_by!="0")
		{	
			$q .= " Where T.requested_by_id='" . $requested_by . "'";	
			$where = " And "; 	
		}

		if($title!="")
		{	
			$q .= $where." T.task_ud Like '%" . $title . "%'";	
			$where=" And "; 	
		}

		if($extitle!="")
		{	
			$q .= $where." T.task_ud Not Like '%" . $extitle . "%'";	 	
		}

		$q .= " Order By Case When T.status_id In(5,6) Then 1 Else 0 End, U.sort_order, I.sort_order, S.sort_order, T.date_created";

		$result = mysql_query($q, $this->connection); 

		if($result)
		{	
			$result = mysql_query($q, $this->connection);
			$info_array = array();
			while($dbarray=mysql_fetch_array($result))
			{	$info_array[] = $dbarray;	}
			return $info_array;
		}
		else 
		{	return "0DATABASE ERROR (it's not your fault):<br />Query:<br />" . $q;	}	
	
	}
	
	function getSummaryHours($weekStart, $weekEnd, $task_id)
	{
		$q = "Select U.user_nm, sum(TH.hours) As actual_hours, Sum(Case When TH.date between '".$weekStart."' And '".$weekEnd."' Then TH.hours Else 0 End) As week_hours"
		   . " From tbl_task As T"
		   . " Join tbl_task_assign As TA On TA.task_id=T.task_id"
		   . " Join tbl_assigned_to As AT On AT.assigned_to_id = TA.assigned_to_id"
		   . " Join tbl_user As U On U.user_id = AT.user_id"
		   . " Left Outer Join tbl_task_hours As TH On TH.task_assign_id=TA.task_assign_id"
		   . " Where T.task_id=".$task_id
		   . " Group By U.user_nm"
		   . " Order By U.user_nm";

		$result = mysql_query($q, $this->connection); 
		   
		if($result)
		{	
			$result = mysql_query($q, $this->connection);
			$info_array = array();
			while($dbarray=mysql_fetch_array($result))
			{	$info_array[] = $dbarray;	}
			return $info_array;
		}
		else 
		{	return "0DATABASE ERROR (it's not your fault):<br />Query:<br />" . $q;	}	
	}
	
	function getInQueue($task_id)
	{
		$q0 = "Select Distinct TSH.task_id, TSH.status_change_date As on_hold_date 
		From tbl_task As T 
		Join tbl_task_status_history As TSH On TSH.task_id=T.task_id And TSH.new_status_id=3 
		Left Outer Join tbl_task_status_history As TSH2 On TSH2.task_id=T.task_id And TSH2.new_task_status_id=3 And TSH2.status_change_date>TSH.status_change_date
		Where T.task_id=".$task_id;
		
		$result = mysql_query($q, $this->connection); 
		   
		if($result)
		{	
			$result = mysql_query($q, $this->connection);
			$info_array = array();
			while($dbarray=mysql_fetch_array($result))
			{	$info_array[] = $dbarray;	}
			return $info_array;
		}
		else 
		{	return "0DATABASE ERROR (it's not your fault):<br />Query:<br />" . $q;	}	
	
	}
	
	function getTaskList($task_id, $task_ud, $importance, $urgency, $status, $type, $requestedby, $assignedto)
	{
		if($task_id!='')
		{
			$q ="Select T.*,TA.assigned_to_id From tbl_task As T";
			$q.=" Left Outer Join tbl_task_assign As TA on TA.task_id=T.task_id";
			$q.=" Where T.task_id=".$task_id;
			$q.=" Order By T.task_id";
		}
		else if($task_ud!='')
		{
			$q ="Select T.*,TA.assigned_to_id From tbl_task As T";
			$q.=" Left Outer Join tbl_task_assign As TA on TA.task_id=T.task_id";
			$q.=" Where T.task_ud Like '%".$task_ud."%'";
			$q.=" Order by T.task_id";
		}
		else
		{
			$q ="Select T.*,TA.assigned_to_id From tbl_task As T";
			$q.=" Left Outer Join tbl_task_assign As TA on TA.task_id=T.task_id";
			$where=" Where";

			if($importance!=0)
			{
				$q.=$where." T.importance_id=".$importance;
				$where=" And ";
			}

			if($urgency!=0)
			{
				$q.=$where." T.urgency_id=".$urgency;
				$where=" And ";
			}

			if($status!=0)
			{
				$q.=$where." T.status_id=".$status;
				$where=" And ";
			}

			if($type!=0)
			{
				$q.=$where." T.task_type_id=".$type;
				$where=" And ";
			}

			if($requestedby!='0')
			{
				$q.=$where." T.requested_by_id='".$requestedby."'";
				$where=" And ";
			}

			if($assignedto!='0')
			{
				$q.=$where." TA.assigned_to_id='".$assignedto."'";
			}

			$q.=" order by T.task_id";
		}

		$result = mysql_query($q, $this->connection); 
		   
		if($result)
		{	
			$result = mysql_query($q, $this->connection);
			$info_array = array();
			while($dbarray=mysql_fetch_array($result))
			{	$info_array[] = $dbarray;	}
			return $info_array;
		}
		else 
		{	return "0DATABASE ERROR (it's not your fault):<br />Query:<br />" . $q;	}	

	}
	
	function GetTaskAssignHours($task_assign_id)
	{
		$q2 = "Select TH.[date],TH.[hours]"
			. " From tbl_task_assign As TA"
			. " Join tbl_task_hours As TH"
			. " On TH.task_assign_id=TA.task_assign_id"
			. " Where TA.task_assign_id=".$task_assign_id
			. " Order by [date] desc";
			
		$result = mysql_query($q, $this->connection); 
		   
		if($result)
		{	
			$result = mysql_query($q, $this->connection);
			$info_array = array();
			while($dbarray=mysql_fetch_array($result))
			{	$info_array[] = $dbarray;	}
			return $info_array;
		}
		else 
		{	return "0DATABASE ERROR (it's not your fault):<br />Query:<br />" . $q;	}	
	
	}
	
};
$task_database = new MySQLDB;

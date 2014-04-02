<!DOCTYPE HTML>
<?php
include('php\configDB.php'); 
$info_array=array();
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Task List</title>
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
	<script type="text/javascript" src="js/checkUserSecurity.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>
	<script type="text/javascript" src="js/index.js"></script>
	<link rel="stylesheet" rev="stylesheet" href="css/index.css" type="text/css" media="screen" />
	<link rel="stylesheet" rev="stylesheet" href="css/indexPrint.css" type="text/css" media="print" />
<style type="text/css" media="screen">
/* <![CDATA[ */
@import url(css/jquery-ui-1.8.2.custom.css);
/* ]]> */
</style>
</head>
<body>
	<div id="divStatus"><img src="images/ajax-loader.gif"></div>

	<input type="text" id="load_task_id" class="hidden" name="load_task_id" value="<?php echo $_GET["task_id"]; ?>"></input>

	<div id="divNav">
		<a class="aNav" onclick="$('#divFilter').slideUp(); $('#divTaskList').slideUp(); $('#divSummary').slideUp(); $('#divNewTask').slideToggle();  $('#divTimesheet').slideUp(); $('#divTimeSummary').slideUp(); return false;" href="#">New Request</a><a class="aNav" onclick="$('#divNewTask').slideUp(); $('#divSummary').slideUp(); $('#divFilter').slideToggle(); $('#divTaskList').slideToggle(); $('#divTimesheet').slideUp(); $('#divTimeSummary').slideUp(); return false;" href="#">View Requests</a><a class="aNav" onclick="$('#divNewTask').slideUp(); $('#divFilter').slideUp(); $('#divTaskList').slideUp(); $('#divSummary').slideToggle(); $('#divTimesheet').slideUp(); $('#divTimeSummary').slideUp(); return false;" href="#">Summary</a>
		<a class="aNav" onclick="$('#divFilter').slideUp(); $('#divTaskList').slideUp(); $('#divSummary').slideUp(); $('#divNewTask').slideUp(); $('#divTimesheet').slideToggle(); $('#divTimeSummary').slideUp(); return false;" href="#">My Time</a><a class="aNav" onclick="$('#divFilter').slideUp(); $('#divTaskList').slideUp(); $('#divSummary').slideUp(); $('#divNewTask').slideUp(); $('#divTimesheet').slideUp(); $('#divTimeSummary').slideToggle(); return false;" href="#">Time Summary</a>
	</div>

	<div id="divNewTask">
		<h4>New Request</h4>
		<fieldset class="whole">
			<label for "add_task_ud">Title</label>
				<input type="text" id="add_task_ud" name="add_task_ud" class="task_ud" maxlength="32" onkeyup="jTitleCount(); return false;"></input>
				<span id="titleCount" name="titleCount" class="smallGrey">0 / 32</span>
		</fieldset><br />
<!--
		<fieldset>
			<label for "add_task_nm">Short Description</label>
				<input type="text" id="add_task_nm" name="add_task_nm" class="task_nm" maxlength="128"></input>
				<span id="shortDescCount" name="shortDescCount" class="smallGrey">0 / 128</span>
		</fieldset>
-->
		<fieldset class="whole">
			<label for "add_task_desc">Description</label>
				<textarea id="add_task_desc" name="add_task_desc" rows="4" class="add_task_nm" maxlength="256" 
				cols="70" onkeyup="jDescCount(); return false;"></textarea>
				<span id="descCount" name="descCount" class="smallGrey">0 / 256</span>
		</fieldset><br />
		
		<fieldset class="whole">
			<table class=\"tabRadio\">
				<?php $task_importance_id=3; include('php\importance_radio.php'); ?>
				<?php $task_urgency_id=3; include('php\urgency_radio.php'); ?>
			</table>
		</fieldset><br />
<!--
		<fieldset class="whole">
			<label for "add_selStatus">Status</label>
				<select id="add_selStatus" name="add_selStatus" class="sel">
					<?php //$task_status_id=3; include('php\status_drop_down.php'); ?>
				</select>
		</fieldset>
-->
		<fieldset class="qtr">
			<label for "add_selType">Type</label>
				<select id="add_selType" name="add_selType" class="sel">
					<?php $task_type_id=1; include('php\task_type_drop_down.php'); ?>
				</select>
		</fieldset>
		<fieldset class="qtr">
			<label for "add_selRequestedBy">Requested By</label>
				<select id="add_selRequestedBy" name="add_selRequestedBy" class="sel">
					<option value="0" selected="selected">Select ...</option>
					<?php include('php\requestedby_drop_down.php'); ?>
				</select>
		</fieldset>
		<a class="btn" onclick="jAddTask(); return false;">Add</a>
	</div>

	<div id="divFilter">
	<form id="formFilter">
		<fieldset><h4>View<br />Requests</h4></fieldset>
		<fieldset>
		<label for "selImportance">Importance</label>
			<select id="selImportance" name="selImportance" class="sel" onChange="document.getElementById('divTaskList').innerHTML=''">
				<option value="0" selected="selected">All</option>
				<?php $task_importance_id=0; include('php\importance_drop_down.php'); ?>
			</select>
		</fieldset>
		<fieldset>
		<label for "selUrgency">Urgency</label>
			<select id="selUrgency" name="selUrgency" class="sel" onChange="document.getElementById('divTaskList').innerHTML=''">
				<option value="0" selected="selected">All</option>
				<?php $task_urgency_id=0; include('php\urgency_drop_down.php'); ?>
			</select>
		</fieldset>
		<fieldset>
		<label for "selType">Type</label>
			<select id="selType" name="selType" class="sel" onChange="document.getElementById('divTaskList').innerHTML=''">
				<option value="0" selected="selected">All</option>
				<?php  $task_type_id=0; include('php\task_type_drop_down.php'); ?>
			</select>
		</fieldset>
		<fieldset>
		<label for "selStatus">Status</label>
			<select id="selStatus" name="selStatus" class="sel" onChange="document.getElementById('divTaskList').innerHTML=''">
				<option value="0" selected="selected">All</option>
				<?php $task_status_id=0; include('php\status_drop_down.php'); ?>
			</select>
		</fieldset>
		<fieldset>
		<label for "selRequestedBy">Requested by</label>
			<select id="selRequestedBy" name="selRequestedBy" class="sel" onChange="document.getElementById('divTaskList').innerHTML=''">
				<option value="0" selected="selected">All</option>
				<?php $task_requestedby_id=0; include('php\requestedby_drop_down.php'); ?>
			</select>
		</fieldset>
		<fieldset>
		<label for "selAssignedTo">Assigned to</label>
			<select id="selAssignedTo" name="selAssignedTo" class="sel" onChange="document.getElementById('divTaskList').innerHTML=''">
				<option value="0" selected="selected">All</option>
				<?php $task_assignedto_id=0; include('php\assignedto_drop_down.php'); ?>
			</select>
		</fieldset>
		<a class="btn" onclick="jLoading(); jLoadTasks(); jLoaded(); return false;">Search</a>

		&nbsp;&nbsp;&nbsp;<b>OR</b>&nbsp;
		<fieldset>
		<label for "txtSearchID">By ID</label>
			<input id="txtSearchID" name="txtSearchID" type="text" size="4"  onChange="document.getElementById('divTaskList').innerHTML=''"></input>
		</fieldset>
		<a class="btn" onclick="jLoading(); jLoadTaskByID(); jLoaded(); return false;" onChange="document.getElementById('divTaskList').innerHTML=''">Search</a>

		&nbsp;&nbsp;&nbsp;<b>OR</b>&nbsp;
		<fieldset>
		<label for "txtSearchUD">By Title</label>
			<input id="txtSearchUD" name="txtSearchUD" type="text" size="15"></input>
		</fieldset>
		<a class="btn" onclick="jLoading(); jLoadTaskByUD(); jLoaded(); return false;">Search</a>

	</form>
	</div>
	
	<div id="divSummary">
		<div id="divSummaryHeader">
			<fieldset style="width:10%;">
				<label for "summ_selRequestedBy">Requested By</label>
					<select id="summ_selRequestedBy" name="summ_selRequestedBy" class="sel">
						<option value="0" selected="selected">All</option>
						<?php include('php\requestedby_drop_down.php'); ?>
					</select>
			</fieldset>
			<fieldset>
			<label for "txtSummaryTitle">Filter by Title</label>
				<input id="txtSummaryTitle" name="txtSummaryTitle" type="text" size="15"></input>
			</fieldset>
			<fieldset>
			<label for "txtSummaryExTitle">Exclude by Title</label>
				<input id="txtSummaryExTitle" name="txtSummaryExTitle" type="text" size="15"></input>
			</fieldset>
			<fieldset>
			<label for "dtStart">Date Start</label>
					<script type="text/javascript">
						$(function() 
						{
							$("#dtStart").datepicker
							({
								defaultDate:0,
								changeYear:true, 
								changeMonth:true,
								yearRange:'c-3:c+1',
								showOn: 'button',
								buttonImage: 'images/iconCalendar.gif',
								buttonImageOnly: true
							});
						});
					</script>
					<!-- make this the first Tuesday of the year -->
					<input type="text" class="dateInput" id="dtStart" name="dtStart" size="9" value="<?php echo date("m/d/Y",strtotime("5 weeks ago last Wednesday")); ?>"></input>
			</fieldset>
			<fieldset>
			<label for "dtThisWeek">This week</label>
					<script type="text/javascript">
						$(function() 
						{
							$("#dtThisWeek").datepicker
							({
								defaultDate:0,
								changeYear:true, 
								changeMonth:true,
								yearRange:'c-3:c+1',
								showOn: 'button',
								buttonImage: 'images/iconCalendar.gif',
								buttonImageOnly: true
							});
						});
					</script>
				<input type="text" class="dateInput" id="dtThisWeek" name="dtThisWeek" size="9" value="<?php echo date("m/d/Y",strtotime("last Wednesday")); ?>"></input>
			</fieldset>
			<a class="btn" onclick="jGetSummary('php/getSummary.php'); return false;">Run v1</a>&nbsp;&nbsp;
			<a class="btn" onclick="jGetSummary('php/getSummary2.php'); return false;">Run v2</a><br /><br />

		</div>
		<div id="divSummaryContent"></div>
	</div>
	
	<div id="divTimeSummary">
		<div id="divTimeSummaryHeader">
			<fieldset>
			<label for "timesumm_dtStart">Date Range</label>
					<script type="text/javascript">
						$(function() 
						{
							$("#timesumm_dtStart").datepicker
							({
								defaultDate:0,
								changeYear:true, 
								changeMonth:true,
								yearRange:'c-3:c+1',
								showOn: 'button',
								buttonImage: 'images/iconCalendar.gif',
								buttonImageOnly: true
							});
						});
					</script>
				<input type="text" class="dateInput" id="timesumm_dtStart" name="timesumm_dtStart" size="9" value="<?php echo date("m/d/Y",strtotime("last Wednesday")); ?>"></input>&nbsp;-&nbsp;
					<script type="text/javascript">
						$(function() 
						{
							$("#timesumm_dtEnd").datepicker
							({
								defaultDate:0,
								changeYear:true, 
								changeMonth:true,
								yearRange:'c-3:c+1',
								showOn: 'button',
								buttonImage: 'images/iconCalendar.gif',
								buttonImageOnly: true
							});
						});
					</script>
				<input type="text" class="dateInput" id="timesumm_dtEnd" name="timesumm_dtEnd" size="9" value="<?php echo date('m/d/Y'); ?>"></input>
			</fieldset>

			<a class="btn" onclick="jGetTimeSummary(); return false;">Run</a><br /><br />

		</div>
		<div id="divTimeSummaryContent"></div>
	</div>
	
	<div id="divHistory">
		<div id="divHistoryContainer">
			<div id="divHistoryHead">
				<div id="divHistoryHead1"></div>
				<div id="divHistoryHead2"><a onclick="$('#divHistory').hide();" class="aX">x</a></div>
				<div id="divHistoryHead3"></div>
			</div>
			<div id="divHistoryContents"></div>
		</div>
		<div id="divHistoryFooter"> </div>
	</div>

	<div id="divTaskList"></div>

	<div id="divTimesheet">
	<form id="formTimesheet"">
		<div id="divTimesheetFilter">
			<fieldset>
			<label for "ts_assign_to">Developer</label>
				<select class="sel" id="ts_assign_to" name="ts_assign_to" onchange="document.getElementById('divTimesheetContent').innerHTML=''">
					<option value="" selected="selected"></option>
						<?php
								$task_assignedto_id=0;
								include('php\assignedto_drop_down.php');
						?>
				</select>
			</fieldset>
			<fieldset>
			<label for "dtTS_Start">Date Range</label>
					<script type="text/javascript">
						$(function() 
						{
							$("#dtTS_Start").datepicker
							({
								defaultDate:0,
								changeYear:true, 
								changeMonth:true,
								yearRange:'c-3:c+1',
								showOn: 'button',
								buttonImage: 'images/iconCalendar.gif',
								buttonImageOnly: true
							});
						});
					</script>
				<input type="text" class="dateInput" id="dtTS_Start" name="dtTS_Start" size="9" value="<?php echo date("m/d/Y",strtotime("last Wednesday")); ?>"></input>&nbsp;&nbsp;-&nbsp;
					<script type="text/javascript">
						$(function() 
						{
							$("#dtTS_End").datepicker
							({
								defaultDate:0,
								changeYear:true, 
								changeMonth:true,
								yearRange:'c-3:c+1',
								showOn: 'button',
								buttonImage: 'images/iconCalendar.gif',
								buttonImageOnly: true
							});
						});
					</script>
				<input type="text" class="dateInput" id="dtTS_End" name="dtTS_End" size="9" value="<?php echo date('m/d/Y'); ?>"></input>
			</fieldset>
			<br /><br />
			<a class="btn" onclick="jLoading(); jGetTimeSheet(); jLoaded(); return false;">Run</a>
		</div>
	</form>
		<div id="divTimesheetContent"></div>	
	</div>

	<div id="hidden">
		<span id="username" name="username"><?php $userArray=explode("\\",$_SERVER["AUTH_USER"]); echo $userArray[1]; ?></span>
	</div>
</body>
</html> 

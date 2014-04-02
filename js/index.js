var OnLoad = 'jInit()';
window.onload = function() {eval(OnLoad);};
var xmlHttp;

var status_change;

function jInit()
{
	jLoading();
	if (/msie/i.test (navigator.userAgent)) //only override IE
	{
	  document.nativeGetElementById = document.getElementById; 
	  document.getElementById = function(id)
	  {
		var elem = document.nativeGetElementById(id);
		if(elem)
		{
		  //make sure that it is a valid match on id
		  if(elem.attributes['id'].value == id)
		  {	return elem; }
		  else
		  {
			//otherwise find the correct element
			for(var i=1;i<document.all[id].length;i++)
			{
			  if(document.all[id][i].attributes['id'].value == id)
			  {	return document.all[id][i]; }
			}
		  }
		}
		return null;
	  }
	}

//	jLoadTasks();

//	document.getElementById("add_selRequestedBy").value=document.getElementById("username").innerHTML;

	if(document.getElementById("load_task_id").value!="")
	{
		$('#divFilter').slideToggle(); 
		$('#divTaskList').slideToggle();
		document.getElementById("txtSearchID").value=document.getElementById("load_task_id").value
		jLoadTaskByID();
	}

	jLoaded();
}

//*************************************************************************************************
function GetXmlHttpObject(xmlHttp)
{
	try
	{	xmlHttp=new XMLHttpRequest();	}
	catch (e)
	{	//Internet Explorer
		try	{	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");	}
		catch (e)
		{	try	{	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");	}
			catch (failed)	{	alert("This version of Internet Explorer does not support xmlHttp. Try another browser");	}
		}
	}
	return xmlHttp;
}

function jLoading()
{	$("#divStatus").show();	}

function jLoaded()
{	$("#divStatus").hide();	}

function jLoadTasks()
{
	document.getElementById("txtSearchID").value="";
	document.getElementById("txtSearchUD").value="";

	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url="php/getTaskList.php";
		url=url+"?task_id=";
		url=url+"&task_ud=";
		url=url+"&importance="+document.getElementById("selImportance").value;
		url=url+"&urgency="+document.getElementById("selUrgency").value;
		url=url+"&status="+document.getElementById("selStatus").value;
		url=url+"&type="+document.getElementById("selType").value;
		url=url+"&requestedby="+document.getElementById("selRequestedBy").value;
		url=url+"&assignedto="+document.getElementById("selAssignedTo").value;
		url=url+"&sid="+Math.random();
		
	xmlHttp = GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);
	
	document.getElementById("divTaskList").innerHTML=xmlHttp.responseText;
	$('#divTaskList').slideDown();

	url=null;
}

function jLoadTaskByID()
{
	document.getElementById("txtSearchUD").value="";

	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url="php/getTaskList.php";
		url=url+"?task_id="+document.getElementById("txtSearchID").value;
		url=url+"&sid="+Math.random();

	xmlHttp = GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);

	document.getElementById("divTaskList").innerHTML=xmlHttp.responseText;
	$('#divTaskList').slideDown();

	url=null;
}

function jLoadTaskByUD()
{
	document.getElementById("txtSearchID").value="";

	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url="php/getTaskList.php";
		url=url+"?task_ud="+document.getElementById("txtSearchUD").value;
		url=url+"&sid="+Math.random();

	xmlHttp = GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);

	document.getElementById("divTaskList").innerHTML=xmlHttp.responseText;
	$('#divTaskList').slideDown();

	url=null;
}

function jTaskDirty(task_id)
{
	$("#saveTask"+task_id).removeClass('btnDis');	
	$("#saveTask"+task_id).addClass('btn');	
}

function jTaskAssignDirty(task_id)
{
	$("#addAssign"+task_id).removeClass('btnDis');	
	$("#addAssign"+task_id).addClass('btn');	
}

function jAddHoursDirty(task_assign_id)
{
	$("#addHours"+task_assign_id).removeClass('btnDis');	
	$("#addHours"+task_assign_id).addClass('btn');	
}

function jAddTask()
{
	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url="php/insert_task.php"
		+"?task_ud="+encodeURI(document.getElementById("add_task_ud").value)
		+"&task_nm=Null"
		+"&desc="+encodeURI(document.getElementById("add_task_desc").value)
		+"&importance="+getRadioValue("radImportance")
		+"&urgency="+getRadioValue("radUrgency")
		+"&status=1"		// ??? DEFAULTED TO 1 = ENTERED
		+"&dept=Null"			// ??? For later use
		+"&section=Null"		// ??? For later use
		+"&deadline=Null"		// ??? For later use
		+"&requestedby="+document.getElementById("add_selRequestedBy").value
		+"&type="+document.getElementById("add_selType").value
		+"&est_hours=Null"			// ??? For later use
		+"&est_date_start=Null"			// ??? For later use
		+"&est_date_complete=Null"			// ??? For later use
		+"&user1=Null"			// ??? For later use
		+"&user2=Null"			// ??? For later use
		+"&user3=Null"			// ??? For later use
		+"&user4=Null"			// ??? For later use
		+"&user5=Null"			// ??? For later use
		+"&createdby=user"		// ??? Logged-in user id - for later use
		+"&sid="+Math.random();
		
	xmlHttp = GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);

	var x=xmlHttp.responseText;

	alert(x);

	if(x.substr(0,12)=='Task created')
	{	
		document.getElementById("add_task_ud").value="";
		document.getElementById("add_task_desc").value="";
		document.getElementById("add_selImportance").value="3";
		document.getElementById("add_selUrgency").value="3";
		document.getElementById("add_selType").value="Enhancement";
		document.getElementById("add_selRequestedBy").value=document.getElementById("username").innerHTML;
		$("#divNewTask").slideToggle();
	}

	x=url=null;
}

function jSaveTask(task_id)
{
	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url="php/update_task.php";
		url=url+"?task_id="+task_id;
		url=url+"&task_ud="+encodeURI(document.getElementById("task_ud"+task_id).value);
		url=url+"&requested_by="+encodeURI(document.getElementById("requested_by"+task_id).value);
		url=url+"&desc="+encodeURI(document.getElementById("task_desc"+task_id).value);
		url=url+"&importance="+document.getElementById("task_importance_id"+task_id).value;
		url=url+"&urgency="+document.getElementById("task_urgency_id"+task_id).value;
		url=url+"&type="+document.getElementById("task_type_id"+task_id).value;
		url=url+"&status="+document.getElementById("task_status_id"+task_id).value;
		url=url+"&estimated_date_start="+document.getElementById("estimated_date_start"+task_id).value;
		url=url+"&estimated_date_complete="+document.getElementById("estimated_date_complete"+task_id).value;
		url=url+"&est_hrs="+document.getElementById("estimated_hours"+task_id).value;
		url=url+"&deadline_date="+document.getElementById("deadline_date"+task_id).value;
		url=url+"&old_status="+document.getElementById("old_status"+task_id).innerHTML;
//		url=url+"&date_started="+document.getElementById("date_started"+task_id).value;
//		url=url+"&date_completed="+document.getElementById("date_completed"+task_id).value;
		url=url+"&sid="+Math.random();

	xmlHttp = GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);

	var x=xmlHttp.responseText;

	if(x.substr(0,12)=='Task updated')
	{	
		$("#saveTask"+task_id).removeClass('btn');	
		$("#saveTask"+task_id).addClass('btnDis');	
	}
	else
	{	alert(x+"\n"+url);	}

	x=url=null;
}

function jaddAssignTask(task_id)
{
	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url="php/insert_task_assign.php";
		url=url+"?task_id="+task_id;
		url=url+"&assigned_to="+encodeURI(document.getElementById("assign_to"+task_id).value);
		url=url+"&sid="+Math.random();

	xmlHttp = GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);

	var x=xmlHttp.responseText;

	if(x.substr(0,12)=='Task updated')
	{	
		if(document.getElementById("txtSearchID").value!="")
		{	jLoadTaskByID();	}
		else if(document.getElementById("txtSearchUD").value!="")
		{	jLoadTaskByUD();	}
		else
		{	jLoadTasks();	}
	}
	else
	{	alert(x+"\n"+url);	}

	x=url=null;
}

function jRmvAss(task_assign_id)
{
	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url="php/delete_task_assign.php";
		url=url+"?task_assign_id="+task_assign_id;
		url=url+"&sid="+Math.random();

	xmlHttp = GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);

	var x=xmlHttp.responseText;

	if(x.substr(0,12)=='Task removed')
	{	
		if(document.getElementById("txtSearchID").value!="")
		{	jLoadTaskByID();	}
		else if(document.getElementById("txtSearchUD").value!="")
		{	jLoadTaskByUD();	}
		else
		{	jLoadTasks();	}
	}
	else
	{	alert(x+"\n"+url);	}

	x=url=null;	
}

function jaddHours(task_assign_id)
{
	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url="php/insert_task_hours.php";
		url=url+"?task_assign_id="+task_assign_id;
		url=url+"&date="+document.getElementById("add_hours_date"+task_assign_id).value;
		url=url+"&hours="+document.getElementById("add_hours"+task_assign_id).value;
		url=url+"&sid="+Math.random();

	xmlHttp = GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);

	var x=xmlHttp.responseText;

	if(x.substr(0,11)=='Hours added')
	{
		if(document.getElementById("txtSearchID").value!="")
		{	jLoadTaskByID();	}
		else if(document.getElementById("txtSearchUD").value!="")
		{	jLoadTaskByUD();	}
		else
		{	jLoadTasks();	}
	}
	else
	{	alert(x+"\n"+url);	}

	x=url=null;
}

function jGetSummary(php)
{
	document.getElementById("divSummaryContent").innerHTML="Loading...";

	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url=php;
		url=url+"?requested_by="+document.getElementById("summ_selRequestedBy").value;
		url=url+"&title="+document.getElementById("txtSummaryTitle").value;
		url=url+"&extitle="+document.getElementById("txtSummaryExTitle").value;
		url=url+"&start_date="+document.getElementById("dtStart").value;
		url=url+"&dtThisWeek="+document.getElementById("dtThisWeek").value;
		url=url+"&sid="+Math.random();
	
	xmlHttp = GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);

	document.getElementById("divSummaryContent").innerHTML=xmlHttp.responseText;

	url=null;

}

function jShowStatusHistory(task_id, task_ud)
{
	$("#divHistory").show();
	document.getElementById("divHistoryContents").innerHTML="Loading...";
	document.getElementById("divHistoryHead1").innerHTML=task_id+". "+task_ud;

	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url="php/getTaskHistory.php";
		url=url+"?task_id="+task_id;
		url=url+"&sid="+Math.random();

	xmlHttp=GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);

	document.getElementById("divHistoryContents").innerHTML=xmlHttp.responseText;
	
	url=null;
}

function jGetTimeSheet()
{
	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url="php/getMyTimesheet.php";
		url=url+"?assign_id="+document.getElementById("ts_assign_to").value;
		url=url+"&from="+document.getElementById("dtTS_Start").value;
		url=url+"&thru="+document.getElementById("dtTS_End").value;
		url=url+"&sid="+Math.random();

	xmlHttp=GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);

	document.getElementById("divTimesheetContent").innerHTML=xmlHttp.responseText;
	
	url=null;
}

function jGetTimeSummary()
{
	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url="php/getTimeSummary.php";
		url=url+"?from="+document.getElementById("timesumm_dtStart").value;
		url=url+"&thru="+document.getElementById("timesumm_dtEnd").value;
		url=url+"&sid="+Math.random();

	xmlHttp=GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);

	document.getElementById("divTimeSummaryContent").innerHTML=xmlHttp.responseText;
	
	url=null;
}

function jDeleteTaskHours(task_hours_id)
{
	xmlHttp=GetXmlHttpObject(xmlHttp);

	var url="php/deleteTaskHours.php";
		url=url+"?task_hours_id="+task_hours_id;
		url=url+"&sid="+Math.random();

	xmlHttp=GetXmlHttpObject();
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);

	jGetTimeSheet();
	
	url=null;
}

function jTitleCount()
{
	var taskTitle=document.getElementById("add_task_ud").value;
	document.getElementById("titleCount").innerHTML=taskTitle.length.toString()+" / 32";
	taskTitle=null;
}

function jDescCount()
{
	var taskDesc=document.getElementById("add_task_desc").value;
	document.getElementById("descCount").innerHTML=taskDesc.length.toString()+" / 256";
	taskTitle=null;
}

function getRadioValue(radioboxGroupName)
{
    group=document.getElementsByName(radioboxGroupName);
    for (x=0;x<group.length;x++)
    {
        if (group[x].checked)
        {
            return (group[x].value);
        }
    }
    return (false);
}

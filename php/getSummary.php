<?php
include('configDB.php');
$info_array=array();
$info_array2=array();

$result=$task_database->getSummary( $_GET['requested_by'], $_GET['title'], $_GET['extitle']);

if(!is_array($result))
{
	echo substr($result, 1, strlen($result)-1);
}
else
{
	$info_array=$result;

	$w01=strToTime($_GET['start_date']); 
	$w01a=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+6 days');
	$w02=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+7 days');
	$w02a=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+13 days');
	$w03=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+14 days');
	$w03a=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+20 days');
	$w04=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+21 days');
	$w04a=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+27 days');
	$w05=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+28 days');
	$w05a=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+34 days');
	$w06=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+35 days');
	$w06a=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+41 days');
	$w07=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+42 days');
	$w07a=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+48 days');
	$w08=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+49 days');
	$w08a=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+55 days');
	$w09=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+56 days');
	$w09a=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+62 days');
	$w10=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+63 days');
	$w10a=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+69 days');
	$w11=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+70 days');
	$w11a=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+76 days');
	$w12=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+77 days');
	$w12a=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+83 days');
	$w13=strToTime(date("Y-m-d", strToTime($_GET['start_date'])).'+84 days');

	echo "<table class=\"tabCalendar\">";

	echo "<thead class=\"theadHeaderFirst\">";
		echo "<td colspan=\"2\"></td>";
		echo "<td class=\"tdCenter\">Status</td>";
		echo "<td class=\"tdCenter\">Imp</td>";
		echo "<td class=\"tdCenter\">Urg</td>";
		echo "<td class=\"tdCenter\">Est<br />Hrs</td>";
		echo "<td class=\"tdCenter\">Act<br />Hrs</td>";
		echo "<td class=\"tdCenter\">This<br />Wk</td>";
		echo "<td class=\"tdCenter\">%<br />Cmplt</td>";
		echo "<td class=\"tdCal\">".date("n/j", $w01)."</td>";
		echo "<td class=\"tdCal\">".date("n/j", $w02)."</td>";
		echo "<td class=\"tdCal\">".date("n/j", $w03)."</td>";
		echo "<td class=\"tdCal\">".date("n/j", $w04)."</td>";
		echo "<td class=\"tdCal\">".date("n/j", $w05)."</td>";
		echo "<td class=\"tdCal\">".date("n/j", $w06)."</td>";
	//	echo "<td class=\"tdCal\">".date("n/j", $w07)."</td>";
	//	echo "<td class=\"tdCal\">".date("n/j", $w08)."</td>";
	//	echo "<td class=\"tdCal\">".date("n/j", $w09)."</td>";
	//	echo "<td class=\"tdCal\">".date("n/j", $w10)."</td>";

	//	echo "<td class=\"tdCal\">".date("n/j", $w11)."</td>";
	//	echo "<td class=\"tdCal\">".date("n/j", $w12)."</td>";
	//	echo "<td class=\"tdCal\">".date("n/j", $w13)."</td>";
	echo "</thead>";

	$estimatedTot=0;

	foreach ($info_array as $record)
	{
		if($trClass=="tr1")
		{	$trClass="tr2";	}
		else
		{	$trClass="tr1";	}

		echo "<tr class=\"".$trClass."\">";
			echo "<td class=\"tdCenter tdTop\">";
				echo "<a href=\"../task/index.php?task_id=".$record['task_id']."\" target=\"_blank\">".$record['task_id']."</a>";
			echo "</td>";
			echo "<td>";
				echo "<a href=\"#\" onclick=\"jShowStatusHistory(".$record['task_id'].",'".$record['task_ud']."')\">".$record['task_ud']."</a>";
				if($record['task_desc']!=$record['task_ud'])
				{	echo "<br /><span class=\"smallGrey\">".$record['task_desc']."</span>";	}
				echo "<br /><span class=\"smallGrey\">Requested by ".$record['requested_by']." on ";
				echo substr($record['date_created'],5,2)."/"
					.substr($record['date_created'],8,2)."/"
					.substr($record['date_created'],0,4)." at ".substr($record['date_created'],11,5);
				$assigned=0;
				
				$weekStart=date("Y-m-d 00:00:00.000", strToTime($_GET['dtThisWeek']));
				$weekEnd=date("Y-m-d 23:59:59.997", strToTime($_GET['dtThisWeek'].'+6 days'));

				$result=$task_database->getSummaryHours( $weekStart, $weekEnd, $record['task_id'] );

				$actualHours=0;
				$weekHours=0;

				if(is_array($result))
				{
					$info_array2=$result;
					foreach ($info_array2 as $record2)
					{
						if($assigned>0)
						{	echo ", ";	} 
						else 
						{	echo "Assigned to ";	}
						echo $record2['assigned_to'];
						$actualHours+$record2['actual_hours'];
						$weekHours+=$record2['week_hours'];
						$assigned++;
					}
				}
				
			$actHrsTot+=$actualHours;
			$thisWeekHrsTot+=$weekHours;

			echo "</span></td>";
			$class="tdX".str_replace(" ","",$record['status_ud']);
			echo "<td class=\"tdCenter ".$class."\">".$record['status_ud']."</td>";
			echo "<td class=\"tdCenter\">".$record['importance_ud']."</td>";
			echo "<td class=\"tdCenter\">".$record['urgency_ud']."</td>";

		/*********/
		/* Hours */
		/*********/
		echo "<td class=\"tdCenter\">".$record['estimated_hours']."</td>";
		echo "<td class=\"tdCenter\">".$actualHours."</td>";
		echo "<td class=\"tdCenter\">".$weekHours."</td>";

		$estimatedTot+=$record['estimated_hours'];

		if($actualHours!=0 && $actualHours < $record['estimated_hours'])
		{	$pcntComp=($actualHours / $record['estimated_hours'])*100;	}
		else
		{	$pcntComp=0;	}

		echo "<td class=\"tdCenter\">".number_format($pcntComp)."%</td>";
			
		/************/
		/* In Queue */
		/************/
		$d01="";$d02="";$d03="";$d04="";$d05="";$d06="";$d07="";$d08="";$d09="";$d10="";$d11="";$d12="";
		$w01Class="";$w02Class="";$w03Class="";$w04Class="";$w05Class="";$w06Class="";$w07Class="";$w08Class="";$w09Class="";$w10Class="";$w11Class="";$w12Class="";
		
		$result=$task_database->getInQueue( $record['task_id'] );

		if(is_array($result))
		{
			$info_array3=$result;
			foreach ($info_array3 as $record3)
			{
				$date_started=strToTime($record3['on_hold_date']);
	
				if($record3['off_hold_date'] == "")
				{	$date_completed=strToTime(date('Y-m-d'));	}
				else
				{	$date_completed=strToTime($record3['off_hold_date']);	}

				if($date_started <= $w02 && $date_completed >= $w01)
				{	$w01Class=" tdInQueue";		}
				if($date_started <= $w03 && $date_completed >= $w02)
				{	$w02Class=" tdInQueue";		}
				if($date_started <= $w04 && $date_completed >= $w03)
				{	$w03Class=" tdInQueue";		}
				if($date_started <= $w05 && $date_completed >= $w04)
				{	$w04Class=" tdInQueue";		}
				if($date_started <= $w06 && $date_completed >= $w05)
				{	$w05Class=" tdInQueue";		}
				if($date_started <= $w07 && $date_completed >= $w06)
				{	$w06Class=" tdInQueue";		}
				if($date_started <= $w08 && $date_completed >= $w07)
				{	$w07Class=" tdInQueue";		}
				if($date_started <= $w09 && $date_completed >= $w08)
				{	$w08Class=" tdInQueue";		}
				if($date_started <= $w10 && $date_completed >= $w09)
				{	$w09Class=" tdInQueue";		}
				if($date_started <= $w11 && $date_completed >= $w10)
				{	$w10Class=" tdInQueue";		}
				if($date_started <= $w12 && $date_completed >= $w11)
				{	$w11Class=" tdInQueue";		}
				if($date_started <= $w13 && $date_completed >= $w12)
				{	$w12Class=" tdInQueue";		}
			}
		}
			echo "<td class=\"tdCenter ".$w01Class."\">".$h01."</td>";
			echo "<td class=\"tdCenter ".$w02Class."\">".$h02."</td>";
			echo "<td class=\"tdCenter ".$w03Class."\">".$h03."</td>";
			echo "<td class=\"tdCenter ".$w04Class."\">".$h04."</td>";
			echo "<td class=\"tdCenter ".$w05Class."\">".$h05."</td>";
			echo "<td class=\"tdCenter ".$w06Class."\">".$h06."</td>";
	//		echo "<td class=\"tdCenter ".$w07Class."\">".$h07."</td>";
	//		echo "<td class=\"tdCenter ".$w08Class."\">".$h08."</td>";
	//		echo "<td class=\"tdCenter ".$w09Class."\">".$h09."</td>";

	//		echo "<td class=\"tdCenter ".$w10Class."\">".$h10."</td>";
	//		echo "<td class=\"tdCenter ".$w11Class."\">".$h11."</td>";
	//		echo "<td class=\"tdCenter ".$w12Class."\">".$h12."</td>";

			$tot01+=$h01;
			$tot02+=$h02;
			$tot03+=$h03;
			$tot04+=$h04;
			$tot05+=$h05;
			$tot06+=$h06;
	//		$tot07+=$h07;
	//		$tot08+=$h08;
	//		$tot09+=$h09;
	//		$tot10+=$h10;
	//		$tot11+=$h11;
	//		$tot12+=$h12;

		echo "</tr>";

		$totrequestCount++;
	}

		echo "<tr>";
			echo "<td colspan=\"12\">&nbsp;</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td colspan=\"2\" class=\"tdTotal\">Total</td>";
			echo "<td colspan=\"3\" class=\"tdCenter\"><b>".number_format($totrequestCount)." tasks</b></td>";
			echo "<td class=\"tdTotal\">".number_format($estimatedTot)."</td>";
			echo "<td class=\"tdTotal\">".number_format($actHrsTot)."</td>";
			echo "<td class=\"tdTotal\">".number_format($thisWeekHrsTot)."</td>";
			echo "<td class=\"tdTotal\"></td>";
			echo "<td class=\"tdTotal\">".$tot01."</td>";
			echo "<td class=\"tdTotal\">".$tot02."</td>";
			echo "<td class=\"tdTotal\">".$tot03."</td>";
			echo "<td class=\"tdTotal\">".$tot04."</td>";
			echo "<td class=\"tdTotal\">".$tot05."</td>";
			echo "<td class=\"tdTotal\">".$tot06."</td>";
	//		echo "<td class=\"tdCenter tdBold\">".$tot07."</td>";
	//		echo "<td class=\"tdCenter tdBold\">".$tot08."</td>";
	//		echo "<td class=\"tdCenter tdBold\">".$tot09."</td>";

	//		echo "<td class=\"tdCenter tdBold\">".$tot10."</td>";
	//		echo "<td class=\"tdCenter tdBold\">".$tot11."</td>";
	//		echo "<td class=\"tdCenter tdBold\">".$tot12."</td>";

		echo "</tr>";
	echo "</table>";
}

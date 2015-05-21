
<?
function showMonth($month, $year)
{
    global $connect;
    $sql = "select timestart from lms_calender where (deptID=\"$deptID\" or deptID=0)";
    $result = sql_query($sql, $connect);
    $row = sql_fetch_row($result);
    $date = mktime(12, 0, 0, $month, 1, $year);
    $daysInMonth = date("t", $date);
    // calculate the position of the first day in the calendar (sunday = 1st column, etc)
    $offset = date("w", $date);
    $rows = 1;


    /* navigate between months */
    $tmp_next_month =  mktime(0,0,0,$month+1,1,$year);
    $next_month =  date("m", $tmp_next_month);
    $next_year =  date("Y", $tmp_next_month);
    $tmp_prev_month = mktime(0,0,0,$month-1,1,$year);
    $prev_month = date("m", $tmp_prev_month);
    $prev_year = date("Y", $tmp_prev_month);
	
    /********************************************************/

    echo "<table class=\"maincalendar\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";   
    echo "<tr><th colspan=\"7\">
		  
		  <span class=\"leftarr\">
	      <a href=\"#\" onClick=\"change_month($prev_month,$prev_year,'calendar','ajax_change_month.php'); return false;\">
		  <img src=\"../libcommon/images/common/spacer.png\" style=\"width:25px; height:16px; display:block;\" border=\"0\" />
		  </a>
		  </span>
		  
		  <span class=\"calendarHead\">".date("F Y", $date)."</span>
		  
		  <span class=\"rightarr\">
	      <a href=\"#\" onClick=\"change_month($next_month,$next_year,'calendar','ajax_change_month.php'); return false;\">
		  <img src=\"../libcommon/images/common/spacer.png\" style=\"width:25px; height:16px; display:block;\" border=\"0\" />
		  </a>
		  </span>
		  
		  </th></tr>";
    echo "\t<tr><td>Su</td><td>Mo</td><td>Tu</td><td>We</td><td>Th</td><td>Fr</td><td>Sa</td></tr>";
    echo "\n\t<tr>";

    for($i = 1; $i <= $offset; $i++)
    {
        echo "<td></td>";
    }
    for($day = 1; $day <= $daysInMonth; $day++)
    {
        if( ($day + $offset - 1) % 7 == 0 && $day != 1)
        {
            echo "</tr>\n\t<tr>";
            $rows++;
       	    echo "<td id=\"holi\">" . $day . "</td>"; //for holidays
        }
	else {
     
   	     echo "<td>" . $day . "</td>";
	}
		
		//echo "<td id=\"holi\">" . $day . "</td>"; //for holidays
    }
    while( ($day + $offset) <= $rows * 7)
    {
        echo "<td></td>";
        $day++;
    }
    echo "</tr>\n";
    echo "</table>\n"; 
}

function showMonthPlacement($day1, $month, $year)
{
    global $connect;
    $sql = "select timestart from lms_calender where (deptID=\"$deptID\" or deptID=0)";
    $result = sql_query($sql, $connect);
    $row = sql_fetch_row($result);
    $date = mktime(12, 0, 0, $month, 1, $year);
    $daysInMonth = date("t", $date);
    // calculate the position of the first day in the calendar (sunday = 1st column, etc)
    $offset = date("w", $date);
    $rows = 1;

	$day = $year."-".$month."-".$day1;
	
	$daytoday = $year."-".$month."-01";

	$tmp_prev_month = new DateTime($day);	
	$tmp_next_month = new DateTime($day);
	
	$tmp_prev_month -> format('Y-m-d');
	$tmp_next_month -> format('Y-m-d');
	
	$tmp_prev_month->modify('-1 month');
	$tmp_next_month->modify('+1 month');
	
	$next_month = date_format($tmp_next_month, 'm');
	$next_year = date_format($tmp_next_month, 'Y');
	
	$prev_month = date_format($tmp_prev_month, 'm');
	$prev_year = date_format($tmp_prev_month, 'Y');

    /* navigate between months 
    $tmp_next_month =  mktime(0,0,0,$month+1,1,$year);
    $next_month =  date("m", $tmp_next_month);
    $next_year =  date("Y", $tmp_next_month);
    $tmp_prev_month = mktime(0,0,0,$month-1,1,$year);
    $prev_month = date("m", $tmp_prev_month);
    $prev_year = date("Y", $tmp_prev_month);*/
	
    /********************************************************/
	//echo "<div class=\"table-responsive col-md-12\">";
    echo "<table class=\"table table-bordered\" style='cursor:pointer;' >";   
    echo "<tr class='' >";
		echo "<th colspan=\"7\" >
			<a href=\"#\" style='float:left;' onClick=\"change_month($day1, $prev_month,$prev_year,'calendar','ajax_change_month.php'); return false;\">
			<img src=\"../libcommon/images/left_nav1.png\" style=\"width:2	5px; height:16px; display:block;\" border=\"0\" />
		  </a> ";
		  
		  echo "<span style='padding-left:40%;' >".date("F Y", $date)."</span>";
		  
		  echo "
	      <a href=\"#\" style='float:right;' onClick=\"change_month($day1, $next_month,$next_year,'calendar','ajax_change_month.php'); return false;\">
		  <img src=\"../libcommon/images/right_nav1.png\" style=\"width:25px; height:16px; display:block;\" border=\"0\" />
		  </a>
		  </th>";
		  
		echo "</tr>";
    echo "<tr class='' ><td>Sun</td><td>Mon</td><td>Tue</td><td>Wen</td><td>Thu</td><td>Fri</td><td>Sat</td></tr>";
    echo "<tr>";
    
    $days = new DateTime($daytoday);	

    for($i = 1; $i <= $offset; $i++)
    {
        echo "<td></td>";
    }
    for($day = 1; $day <= $daysInMonth; $day++)
    {
		$days1 = date_format($days, 'Y-m-d');
		
		$sql = " SELECT notification_id, title FROM placement_notification WHERE start_time LIKE \"".$days1."%\" ";
		$res = sql_query($sql, $connect);
		
		$id = "";
		
		unset($title);
		while($row = sql_fetch_row($res))
		{
			if($id != "")
				$id = $id.",".$row[0];
			else
				$id = $row[0];
				
			$title[] = $row[1];
		}
		
		//print_r($title);
		
		if($id == "")
		{
			$id = "0";
		}
		
        if( ($day + $offset - 1) % 7 == 0 && $day != 1)
        {
            echo "</tr><tr>";
            $rows++;
            if($day1 == $day)
            {
				if(!$id)
				{
					echo "<td id=\"holi\" class='' style='height: 80px;margin-top:0;cursor:pointer;' data-toggle=\"modal\" data-target='#myModal".$day."' onclick='list_event('$day', '$month', '$year', \"".$id."\");' >"; //for holidays
					
						echo $day;
					
					echo "</td>";
				}
				else
				{
					echo "<td id=\"holi\" class='' style='height: 80px;margin-top:0;cursor:pointer;' data-toggle=\"modal\" data-target='#myModal".$day."' onclick='list_event('$day', '$month', '$year', \"".$id."\");' >"; //for holidays
					
						echo $day;
						
						
					echo "<div class='row' >";
					
						echo "<div class='' >";
						if (is_array($title))
						{
							foreach($title as $tit)
							{
								echo "<div class='fc-event-hori exam' style='padding:0;' >".substr($tit, 0, 5)."</div>";
							}
						}
						echo "</div>";
					
					echo "</div>";
					
					echo "</td>";
				}
				
							echo "<div class='modal fade' id='myModal".$day."' >
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
											<h4 class='modal-title'>$days1</h4>
										</div>
										<div class='modal-body' id='$day' > ";
										echo "</div>
										<div class='modal-footer'>
											<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
										</div>
									</div>
								</div>
							</div> ";
				
			}
			else
			{
				if(!$id)
				{
					echo "<td id=\"holi\" class='' style='height: 80px;margin-top:0;cursor:pointer;' data-toggle=\"modal\" data-target='#myModal".$day."' onclick='list_event($day, $month, $year, \"".$id."\");' >"; //for holidays
					
						echo $day;
					
					echo "</td>";
				}
				else
				{
					echo "<td id=\"holi\" class='' style='height: 80px;margin-top:0;cursor:pointer;' data-toggle=\"modal\" data-target='#myModal".$day."' onclick='list_event($day, $month, $year, \"".$id."\");' >"; //for holidays
					
						echo $day;
						
						
					echo "<div class='row' >";
					
						echo "<div class='' >";
						if (is_array($title))
						{
							foreach($title as $tit)
							{
								echo "<div class='fc-event-hori exam' style='padding:0;' >".substr($tit, 0, 5)."</div>";
							}
						}
						echo "</div>";
					
					echo "</div>";
					
					echo "</td>";
				}
				
							echo "<div class='modal fade' id='myModal".$day."' >
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
											<h4 class='modal-title'>$days1</h4>
										</div>
										<div class='modal-body' id='$day' > ";
											
										echo "</div>
										<div class='modal-footer'>
											<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
										</div>
									</div>
								</div>
							</div> ";
				
			}
        }
	else {
		if($day1 == $day)
		{
			
			if(!$id)
			{
				echo "<td id=\"holi\" class= '' style='height: 80px;margin-top:0;cursor:pointer;' data-toggle=\"modal\" data-target='#myModal".$day."' onclick='list_event($day, $month, $year, \"".$id."\");' >"; //for holidays
				
						echo $day;
				
				echo "</td>";
			}
			else
			{
				echo "<td id=\"holi\" class='' style='height: 80px;margin-top:0;cursor:pointer;' data-toggle=\"modal\" data-target='#myModal".$day."' onclick='list_event($day, $month, $year, \"".$id."\");' >"; //for holidays
				
						echo $day;
						
						
					echo "<div class='row' >";
					
						echo "<div class='' >";
						if (is_array($title))
						{
							foreach($title as $tit)
							{
								echo "<div class='fc-event-hori exam' style='padding:0;' >".substr($tit, 0, 5)."</div>";
							}
						}
						echo "</div>";
					
					echo "</div>";
				
				echo "</td>";
			}
				
							echo "<div class='modal fade' id='myModal".$day."' >
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
											<h4 class='modal-title'>$days1</h4>
										</div>
										<div class='modal-body' id='$day' > ";
											
										echo "</div>
										<div class='modal-footer'>
											<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
										</div>
									</div>
								</div>
							</div> ";
			
		}
		else
		{
			if(!$id)
			{
				echo "<td id=\"holi\" class='' style='height: 80px;margin-top:0;cursor:pointer;' data-toggle=\"modal\" data-target='#myModal".$day."' onclick='list_event($day, $month, $year, \"".$id."\");' >"; //for holidays
				
						echo $day;
				
				echo "</td>";
			}
			else
			{
				echo "<td id=\"holi\" class='' style='height: 80px;margin-top:0;cursor:pointer;' data-toggle=\"modal\" data-target='#myModal".$day."' onclick='list_event($day, $month, $year, \"".$id."\");' >"; //for holidays
						echo $day;
					
					
					echo "<div class='row' >";
					
						echo "<div class='' >";
						if (is_array($title))
						{
							foreach($title as $tit)
							{
								echo "<div class=' fc-event-hori  exam' style='padding:0;' >".substr($tit, 0, 5)."</div>";
							}
						}
						echo "</div>";
					
					echo "</div>";
				
				echo "</td>";
			}
				
				
							echo "<div class='modal fade' id='myModal".$day."' >
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
											<h4 class='modal-title'>$days1</h4>
										</div>
										<div class='modal-body' id='$day' > ";
											
										echo "</div>
										<div class='modal-footer'>
											<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
										</div>
									</div>
								</div>
							</div> ";
			
		}
	}
		
		$days->modify('+1 day');
		//echo "<td id=\"holi\">" . $day . "</td>"; //for holidays
    }
    while( ($day + $offset) <= $rows * 7)
    {
        echo "<td></td>";
        $day++;
    }
    echo "</tr>";
    echo "</table>"; 
    //echo "</div>";
}

?>

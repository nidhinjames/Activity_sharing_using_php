<?
	function xlsBOF() {
                echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
                return;
        }
        function xlsEOF() {
                echo pack("ss", 0x0A, 0x00);
                return;
        }
        function xlsWriteNumber($Row, $Col, $Value) {
                echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
                echo pack("d", $Value);
                return;
        }
        function xlsWriteLabel($Row, $Col, $Value ) { 
                $L = strlen($Value);
                echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
                echo $Value;
                return;
        }
	function nextDay($date) 
	{
	        $arr = explode("-", $date);
	        return date("Y-m-d",(mktime(0,0,0,$arr[1],$arr[2], $arr[0]) + (24*60*60)));
	}
	function nextNDay($date, $N, $incHoliday = true)
	{
	    $i = 0;
	    while ($i<$N)
	    {   
	      $date = nextDay($date);
	      $arr = explode("-", $date);
	      $i++;
	    }   
	  return $date;
	}
	function calculating_staffreturndate($ret_date, $deptID)
	{
	                        global $connect;
	
	                        $sql ="select holiday from library_staffcalendar where deptID = ".$deptID." AND holiday >=\"".$ret_date."\" ORDER BY holiday";
	                        $result = sql_query($sql, $connect);
	                        $b=0;
	                        while($row = sql_fetch_row($result))
	                        {
	                                if($row[0] == $ret_date)
	                                {
	                                        $ret_date = nextNDay($ret_date, 1);
	                                        $b++;
	                                        //echo $date;
	                                }
	                                else if($b!=0)
	                                {
	                                        break;
	                                }
	                        }
	                        $find_holiday['ret_date'] = $ret_date;
	                        $find_holiday['count_day'] = $b;
	                        return $find_holiday;
	}
	function calculating_studentreturndate($ret_date, $deptID, $batchID)
	{
	                        global $connect;
	
	                        $sql ="select holiday from library_studentcalendar where deptID = ".$deptID." AND batchID = ".$batchID." AND holiday >=\"".$ret_date."\" ORDER BY holiday";  
	                        $result = sql_query($sql, $connect);
	                        $b=0;
	                        while($row = sql_fetch_row($result))
	                        {
	                                if($row[0] == $ret_date)
	                                {
	                                        $ret_date = nextNDay($ret_date, 1);
	                                        $b++;
	                                        //echo $date;
	                                }
	                                else if($b!=0)
	                                {
	                                        break;
	                                }
	                        }
	                        $find_holiday['ret_date'] = $ret_date;
	                        $find_holiday['count_day'] = $b;
	                        return $find_holiday;
	}
?>
